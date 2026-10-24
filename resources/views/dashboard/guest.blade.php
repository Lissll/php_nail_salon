@extends('layouts.guest')

@section('title', 'Rose Nails — маникюрный салон')

@section('content')
    <section class="hero-salon container">
        <p class="text-uppercase small mb-3" style="letter-spacing: 0.2em; color: var(--rn-primary); font-weight: 700;">Уход · Стиль · Вдохновение</p>
        <h1 class="mb-3">Маникюр, в который влюбляешься</h1>
        <p class="lead mx-auto">Стойкий гель-лак, аккуратный педикюр и авторский дизайн — в уютной атмосфере и с любовью к деталям.</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3 px-5 py-3">Записаться онлайн</a>
    </section>

    <div class="container pb-4">
        @include('partials.promotions', [
            'serviceOfTheDay' => $serviceOfTheDay ?? null,
            'combos' => $combos ?? collect(),
            'loginPrompt' => true,
        ])
    </div>

    <div class="container flex-grow-1 pb-5">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h2 class="page-heading mb-2">Наши услуги</h2>
                <p class="text-muted mx-auto" style="max-width: 35rem; font-size: 1.1rem;">Выберите процедуру и забронируйте удобное время. Мы позаботимся о ваших ноготках.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card h-100">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title mb-3" style="font-weight: 700; font-size: 1.25rem;">{{ $service->name }}</h5>
                            <p class="card-text text-muted flex-grow-1 mb-4">{{ $service->description }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded" style="background-color: var(--rn-bg);">
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Длительность</span>
                                    <span style="font-weight: 700; font-size: 1.1rem;">{{ $service->duration }} мин</span>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Стоимость</span>
                                    <span style="font-weight: 800; font-size: 1.2rem; color: var(--rn-primary);">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 py-2">Войти, чтобы записаться</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center shadow-sm p-5" style="border-radius: 1.5rem;">
                        <h5 class="mb-0 text-muted">Услуги скоро появятся.</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection