@extends('layouts.app')

@section('title', 'Записи')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-heading">Записи</h2>
        <p class="page-subtitle">Расписание и управление записями клиентов</p>
    </div>
    @if(Auth::user()->isClient() || Auth::user()->isAdmin() || Auth::user()->isManager())
        <a href="{{ route('appointments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Новая запись</a>
    @endif
</div>

<div class="card">
    <div class="card-header bg-primary">
        Журнал записей
        <span class="rn-chip ms-auto">{{ $appointments->count() }} {{ trans_choice('запись|записи|записей', $appointments->count()) }}</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Услуга</th>
                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                        <th>Клиент</th>
                    @endif
                    <th>Мастер</th>
                    <th>Дата и время</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    @if(Auth::user()->isMaster() || Auth::user()->isAdmin() || Auth::user()->isManager())
                        <th class="text-end">Действия</th>
                    @endif
                </tr>
            </thead>
            <tbody id="appointments-table-body">
                @forelse($appointments as $appointment)
                    <tr id="appointment-row-{{ $appointment->id }}" data-id="{{ $appointment->id }}">
                        <td>
                            <div style="font-weight: 800;">{{ $appointment->service->name }}</div>
                            <small class="text-muted d-flex align-items-center gap-2 mt-1">
                                <span class="rn-chip" style="padding: .15rem .6rem; font-size: .72rem;">{{ $appointment->service->duration }} мин.</span>
                                @if($appointment->promotion_label)
                                    <span class="rn-discount" style="padding: .15rem .6rem; font-size: .72rem;">{{ $appointment->promotion_label }}</span>
                                @endif
                            </small>
                        </td>
                        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                            <td>{{ $appointment->client->name }}</td>
                        @endif
                        <td>{{ $appointment->master->name }}</td>
                        <td style="white-space: nowrap;">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') }}
                        </td>
                        <td style="white-space: nowrap;">
                            @if($appointment->hasDiscount())
                                <span class="old-price d-block">{{ number_format($appointment->service->price, 0, ',', ' ') }} ₽</span>
                                <span class="rn-price">{{ number_format($appointment->final_price, 0, ',', ' ') }} ₽</span>
                                <small class="rn-discount" style="padding: .1rem .55rem; font-size: .7rem;">−{{ $appointment->discount_percent }}%</small>
                            @else
                                <span class="rn-price">{{ number_format($appointment->service->price, 0, ',', ' ') }} ₽</span>
                            @endif
                        </td>
                        <td id="status-cell-{{ $appointment->id }}">
                            <span class="status-badge status-{{ $appointment->status }}" id="status-badge-{{ $appointment->id }}">
                                @switch($appointment->status)
                                    @case('pending') Ожидает @break
                                    @case('confirmed') Подтверждена @break
                                    @case('completed') Выполнена @break
                                    @case('cancelled') Отменена @break
                                @endswitch
                            </span>
                        </td>

                        @if(Auth::user()->isMaster())
                            <td class="text-end">
                                @if(!in_array($appointment->status, ['completed', 'cancelled']))
                                    <select class="form-select form-select-sm status-select d-inline-block"
                                            data-id="{{ $appointment->id }}"
                                            data-url="{{ route('appointments.update-status', $appointment->id) }}"
                                            style="min-width: 150px; width: auto; border-radius: 3rem; font-weight: 700;">
                                        <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Ожидает</option>
                                        <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Подтвердить</option>
                                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Выполнить</option>
                                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Отменить</option>
                                    </select>
                                @endif
                            </td>
                        @endif

                        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                            <td class="text-end text-nowrap">
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-appointment" title="Удалить" data-id="{{ $appointment->id }}" data-url="{{ route('appointments.destroy', $appointment->id) }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted mb-1" style="font-weight: 700;">Записей пока нет</div>
                            <small class="text-muted">Создайте первую запись по кнопке выше</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление записи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body py-4">
                Вы уверены, что хотите удалить эту запись? Это действие нельзя отменить.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-appointment-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show`;
        alert.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        const container = document.querySelector('main');
        if (container.firstChild) {
            container.insertBefore(alert, container.firstChild);
        } else {
            container.appendChild(alert);
        }
        setTimeout(() => alert.remove(), 3000);
    }

    function getStatusText(status) {
        const map = {pending: 'Ожидает', confirmed: 'Подтверждена', completed: 'Выполнена', cancelled: 'Отменена'};
        return map[status] || status;
    }

    function getStatusClass(status) {
        const map = {pending: 'status-pending', confirmed: 'status-confirmed', completed: 'status-completed', cancelled: 'status-cancelled'};
        return map[status] || '';
    }

    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function(e) {
            const url = this.dataset.url;
            const appointmentId = this.dataset.id;
            const status = this.value;
            const selectElement = this;
            const originalValue = selectElement.value;

            selectElement.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById(`status-badge-${appointmentId}`);
                    if (badge) {
                        badge.textContent = data.status_text || getStatusText(status);
                        badge.className = `status-badge ${data.status_class || getStatusClass(status)}`;
                    }
                    showMessage('Статус обновлен', 'success');
                    if (status === 'completed' || status === 'cancelled') {
                        selectElement.remove();
                    }
                } else {
                    showMessage('Ошибка: ' + (data.error || 'неизвестная'), 'error');
                    selectElement.value = originalValue;
                }
                selectElement.disabled = false;
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showMessage('Ошибка сервера', 'error');
                selectElement.value = originalValue;
                selectElement.disabled = false;
            });
        });
    });

    const deleteButtons = document.querySelectorAll('.delete-appointment');
    const deleteAppointmentModal = new bootstrap.Modal(document.getElementById('deleteAppointmentModal'));
    const confirmDeleteAppointmentBtn = document.getElementById('confirm-delete-appointment-btn');
    let selectedDeleteButton = null;

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            selectedDeleteButton = this;
            deleteAppointmentModal.show();
        });
    });

    confirmDeleteAppointmentBtn.addEventListener('click', function () {
        if (!selectedDeleteButton) return;

        const url = selectedDeleteButton.dataset.url;
        const appointmentId = selectedDeleteButton.dataset.id;
        const row = document.getElementById(`appointment-row-${appointmentId}`);
        const btn = selectedDeleteButton;

        btn.disabled = true;
        confirmDeleteAppointmentBtn.disabled = true;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (row) row.remove();
                deleteAppointmentModal.hide();
                showMessage('Запись удалена', 'success');
            } else {
                showMessage('Ошибка: ' + (data.error || 'неизвестная'), 'error');
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showMessage('Ошибка сервера', 'error');
            btn.disabled = false;
        })
        .finally(() => {
            confirmDeleteAppointmentBtn.disabled = false;
            selectedDeleteButton = null;
        });
    });
});
</script>
@endpush
