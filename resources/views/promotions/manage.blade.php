@extends('layouts.app')

@section('title', 'Акции и комбо-услуги')

@section('content')
<h2 class="page-heading mb-4">
    <i class="bi bi-tag text-primary"></i> Акции и комбо-услуги
</h2>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-sun"></i> Услуга дня</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">На выбранную дату одна услуга отображается клиентам со скидкой.</p>
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
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="daily_date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
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
                        <i class="bi bi-plus-circle"></i> Сохранить услугу дня
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Запланированные услуги дня</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Услуга</th>
                                <th>Скидка</th>
                                <th>Цена со скидкой</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dailyPromotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->date->format('d.m.Y') }}</td>
                                    <td>{{ $promotion->service->name }}</td>
                                    <td>{{ $promotion->discount_percent }}%</td>
                                    <td>{{ number_format($promotion->discounted_price, 0, ',', ' ') }} ₽</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('promotions.daily.destroy', $promotion) }}" class="d-inline" onsubmit="return confirm('Удалить услугу дня на эту дату?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Услуги дня пока не назначены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Комбо-услуга</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Клиент получает скидку при записи на обе услуги из набора.</p>
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
                        <i class="bi bi-plus-circle"></i> Добавить комбо
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-collection"></i> Список комбо-услуг</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Услуги</th>
                                <th>Скидка</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($combos as $combo)
                                <tr>
                                    <td><strong>{{ $combo->name }}</strong></td>
                                    <td>
                                        <small>{{ $combo->service1->name }}</small><br>
                                        <small>{{ $combo->service2->name }}</small>
                                    </td>
                                    <td>{{ $combo->discount_percent }}%</td>
                                    <td class="text-nowrap text-end">
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
                                    <td colspan="4" class="text-center text-muted py-4">Комбо-услуги пока не добавлены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editComboModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать комбо</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="edit-combo-form">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
            <div class="modal-body">
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
