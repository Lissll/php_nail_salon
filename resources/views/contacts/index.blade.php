@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h2 class="page-heading mb-2">Контакты</h2>
        <p class="text-muted" style="font-size: 1.1rem;">Мы рядом с метро — приходите в удобное время.</p>
    </div>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-primary">
                Контактная информация
            </div>
            <div class="card-body p-4">
                <div class="d-flex gap-3 py-3" style="border-bottom: 1px solid var(--rn-border-soft);">
                    <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-pin-map"></i>
                    </span>
                    <div>
                        <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Адрес</div>
                        <div style="font-weight: 700; line-height: 1.5;">г. Москва, ул. Большая Дмитровка, д. 8, стр. 1<br><span class="text-muted" style="font-size: .88rem; font-weight: 600;">м. Кузнецкий мост / м. Театральная</span></div>
                    </div>
                </div>

                <div class="d-flex gap-3 py-3" style="border-bottom: 1px solid var(--rn-border-soft);">
                    <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-telephone"></i>
                    </span>
                    <div>
                        <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Телефон</div>
                        <div style="font-weight: 700; line-height: 1.5;">+7 (495) 987-65-43<br>+7 (916) 987-65-43</div>
                    </div>
                </div>

                <div class="d-flex gap-3 py-3" style="border-bottom: 1px solid var(--rn-border-soft);">
                    <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <div>
                        <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Email</div>
                        <div style="font-weight: 700; line-height: 1.5;">
                            <a href="mailto:hello@rosenails.ru" class="text-decoration-none" style="color: var(--rn-700);">hello@rosenails.ru</a><br>
                            <a href="mailto:booking@rosenails.ru" class="text-decoration-none" style="color: var(--rn-700);">booking@rosenails.ru</a>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 pt-3">
                    <span style="width: 2.6rem; height: 2.6rem; border-radius: .9rem; background: var(--rn-100); color: var(--rn-700); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-clock"></i>
                    </span>
                    <div>
                        <div class="text-muted" style="font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;">Режим работы</div>
                        <div style="font-weight: 700; line-height: 1.5;">
                            <span class="rn-chip mb-1">Пн–Пт: 9:00 – 21:00</span><br>
                            <span class="rn-chip">Сб–Вс: 10:00 – 19:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary">
                Мы на карте
            </div>
            <div class="card-body p-0">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU"></script>
<script>
    ymaps.ready(init);
    function init() {
        var coords = [55.7602, 37.6127];
        var myMap = new ymaps.Map("map", {
            center: coords, zoom: 16,
            controls: ['zoomControl', 'fullscreenControl']
        });
        var placemark = new ymaps.Placemark(coords, {
            hintContent: 'Rose Nails',
            balloonContent: `<strong>Rose Nails</strong><br>г. Москва, ул. Большая Дмитровка, д. 8, стр. 1`
        }, { preset: 'islands#pinkDotIcon' });
        myMap.geoObjects.add(placemark);
    }
</script>
@endpush