@extends('layouts.app')

@section('title', 'Запись на комбо')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> {{ $combo->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <strong>{{ $combo->service1->name }}</strong>
                            <div class="text-muted small">{{ $combo->service1->duration }} мин · {{ number_format($combo->service1->price, 0, ',', ' ') }} ₽</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <strong>{{ $combo->service2->name }}</strong>
                            <div class="text-muted small">{{ $combo->service2->duration }} мин · {{ number_format($combo->service2->price, 0, ',', ' ') }} ₽</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="promo-price-old">{{ number_format($combo->original_total, 0, ',', ' ') }} ₽</span>
                    <span class="promo-price-new">{{ number_format($combo->discounted_total, 0, ',', ' ') }} ₽</span>
                    <span class="promo-save-badge">−{{ $combo->discount_percent }}%</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Выберите время для обеих услуг</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.store-combo') }}" id="combo-form">
                    @csrf
                    <input type="hidden" name="combo_id" value="{{ $combo->id }}">

                    @if($isAdminOrManager)
                    <div class="mb-4">
                        <label for="client_id" class="form-label">Клиент</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                            <option value="">-- Выберите клиента --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ (string) old('client_id') === (string) $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ $combo->service1->name }}</h6>
                            <div class="mb-3">
                                <label for="master_id_1" class="form-label">Мастер</label>
                                <select class="form-select @error('master_id_1') is-invalid @enderror" id="master_id_1" name="master_id_1" required>
                                    <option value="">-- Выберите мастера --</option>
                                    @foreach($masters as $master)
                                        <option value="{{ $master->id }}" {{ (string) old('master_id_1') === (string) $master->id ? 'selected' : '' }}>
                                            {{ $master->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('master_id_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="appointment_date_1" class="form-label">Дата</label>
                                <input type="date" class="form-control @error('appointment_date_1') is-invalid @enderror" id="appointment_date_1" name="appointment_date_1" min="{{ now()->format('Y-m-d') }}" value="{{ old('appointment_date_1') }}" required>
                                @error('appointment_date_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="appointment_time_1" class="form-label">Время</label>
                                <select class="form-select @error('appointment_time_1') is-invalid @enderror" id="appointment_time_1" name="appointment_time_1" required disabled>
                                    <option value="">-- Сначала выберите мастера и дату --</option>
                                </select>
                                @error('appointment_time_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3">{{ $combo->service2->name }}</h6>
                            <div class="mb-3">
                                <label for="master_id_2" class="form-label">Мастер</label>
                                <select class="form-select @error('master_id_2') is-invalid @enderror" id="master_id_2" name="master_id_2" required>
                                    <option value="">-- Выберите мастера --</option>
                                    @foreach($masters as $master)
                                        <option value="{{ $master->id }}" {{ (string) old('master_id_2') === (string) $master->id ? 'selected' : '' }}>
                                            {{ $master->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('master_id_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="appointment_date_2" class="form-label">Дата</label>
                                <input type="date" class="form-control @error('appointment_date_2') is-invalid @enderror" id="appointment_date_2" name="appointment_date_2" min="{{ now()->format('Y-m-d') }}" value="{{ old('appointment_date_2') }}" required>
                                @error('appointment_date_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="appointment_time_2" class="form-label">Время</label>
                                <select class="form-select @error('appointment_time_2') is-invalid @enderror" id="appointment_time_2" name="appointment_time_2" required disabled>
                                    <option value="">-- Сначала выберите мастера и дату --</option>
                                </select>
                                @error('appointment_time_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                            Записаться на комбо
                        </button>
                        <a href="{{ $backUrl }}" class="btn btn-secondary">Назад</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slotsUrl = '{{ route("appointments.available-slots") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const submitBtn = document.getElementById('submit-btn');

    const services = {
        1: { id: {{ $combo->service_id_1 }}, master: 'master_id_1', date: 'appointment_date_1', time: 'appointment_time_1' },
        2: { id: {{ $combo->service_id_2 }}, master: 'master_id_2', date: 'appointment_date_2', time: 'appointment_time_2' },
    };

    const durations = {
        1: {{ $combo->service1->duration }},
        2: {{ $combo->service2->duration }},
    };

    function timeToMinutes(time) {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function slotsOverlap(time1, duration1, time2, duration2) {
        const start1 = timeToMinutes(time1);
        const end1 = start1 + duration1;
        const start2 = timeToMinutes(time2);
        const end2 = start2 + duration2;

        return start1 < end2 && end1 > start2;
    }

    function getOtherSelection(currentKey) {
        const otherKey = currentKey === '1' ? '2' : '1';
        const otherCfg = services[otherKey];

        return {
            masterId: document.getElementById(otherCfg.master).value,
            date: document.getElementById(otherCfg.date).value,
            time: document.getElementById(otherCfg.time).value,
            duration: durations[otherKey],
        };
    }

    function filterConflictingSlots(slots, serviceKey) {
        const cfg = services[serviceKey];
        const other = getOtherSelection(serviceKey);
        const myMaster = document.getElementById(cfg.master).value;
        const myDate = document.getElementById(cfg.date).value;

        if (!other.masterId || !other.date || !other.time) {
            return slots;
        }

        if (myMaster !== other.masterId || myDate !== other.date) {
            return slots;
        }

        return slots.filter(slot => !slotsOverlap(slot, durations[serviceKey], other.time, other.duration));
    }

    function checkFormComplete() {
        const allFilled = Object.values(services).every(cfg => {
            const master = document.getElementById(cfg.master).value;
            const date = document.getElementById(cfg.date).value;
            const time = document.getElementById(cfg.time).value;
            return master && date && time;
        });

        @if($isAdminOrManager)
        const clientSelected = document.getElementById('client_id').value;
        submitBtn.disabled = !(allFilled && clientSelected);
        @else
        submitBtn.disabled = !allFilled;
        @endif
    }

    async function loadSlots(serviceKey, preserveSelection = false) {
        const cfg = services[serviceKey];
        const masterId = document.getElementById(cfg.master).value;
        const date = document.getElementById(cfg.date).value;
        const timeSelect = document.getElementById(cfg.time);
        const previousValue = preserveSelection ? timeSelect.value : '';

        if (!masterId || !date) {
            timeSelect.innerHTML = '<option value="">-- Сначала выберите мастера и дату --</option>';
            timeSelect.disabled = true;
            checkFormComplete();
            return;
        }

        try {
            const response = await fetch(slotsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    master_id: masterId,
                    date: date,
                    service_id: cfg.id,
                }),
            });

            let slots = await response.json();
            slots = filterConflictingSlots(slots, serviceKey);

            timeSelect.innerHTML = '<option value="">-- Выберите время --</option>';

            if (slots.length > 0) {
                slots.forEach(slot => {
                    timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                });
                timeSelect.disabled = false;

                if (previousValue && slots.includes(previousValue)) {
                    timeSelect.value = previousValue;
                } else if (previousValue) {
                    timeSelect.value = '';
                }
            } else {
                timeSelect.innerHTML = '<option value="">-- Нет свободного времени --</option>';
                timeSelect.disabled = true;
            }
        } catch (error) {
            timeSelect.innerHTML = '<option value="">-- Ошибка загрузки --</option>';
            timeSelect.disabled = true;
        }

        checkFormComplete();
    }

    function reloadBothSlots(changedKey, preserveSelection = false) {
        loadSlots(changedKey, preserveSelection);
        const otherKey = changedKey === '1' ? '2' : '1';
        loadSlots(otherKey, true);
    }

    Object.keys(services).forEach(key => {
        const cfg = services[key];
        document.getElementById(cfg.master).addEventListener('change', () => reloadBothSlots(key));
        document.getElementById(cfg.date).addEventListener('change', () => reloadBothSlots(key));
        document.getElementById(cfg.time).addEventListener('change', () => {
            const otherKey = key === '1' ? '2' : '1';
            loadSlots(otherKey, true);
            checkFormComplete();
        });
    });

    @if($isAdminOrManager)
    document.getElementById('client_id').addEventListener('change', checkFormComplete);
    @endif

    Object.keys(services).forEach(key => {
        const cfg = services[key];
        if (document.getElementById(cfg.master).value && document.getElementById(cfg.date).value) {
            loadSlots(key);
        }
    });
});
</script>
@endpush
