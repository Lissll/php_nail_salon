@extends('layouts.app')

@section('title', 'Акции и комбо-услуги')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-heading">Акции и комбо-услуги</h2>
        <p class="page-subtitle">Услуга дня и выгодные наборы для клиентов</p>
    </div>
</div>

<ul class="nav rn-tabs mb-4" id="promoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily-pane" type="button" role="tab">
            Услуга дня
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="combo-tab" data-bs-toggle="tab" data-bs-target="#combo-pane" type="button" role="tab">
            Комбо-услуги
        </button>
    </li>
</ul>

<div class="tab-content" id="promoTabsContent">
    <div class="tab-pane fade show active" id="daily-pane" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-header bg-primary">
                        Назначить услугу дня
                    </div>
                    <div class="card-body">
                        <p class="text-muted small" style="font-weight: 600;">На выбранную дату одна услуга отображается клиентам со скидкой.</p>
                        <form method="POST" action="{{ route('promotions.daily.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="daily_service_id" class="form-label">Услуга</label>
                                <select class="form-select @error('service_id') is-invalid @enderror" id="daily_service_id" name="service_id" required>
                                    <option value="">-- Выберите услугу --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ (string) old('service_id') === (string) $service->id ? 'selected' : '' }}>
                                            {{ $service->name }} — {{ number_format($service->price, 0, ',', ' ') }} ₽
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="daily_date" class="form-label">Дата</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="daily_date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="daily_discount" class="form-label">Скидка (%)</label>
                                    <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" id="daily_discount" name="discount_percent" value="{{ old('discount_percent', 10) }}" min="1" max="99" required>
                                    @error('discount_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Сохранить услугу дня
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header bg-primary">
                        Запланированные услуги дня
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Услуга</th>
                                    <th>Скидка</th>
                                    <th>Цена со скидкой</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dailyPromotions as $promotion)
                                    <tr>
                                        <td style="white-space: nowrap; font-weight: 800;">{{ $promotion->date->format('d.m.Y') }}</td>
                                        <td>{{ $promotion->service->name }}</td>
                                        <td><span class="rn-discount">−{{ $promotion->discount_percent }}%</span></td>
                                        <td><span class="rn-price">{{ number_format($promotion->discounted_price, 0, ',', ' ') }} ₽</span></td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('promotions.daily.destroy', $promotion) }}" class="d-inline" onsubmit="return confirm('Удалить услугу дня на эту дату?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted" style="font-weight: 700;">Услуги дня пока не назначены</div>
                                            <small class="text-muted">Заполните форму слева, чтобы запустить первую акцию</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="combo-pane" role="tabpanel">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-header bg-primary">
                        Создать комбо
                    </div>
                    <div class="card-body">
                        <p class="text-muted small" style="font-weight: 600;">Клиент получает скидку при записи на обе услуги из набора.</p>
                        <form method="POST" action="{{ route('promotions.combo.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="combo_name" class="form-label">Название комбо</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="combo_name" name="name" value="{{ old('name') }}" placeholder="Например: Красота и уход" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="combo_service_1" class="form-label">Первая услуга</label>
                                <select class="form-select @error('service_id_1') is-invalid @enderror" id="combo_service_1" name="service_id_1" required>
                                    <option value="">-- Выберите услугу --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ (string) old('service_id_1') === (string) $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="combo_service_2" class="form-label">Вторая услуга</label>
                                <select class="form-select @error('service_id_2') is-invalid @enderror" id="combo_service_2" name="service_id_2" required>
                                    <option value="">-- Выберите услугу --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ (string) old('service_id_2') === (string) $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="combo_discount" class="form-label">Скидка на комбо (%)</label>
                                <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" id="combo_discount" name="discount_percent" value="{{ old('discount_percent', 15) }}" min="1" max="99" required>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Добавить комбо
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header bg-primary">
                        Список комбо-услуг
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Услуги</th>
                                    <th>Скидка</th>
                                    <th class="text-end">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($combos as $combo)
                                    <tr>
                                        <td style="font-weight: 800;">{{ $combo->name }}</td>
                                        <td>
                                            <span class="rn-chip mb-1 d-inline-flex">{{ $combo->service1->name }}</span><br>
                                            <span class="rn-chip d-inline-flex">{{ $combo->service2->name }}</span>
                                        </td>
                                        <td><span class="rn-discount">−{{ $combo->discount_percent }}%</span></td>
                                        <td class="text-end text-nowrap">
                                            <button type="button" class="btn btn-sm btn-warning edit-combo"
                                                    data-id="{{ $combo->id }}"
                                                    data-name="{{ $combo->name }}"
                                                    data-service-id-1="{{ $combo->service_id_1 }}"
                                                    data-service-id-2="{{ $combo->service_id_2 }}"
                                                    data-discount="{{ $combo->discount_percent }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-combo"
                                                    data-id="{{ $combo->id }}"
                                                    data-name="{{ $combo->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-muted" style="font-weight: 700;">Комбо-услуги пока не добавлены</div>
                                            <small class="text-muted">Создайте первый набор по форме слева</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editComboModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать комбо</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="edit-combo-form">
                @csrf
                @method('PUT')
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label for="edit_combo_name" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_combo_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_combo_service_1" class="form-label">Первая услуга</label>
                        <select class="form-select" id="edit_combo_service_1" name="service_id_1" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_combo_service_2" class="form-label">Вторая услуга</label>
                        <select class="form-select" id="edit_combo_service_2" name="service_id_2" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_combo_discount" class="form-label">Скидка (%)</label>
                        <input type="number" class="form-control" id="edit_combo_discount" name="discount_percent" min="1" max="99" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-combo-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<div class="modal fade" id="deleteComboModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление комбо</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                Удалить комбо <strong id="delete-combo-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-combo-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const allServices = @json($services->map(fn ($service) => ['id' => (string) $service->id, 'name' => $service->name])->values());

    const tabButtons = document.querySelectorAll('#promoTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function() {
            history.replaceState(null, '', '#' + this.id);
        });
    });
    if (location.hash) {
        const targetButton = document.querySelector('#promoTabs button' + location.hash);
        if (targetButton) {
            bootstrap.Tab.getOrCreateInstance(targetButton).show();
        }
    }

    function initComboServiceExclusion(select1Id, select2Id) {
        const select1 = document.getElementById(select1Id);
        const select2 = document.getElementById(select2Id);

        if (!select1 || !select2) {
            return;
        }

        function rebuildSelect(targetSelect, excludeId, selectedId) {
            targetSelect.innerHTML = '<option value="">-- Выберите услугу --</option>';

            allServices.forEach(service => {
                if (String(service.id) === String(excludeId)) {
                    return;
                }

                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.name;

                if (String(service.id) === String(selectedId)) {
                    option.selected = true;
                }

                targetSelect.appendChild(option);
            });

            if (selectedId && String(selectedId) === String(excludeId)) {
                targetSelect.value = '';
            }
        }

        function syncFromFirst() {
            rebuildSelect(select2, select1.value, select2.value);
        }

        function syncFromSecond() {
            rebuildSelect(select1, select2.value, select1.value);
        }

        select1.addEventListener('change', syncFromFirst);
        select2.addEventListener('change', syncFromSecond);

        syncFromFirst();
        syncFromSecond();
    }

    initComboServiceExclusion('combo_service_1', 'combo_service_2');
    initComboServiceExclusion('edit_combo_service_1', 'edit_combo_service_2');

    const editModal = new bootstrap.Modal(document.getElementById('editComboModal'));
    const editForm = document.getElementById('edit-combo-form');
    const editSelect1 = document.getElementById('edit_combo_service_1');
    const editSelect2 = document.getElementById('edit_combo_service_2');

    document.querySelectorAll('.edit-combo').forEach(button => {
        button.addEventListener('click', function() {
            editForm.action = `/promotions/combos/${this.dataset.id}`;
            document.getElementById('edit_combo_name').value = this.dataset.name;
            editSelect1.value = this.dataset.serviceId1;
            editSelect2.value = this.dataset.serviceId2;
            document.getElementById('edit_combo_discount').value = this.dataset.discount;

            editSelect1.dispatchEvent(new Event('change'));
            editSelect2.dispatchEvent(new Event('change'));

            editModal.show();
        });
    });

    const deleteForm = document.getElementById('delete-combo-form');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteComboModal'));
    let deleteAction = null;

    document.querySelectorAll('.delete-combo').forEach(button => {
        button.addEventListener('click', function() {
            deleteAction = `/promotions/combos/${this.dataset.id}`;
            document.getElementById('delete-combo-name').textContent = this.dataset.name;
            deleteModal.show();
        });
    });

    document.getElementById('confirm-delete-combo-btn').addEventListener('click', function() {
        if (!deleteAction) return;
        deleteForm.action = deleteAction;
        deleteForm.submit();
    });
});
</script>
@endpush