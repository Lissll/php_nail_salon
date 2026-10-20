@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="row justify-content-center py-lg-4">
    <div class="col-md-5 col-lg-4">
        <div class="card text-center" style="border-radius: var(--rn-radius-xl);">
            <div class="card-body p-4 p-md-5">
                <div class="rn-avatar mx-auto mb-3" style="width: 72px; height: 72px; font-size: 1.6rem;">R</div>
                <h4 class="mb-1" style="font-family: var(--rn-font-display); font-weight: 700;">Rose Nails</h4>
                <p class="text-muted mb-4" style="font-weight: 600;">Вход в личный кабинет</p>

                <form method="POST" action="{{ route('login') }}" class="text-start">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-weight: 700; color: var(--rn-ink-soft);">Запомнить меня</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3" style="font-size: 1.05rem;">Войти</button>
                </form>

                <div class="mt-4 p-3 rounded text-center" style="background-color: var(--rn-bg); border: 1px solid var(--rn-border-soft);">
                    <p class="mb-1 text-muted small" style="font-weight: 700;">Тестовые аккаунты:</p>
                    <p class="mb-0 small" style="font-weight: 700; color: var(--rn-ink);">
                        admin, manager, master, user <span class="text-muted">@gmail.com</span><br>
                        Пароль: <code style="color: var(--rn-700); font-weight: 800;">123456</code>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection