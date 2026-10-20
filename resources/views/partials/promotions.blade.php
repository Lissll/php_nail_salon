@if($serviceOfTheDay || $combos->isNotEmpty())
<section class="promo-section mb-4">
    <h5 class="page-heading mb-3">
        <i class="bi bi-gem text-primary"></i> Специальные предложения
    </h5>
    <div class="row g-3">
        @if($serviceOfTheDay)
            <div class="col-lg-6">
                <article class="promo-card">
                    <div class="promo-card-inner">
                        <div class="promo-card-header">
                            <span class="promo-label">Услуга дня</span>
                        </div>
                        <div class="promo-card-body">
                            <h6 class="promo-card-title">{{ $serviceOfTheDay->service->name }}</h6>
                            @if($serviceOfTheDay->service->description)
                                <p class="promo-card-desc">{{ Str::limit($serviceOfTheDay->service->description, 90) }}</p>
                            @endif
                            <div class="promo-price-row">
                                <span class="promo-price-old">{{ number_format($serviceOfTheDay->service->price, 0, ',', ' ') }} ₽</span>
                                <span class="promo-price-new">{{ number_format($serviceOfTheDay->discounted_price, 0, ',', ' ') }} ₽</span>
                                <span class="promo-save-badge">−{{ $serviceOfTheDay->discount_percent }}%</span>
                            </div>
                            <p class="promo-meta">Только сегодня · {{ now()->format('d.m.Y') }}</p>
                        </div>
                        <div class="promo-card-footer">
                            @if($canBook ?? false)
                                <a href="{{ route('appointments.create', ['service_id' => $serviceOfTheDay->service_id, 'return' => 'dashboard', 'daily_promotion' => 1]) }}" class="btn btn-primary btn-sm w-100">
                                    Записаться со скидкой
                                </a>
                            @elseif($loginPrompt ?? false)
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                    Войти и записаться
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @endif

        @foreach($combos as $combo)
            <div class="col-lg-6">
                <article class="promo-card">
                    <div class="promo-card-inner">
                        <div class="promo-card-header">
                            <span class="promo-label">Комбо</span>
                        </div>
                        <div class="promo-card-body">
                            <h6 class="promo-card-title">{{ $combo->name }}</h6>
                            <ul class="promo-combo-items">
                                <li>{{ $combo->service1->name }}</li>
                                <li>{{ $combo->service2->name }}</li>
                            </ul>
                            <div class="promo-price-row">
                                <span class="promo-price-old">{{ number_format($combo->original_total, 0, ',', ' ') }} ₽</span>
                                <span class="promo-price-new">{{ number_format($combo->discounted_total, 0, ',', ' ') }} ₽</span>
                                <span class="promo-save-badge">−{{ $combo->discount_percent }}%</span>
                            </div>
                            <p class="promo-meta">Скидка при записи на обе услуги</p>
                        </div>
                        <div class="promo-card-footer">
                            @if($canBook ?? false)
                                <a href="{{ route('appointments.create-combo', ['combo' => $combo, 'return' => 'dashboard']) }}" class="btn btn-primary btn-sm w-100">
                                    Записаться на комбо
                                </a>
                            @elseif($loginPrompt ?? false)
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                    Войти для записи
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
@endif
