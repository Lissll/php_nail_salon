<?php

namespace App\Http\Controllers;

use App\Models\DailyServicePromotion;
use App\Models\Service;
use App\Models\ServiceCombo;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function manage()
    {
        $services = Service::orderBy('name')->get();
        $dailyPromotions = DailyServicePromotion::with('service')
            ->orderByDesc('date')
            ->get();
        $combos = ServiceCombo::with(['service1', 'service2'])
            ->orderByDesc('created_at')
            ->get();

        return view('promotions.manage', compact('services', 'dailyPromotions', 'combos'));
    }

    public function storeDaily(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'discount_percent' => 'required|integer|min:1|max:99',
        ]);

        DailyServicePromotion::updateOrCreate(
            ['date' => $validated['date']],
            [
                'service_id' => $validated['service_id'],
                'discount_percent' => $validated['discount_percent'],
            ]
        );

        return redirect()->route('promotions.manage')
            ->with('success', 'Услуга дня успешно сохранена');
    }

    public function destroyDaily(DailyServicePromotion $dailyServicePromotion)
    {
        $dailyServicePromotion->delete();

        return redirect()->route('promotions.manage')
            ->with('success', 'Услуга дня удалена');
    }

    public function storeCombo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id_1' => 'required|exists:services,id|different:service_id_2',
            'service_id_2' => 'required|exists:services,id|different:service_id_1',
            'discount_percent' => 'required|integer|min:1|max:99',
        ]);

        ServiceCombo::create($validated);

        return redirect()->route('promotions.manage')
            ->with('success', 'Комбо-услуга успешно добавлена');
    }

    public function updateCombo(Request $request, ServiceCombo $combo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id_1' => 'required|exists:services,id|different:service_id_2',
            'service_id_2' => 'required|exists:services,id|different:service_id_1',
            'discount_percent' => 'required|integer|min:1|max:99',
        ]);

        $combo->update($validated);

        return redirect()->route('promotions.manage')
            ->with('success', 'Комбо-услуга успешно обновлена');
    }

    public function destroyCombo(ServiceCombo $combo)
    {
        $combo->delete();

        return redirect()->route('promotions.manage')
            ->with('success', 'Комбо-услуга удалена');
    }
}
