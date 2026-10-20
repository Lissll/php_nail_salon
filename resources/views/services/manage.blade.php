@extends('layouts.app')

@section('title', 'Управление услугами')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-heading">Управление услугами</h2>
        <p class="page-subtitle">Каталог услуг салона — цены и длительность</p>
    </div>
    <button type="button" class="btn btn-primary" id="open-create-service-modal">
        <i class="bi bi-plus-lg"></i> Добавить услугу
    </button>
</div>

<div class="row g-4">
    @forelse($services as $service)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 service-card">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <span style="width: 3rem; height: 3rem; border-radius: 1rem; background: var(--rn-grad); color: #ffffff; display: inline-flex; align-items: center; justify-content: center; font-family: var(--rn-font-display); font-size: 1.2rem; font-weight: 700; flex-shrink: 0; box-shadow: 0 6px 16px rgba(245, 50, 122, .3);">
                            {{ mb_strtoupper(mb_substr($service->name, 0, 1)) }}
                        </span>
                        <div style="min-width: 0;">
                            <h5 class="mb-1" style="font-weight: 800; font-size: 1.1rem;">{{ $service->name }}</h5>
                            @if($service->description)
                                <small class="text-muted" style="font-weight: 600;">{{ Str::limit($service->description, 70) }}</small>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 mb-4">
                        <span class="rn-chip"><i class="bi bi-clock"></i> {{ $service->duration }} мин.</span>
                        <span class="rn-chip rn-chip-dark">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                    </div>

                    <div class="d-flex gap-2 mt-auto">
                        <button type="button" class="btn btn-warning flex-grow-1 edit-service"
                                data-id="{{ $service->id }}"
                                data-name="{{ $service->name }}"
                                data-description="{{ $service->description }}"
                                data-duration="{{ $service->duration }}"
                                data-price="{{ $service->price }}">
                            <i class="bi bi-pencil"></i> Редактировать
                        </button>
                        <button type="button" class="btn btn-danger delete-service"
                                data-id="{{ $service->id }}"
                                data-name="{{ $service->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="text-muted mb-1" style="font-weight: 700;">Услуги пока не добавлены</div>
                    <small class="text-muted">Нажмите «Добавить услугу», чтобы создать первую</small>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Modal: добавление услуги -->
<div class="modal fade" id="createServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('services.store') }}">
                @csrf
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Название услуги</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" placeholder="Например: Маникюр с покрытием" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Краткое описание для клиентов"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Длительность (мин)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                   id="duration" name="duration" placeholder="60" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Стоимость (₽)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price" placeholder="1500" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: редактирование услуги -->
<div class="modal fade" id="editServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="edit-service-form">
                @csrf
                @method('PUT')
                <div class="modal-body pt-4">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Название</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Описание</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_duration" class="form-label">Длительность (мин)</label>
                            <input type="number" class="form-control" id="edit_duration" name="duration" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_price" class="form-label">Стоимость (₽)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                        </div>
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

<!-- Форма и модалка для удаления -->
<form id="delete-service-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление услуги</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body py-4">
                Вы уверены, что хотите удалить услугу <strong id="delete-service-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-service-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createModal = new bootstrap.Modal(document.getElementById('createServiceModal'));
    document.getElementById('open-create-service-modal').addEventListener('click', function() {
        createModal.show();
    });

    // Если при создании услуги были ошибки валидации — сразу открываем форму
    @if($errors->any())
        createModal.show();
    @endif

    const editButtons = document.querySelectorAll('.edit-service');
    const editModal = new bootstrap.Modal(document.getElementById('editServiceModal'));
    const editForm = document.getElementById('edit-service-form');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const description = this.dataset.description;
            const duration = this.dataset.duration;
            const price = this.dataset.price;

            editForm.action = `/services/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description || '';
            document.getElementById('edit_duration').value = duration;
            document.getElementById('edit_price').value = price;

            editModal.show();
        });
    });

    const deleteButtons = document.querySelectorAll('.delete-service');
    const deleteForm = document.getElementById('delete-service-form');
    const deleteServiceModal = new bootstrap.Modal(document.getElementById('deleteServiceModal'));
    const deleteServiceNameElement = document.getElementById('delete-service-name');
    const confirmDeleteServiceBtn = document.getElementById('confirm-delete-service-btn');
    let deleteServiceAction = null;

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;

            deleteServiceAction = `/services/${id}`;
            deleteServiceNameElement.textContent = name || 'без названия';
            deleteServiceModal.show();
        });
    });

    confirmDeleteServiceBtn.addEventListener('click', function () {
        if (!deleteServiceAction) return;
        deleteForm.action = deleteServiceAction;
        deleteForm.submit();
    });
});
</script>
@endpush