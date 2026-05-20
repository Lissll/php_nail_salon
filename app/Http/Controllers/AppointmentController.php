<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DailyServicePromotion;
use App\Models\Service;
use App\Models\ServiceCombo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isManager()) {
            $appointments = Appointment::with(['client', 'service', 'master'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        } elseif ($user->isMaster()) {
            $appointments = Appointment::with(['client', 'service'])
                ->where('master_id', $user->id)
                ->orderBy('appointment_date', 'asc')
                ->get();
        } else {
            $appointments = Appointment::with(['service', 'master'])
                ->where('client_id', $user->id)
                ->orderBy('appointment_date', 'desc')
                ->get();
        }
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        $masters = User::where('role', User::ROLE_MASTER)->get();
        $clients = User::where('role', User::ROLE_CLIENT)->get();
        $selectedServiceId = request()->integer('service_id');
        if (! $services->contains('id', $selectedServiceId)) {
            $selectedServiceId = null;
        }
        
        $user = Auth::user();
        $isAdminOrManager = $user->isAdmin() || $user->isManager();
        $serviceOfTheDay = DailyServicePromotion::forToday();
        $backUrl = $this->resolveBackUrl(request());

        $dailyPromotion = null;
        if ($serviceOfTheDay && $selectedServiceId === $serviceOfTheDay->service_id) {
            $dailyPromotion = $serviceOfTheDay;
        } elseif (request()->boolean('daily_promotion') && $serviceOfTheDay) {
            $dailyPromotion = $serviceOfTheDay;
        }

        $serviceOfTheDayData = $serviceOfTheDay ? [
            'id' => $serviceOfTheDay->id,
            'service_id' => $serviceOfTheDay->service_id,
            'discount_percent' => $serviceOfTheDay->discount_percent,
            'date' => $serviceOfTheDay->date->format('Y-m-d'),
        ] : null;

        return view('appointments.create', compact(
            'services',
            'masters',
            'clients',
            'isAdminOrManager',
            'selectedServiceId',
            'serviceOfTheDay',
            'serviceOfTheDayData',
            'dailyPromotion',
            'backUrl'
        ));
    }

    public function createCombo(ServiceCombo $combo)
    {
        $combo->load(['service1', 'service2']);
        $masters = User::where('role', User::ROLE_MASTER)->get();
        $clients = User::where('role', User::ROLE_CLIENT)->get();

        $user = Auth::user();
        $isAdminOrManager = $user->isAdmin() || $user->isManager();
        $backUrl = $this->resolveBackUrl(request());

        return view('appointments.create-combo', compact('combo', 'masters', 'clients', 'isAdminOrManager', 'backUrl'));
    }

    public function getAvailableSlots(Request $request)
    {
        $masterId = $request->master_id;
        $date = $request->date;
        $serviceId = $request->service_id;
        
        if (!$masterId || !$date || !$serviceId) {
            return response()->json([]);
        }
        
        $master = User::find($masterId);
        $service = Service::find($serviceId);
        
        if (!$master || !$service) {
            return response()->json([]);
        }
        
        $selectedDate = Carbon::parse($date);
        $dayOfWeek = $selectedDate->dayOfWeek;
        
        $workStart = 9;
        $workEnd = 21;
        
        if ($dayOfWeek == 6 || $dayOfWeek == 0) {
            $workStart = 10;
            $workEnd = 19;
        }
        
        $existingAppointments = Appointment::where('master_id', $masterId)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->get();
        
        $availableSlots = [];
        $currentTime = Carbon::parse($date . ' ' . $workStart . ':00');
        $endTime = Carbon::parse($date . ' ' . $workEnd . ':00');
        $duration = $service->duration;
        
        while ($currentTime->copy()->addMinutes($duration) <= $endTime) {
            $slotEnd = $currentTime->copy()->addMinutes($duration);
            $isAvailable = true;
            
            foreach ($existingAppointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->appointment_date);
                $appointmentEnd = $appointmentStart->copy()->addMinutes(
                    $appointment->service->duration
                );
                
                if ($currentTime < $appointmentEnd && $slotEnd > $appointmentStart) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable && $currentTime > Carbon::now()) {
                $availableSlots[] = $currentTime->format('H:i');
            }
            
            $currentTime->addMinutes(30);
        }
        
        return response()->json($availableSlots);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);
        
        if ($user->isAdmin() || $user->isManager()) {
            $request->validate([
                'client_id' => 'required|exists:users,id',
            ]);
            $clientId = $request->client_id;
        } else {
            $clientId = $user->id;
        }
        
        $appointmentDateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        
        if ($appointmentDateTime < Carbon::now()) {
            return back()->withErrors(['appointment_date' => 'Нельзя записаться на прошедшее время'])->withInput();
        }

        $service = Service::findOrFail($validated['service_id']);

        if ($this->masterHasScheduleConflict($validated['master_id'], $appointmentDateTime, $service->duration)) {
            return back()->withErrors(['appointment_time' => 'Это время уже занято'])->withInput();
        }

        $discountPercent = $this->resolveDailyDiscount(
            (int) $validated['service_id'],
            $appointmentDateTime,
            $request->integer('daily_promotion_id') ?: null
        );

        Appointment::create([
            'client_id' => $clientId,
            'service_id' => $validated['service_id'],
            'master_id' => $validated['master_id'],
            'appointment_date' => $appointmentDateTime,
            'status' => Appointment::STATUS_PENDING,
            'discount_percent' => $discountPercent,
        ]);

        $message = 'Запись успешно создана';
        if ($discountPercent) {
            $message .= " (скидка {$discountPercent}%)";
        }

        return redirect()->route('appointments.index')
            ->with('success', $message);
    }

    public function storeCombo(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'combo_id' => 'required|exists:service_combos,id',
            'master_id_1' => 'required|exists:users,id',
            'appointment_date_1' => 'required|date',
            'appointment_time_1' => 'required',
            'master_id_2' => 'required|exists:users,id',
            'appointment_date_2' => 'required|date',
            'appointment_time_2' => 'required',
        ]);

        $combo = ServiceCombo::with(['service1', 'service2'])->findOrFail($validated['combo_id']);

        if ($user->isAdmin() || $user->isManager()) {
            $request->validate([
                'client_id' => 'required|exists:users,id',
            ]);
            $clientId = $request->client_id;
        } else {
            $clientId = $user->id;
        }

        $appointmentsData = [
            [
                'service' => $combo->service1,
                'master_id' => $validated['master_id_1'],
                'datetime' => Carbon::parse($validated['appointment_date_1'] . ' ' . $validated['appointment_time_1']),
                'time_field' => 'appointment_time_1',
                'date_field' => 'appointment_date_1',
            ],
            [
                'service' => $combo->service2,
                'master_id' => $validated['master_id_2'],
                'datetime' => Carbon::parse($validated['appointment_date_2'] . ' ' . $validated['appointment_time_2']),
                'time_field' => 'appointment_time_2',
                'date_field' => 'appointment_date_2',
            ],
        ];

        $pendingSlots = [];

        foreach ($appointmentsData as $data) {
            if ($data['datetime'] < Carbon::now()) {
                return back()->withErrors([$data['date_field'] => 'Нельзя записаться на прошедшее время'])->withInput();
            }

            if ($this->masterHasScheduleConflict(
                $data['master_id'],
                $data['datetime'],
                $data['service']->duration,
                $pendingSlots
            )) {
                return back()->withErrors([
                    $data['time_field'] => 'Выбранное время пересекается с другой записью или второй услугой комбо',
                ])->withInput();
            }

            $pendingSlots[] = [
                'master_id' => $data['master_id'],
                'datetime' => $data['datetime'],
                'duration' => $data['service']->duration,
            ];
        }

        foreach ($appointmentsData as $data) {
            Appointment::create([
                'client_id' => $clientId,
                'service_id' => $data['service']->id,
                'service_combo_id' => $combo->id,
                'master_id' => $data['master_id'],
                'appointment_date' => $data['datetime'],
                'status' => Appointment::STATUS_PENDING,
                'discount_percent' => $combo->discount_percent,
            ]);
        }

        return redirect()->route('appointments.index')
            ->with('success', "Комбо «{$combo->name}» успешно забронировано (скидка {$combo->discount_percent}%)");
    }

    private function resolveDailyDiscount(int $serviceId, Carbon $appointmentDateTime, ?int $dailyPromotionId = null): ?int
    {
        if ($dailyPromotionId) {
            $promotion = DailyServicePromotion::find($dailyPromotionId);

            if ($promotion && (int) $promotion->service_id === $serviceId) {
                return $promotion->discount_percent;
            }
        }

        $promotion = DailyServicePromotion::where('service_id', $serviceId)
            ->whereDate('date', $appointmentDateTime->toDateString())
            ->first();

        return $promotion?->discount_percent;
    }

    private function intervalsOverlap(Carbon $start1, int $duration1, Carbon $start2, int $duration2): bool
    {
        $end1 = $start1->copy()->addMinutes($duration1);
        $end2 = $start2->copy()->addMinutes($duration2);

        return $start1->lt($end2) && $end1->gt($start2);
    }

    private function masterHasScheduleConflict(int $masterId, Carbon $start, int $duration, array $pendingSlots = []): bool
    {
        $existingAppointments = Appointment::with('service')
            ->where('master_id', $masterId)
            ->whereDate('appointment_date', $start->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->get();

        foreach ($existingAppointments as $appointment) {
            $appointmentStart = Carbon::parse($appointment->appointment_date);

            if ($this->intervalsOverlap($start, $duration, $appointmentStart, $appointment->service->duration)) {
                return true;
            }
        }

        foreach ($pendingSlots as $slot) {
            if ((int) $slot['master_id'] !== $masterId) {
                continue;
            }

            if ($this->intervalsOverlap($start, $duration, $slot['datetime'], $slot['duration'])) {
                return true;
            }
        }

        return false;
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::all();
        $masters = User::where('role', User::ROLE_MASTER)->get();
        
        return view('appointments.edit', compact('appointment', 'services', 'masters'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Запись успешно обновлена');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        try {
            $status = $request->input('status');
            
            if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
                return response()->json(['success' => false, 'error' => 'Некорректный статус'], 400);
            }

            $appointment->status = $status;
            $appointment->save();

            $statusText = $this->getStatusText($status);
            $statusClass = $this->getStatusClass($status);

            return response()->json([
                'success' => true,
                'status' => $status,
                'status_text' => $statusText,
                'status_class' => $statusClass,
                'message' => 'Статус обновлен'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            $appointment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Запись удалена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    private function getStatusText($status)
    {
        switch ($status) {
            case 'pending': return 'Ожидает';
            case 'confirmed': return 'Подтверждена';
            case 'completed': return 'Выполнена';
            case 'cancelled': return 'Отменена';
            default: return $status;
        }
    }
    
    private function getStatusClass($status)
    {
        switch ($status) {
            case 'pending': return 'status-pending';
            case 'confirmed': return 'status-confirmed';
            case 'completed': return 'status-completed';
            case 'cancelled': return 'status-cancelled';
            default: return '';
        }
    }

    private function resolveBackUrl(Request $request): string
    {
        return match ($request->query('return')) {
            'dashboard' => route('dashboard'),
            'services' => route('services.index'),
            'appointments' => route('appointments.index'),
            default => route('appointments.index'),
        };
    }
}