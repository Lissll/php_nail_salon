@extends('layouts.app')

@section('title', 'Дашборд')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-heading">Здравствуйте, {{ $user->name }}!</h2>
        <p class="page-subtitle">{{ now()->format('d.m.Y') }} ·
            @if($user->isAdmin()) панель администратора
            @elseif($user->isManager()) панель менеджера
            @elseif($user->isMaster()) рабочий кабинет мастера
            @else личный кабинет клиента
            @endif
        </p>
    </div>
    <span class="rn-role-pill">
        @if($user->isAdmin()) Администратор
        @elseif($user->isManager()) Менеджер
        @elseif($user->isMaster()) Мастер
        @else Клиент
        @endif
    </span>
</div>

@if($user->isClient())
    @include('partials.promotions', [
        'serviceOfTheDay' => $serviceOfTheDay,
        'combos' => $combos,
        'canBook' => true,
    ])
@endif

<div class="row g-3 mb-4">
    @if($user->isAdmin())
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Всего записей</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['total_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Ожидают</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['pending_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-check2-circle"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Выполнено</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['completed_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-sun"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Сегодня</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['today_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-people"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Пользователей</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['total_users'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-scissors"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Мастеров</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['total_masters'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($user->isManager())
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Всего записей</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['total_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Ожидают</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['pending_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-check2-circle"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Выполнено</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['completed_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-sun"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Сегодня</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['today_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-person-heart"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Клиентов</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['total_clients'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($user->isMaster())
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-sun"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Сегодня</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_today_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Ожидают</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_pending_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-calendar-week"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">На неделю</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_week_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Мои записи</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-calendar-heart"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Предстоящие</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_upcoming_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-soft h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi bi-check2-circle"></i>
                        </span>
                        <div>
                            <div class="text-muted" style="font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Выполнено</div>
                            <div class="display-4" style="font-size: 1.7rem;">{{ $stats['my_completed_appointments'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<h6 class="rn-section-title"><i class="bi bi-lightning-charge"></i> Быстрые действия</h6>

<div class="row g-3 quick-actions">
    <div class="col-6 col-md-3">
        <a href="{{ route('appointments.index') }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-calendar3" style="color: var(--rn-primary);"></i> Мои записи
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('services.index') }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-stars" style="color: var(--rn-primary);"></i> Услуги
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('appointments.create', ['return' => 'dashboard']) }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg" style="color: var(--rn-primary);"></i> Новая запись
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('profile.index') }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-person" style="color: var(--rn-primary);"></i> Личный кабинет
        </a>
    </div>
    @if($user->isAdmin() || $user->isManager())
    <div class="col-6 col-md-3">
        <a href="{{ route('users.index') }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-people" style="color: var(--rn-primary);"></i> Пользователи
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('promotions.manage') }}" class="btn w-100 d-flex align-items-center gap-2">
            <i class="bi bi-tag" style="color: var(--rn-primary);"></i> Акции и комбо
        </a>
    </div>
    @endif
</div>
@endsection