@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-heading">Личный кабинет</h2>
        <p class="page-subtitle">Ваши данные и настройки безопасности</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center rn-sticky">
            <div class="card-body p-4 p-lg-5">
                <div class="rn-avatar mx-auto mb-3">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>
                <h4 class="mb-2">{{ $user->name }}</h4>
                <span class="rn-role-pill mb-4 d-inline-block">
                    @if($user->isAdmin()) Администратор
                    @elseif($user->isManager()) Менеджер
                    @elseif($user->isMaster()) Мастер
                    @else Клиент
                    @endif
                </span>

                <div class="text-start mt-2">
                    <div class="d-flex align-items-center gap-3 py-3" style="border-bottom: 1px solid var(--rn-border-soft);">
                        <span style="width: 2.4rem; height: 2.4rem; border-radius: .8rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <div style="min-width: 0;">
                            <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Email</div>
                            <div style="font-weight: 700; overflow: hidden; text-overflow: ellipsis;">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 py-3">
                        <span style="width: 2.4rem; height: 2.4rem; border-radius: .8rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">В системе с</div>
                            <div style="font-weight: 700;">{{ $user->created_at->format('d.m.Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                Редактирование профиля
            </div>
            <div class="card-body p-4 p-lg-5">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <h6 class="rn-section-title"><i class="bi bi-person"></i> Основная информация</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6 mb-1">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="rn-section-title"><i class="bi bi-shield-lock"></i> Смена пароля</h6>
                    <p class="text-muted small" style="font-weight: 600; margin-top: -.75rem;">Заполните поля ниже, только если хотите задать новый пароль.</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4 mb-1">
                            <label for="current_password" class="form-label">Текущий пароль</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" placeholder="••••••••">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-1">
                            <label for="new_password" class="form-label">Новый пароль</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                   id="new_password" name="new_password" placeholder="••••••••">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-1">
                            <label for="new_password_confirmation" class="form-label">Подтверждение</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
