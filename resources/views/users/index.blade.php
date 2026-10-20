@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
    <div>
        <h2 class="page-heading">
            @if(Auth::user()->isManager())
                Клиенты
            @else
                Команда и пользователи
            @endif
        </h2>
        <p class="page-subtitle">{{ $users->count() }} {{ trans_choice('пользователь|пользователя|пользователей', $users->count()) }}</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Создать пользователя
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th class="text-end">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span style="width: 2.6rem; height: 2.6rem; border-radius: 50%; background: var(--rn-grad); color: #ffffff; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                </span>
                                <div>
                                    <div style="font-weight: 800;">
                                        {{ $user->name }}
                                        @if($user->id === Auth::id())
                                            <span class="rn-chip" style="padding: .1rem .6rem; font-size: .7rem;">это вы</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->isAdmin())
                                <span class="rn-chip rn-chip-dark">Администратор</span>
                            @elseif($user->isManager())
                                <span class="rn-chip" style="background: var(--rn-200); color: var(--rn-900);">Менеджер</span>
                            @elseif($user->isMaster())
                                <span class="rn-chip">Мастер</span>
                            @else
                                <span class="rn-chip" style="background: var(--rn-50); color: var(--rn-muted); border: 1px solid var(--rn-border-soft);">Клиент</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="text-end">
                            @php
                                $canManage = Auth::user()->isAdmin()
                                    || (Auth::user()->isManager() && $user->isClient());
                            @endphp
                            @if($canManage && !$user->isAdmin())
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                            @endif
                            @if($canManage && $user->id !== Auth::id())
                                <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger open-delete-user-modal"
                                            data-user-name="{{ $user->name }}"
                                            data-form-id="delete-user-form-{{ $user->id }}">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body py-4">
                Вы уверены, что хотите удалить пользователя <strong id="delete-user-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-user-btn">Удалить</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('deleteUserModal');
    if (!modalElement) return;

    const deleteUserModal = new bootstrap.Modal(modalElement);
    const deleteUserName = document.getElementById('delete-user-name');
    const confirmDeleteBtn = document.getElementById('confirm-delete-user-btn');
    let targetFormId = null;

    document.querySelectorAll('.open-delete-user-modal').forEach(button => {
        button.addEventListener('click', function () {
            targetFormId = this.dataset.formId;
            deleteUserName.textContent = this.dataset.userName || 'этого пользователя';
            deleteUserModal.show();
        });
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (!targetFormId) return;
        const targetForm = document.getElementById(targetFormId);
        if (targetForm) targetForm.submit();
    });
});
</script>
@endpush