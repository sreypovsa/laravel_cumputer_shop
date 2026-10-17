@extends('layouts.app')

@section('title', 'QuickTech Cambodia | Laptops, Gaming PCs & PC Parts in Phnom Penh')

@section('content')

<!-- PROMO POPUP -->
<div id="promoPopup" class="popup-overlay" role="dialog" aria-modal="true" aria-label="Special promotion" hidden>
    <div class="popup-content">
        <button type="button" class="popup-close" onclick="closePopup()" aria-label="Close promotion">&times;</button>
        <a href="{{ route('shop.index', ['brand' => 'asus']) }}">
            <img src="{{ asset('cc_assets/popup_asus.jpeg') }}" alt="Special promotion">
        </a>
    </div>
</div>

<div class="container">

    <!-- HERO -->
    <section class="qt-hero">
        <div class="qt-hero__grid">
            <div id="qtHeroCarousel" class="carousel slide carousel-fade qt-hero__main" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#qtHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#qtHeroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#qtHeroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <a href="{{ route('shop.index', ['brand' => 'asus']) }}"><img src="{{ asset('cc_assets/dealer_web.jpg') }}" alt="ASUS official promotion"></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href="{{ route('shop.index', ['brand' => 'apple']) }}"><img src="{{ asset('cc_assets/apple_banner.png') }}" alt="Apple MacBook"></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href="{{ route('shop.index') }}"><img src="{{ asset('cc_assets/cc_banner_01.jpg') }}" alt="QuickTech deals"></a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#qtHeroCarousel" data-bs-slide="prev">
                    <i class="fa-solid fa-chevron-left"></i><span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#qtHeroCarousel" data-bs-slide="next">
                    <i class="fa-solid fa-chevron-right"></i><span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="qt-hero__side">
                <a href="{{ route('shop.index', ['category' => 'gaming-laptops']) }}" class="qt-promo">
                    <i class="fa-solid fa-gamepad qt-promo__icon"></i>
                    <span class="qt-promo__tag">Gaming Series</span>
                    <h2 class="qt-promo__title">RTX gaming laptops</h2>
                    <p class="qt-promo__text">ROG, TUF, Legion, Predator &amp; more</p>
                    <span class="qt-promo__cta">Shop gaming <i class="fa-solid fa-arrow-right"></i></span>
                </a>
                <a href="{{ route('shop.index', ['category' => 'pc-components']) }}" class="qt-promo qt-promo--gold">
                    <i class="fa-solid fa-microchip qt-promo__icon"></i>
                    <span class="qt-promo__tag">Build &amp; Upgrade</span>
                    <h2 class="qt-promo__title">PC parts &amp; components</h2>
                    <p class="qt-promo__text">CPU, GPU, RAM, NVMe SSD</p>
                    <span class="qt-promo__cta">Explore parts <i class="fa-solid fa-arrow-right"></i></span>
                </a>
            </div>
        </div>

        <div class="qt-trust">
            <div class="qt-trust__item">
                <span class="qt-trust__icon"><i class="fa-solid fa-shield-halved"></i></span>
                <div><strong>100% Genuine</strong><span>Official brand warranty</span></div>
            </div>
            <div class="qt-trust__item">
                <span class="qt-trust__icon"><i class="fa-solid fa-truck-fast"></i></span>
                <div><strong>Fast Delivery</strong><span>Phnom Penh &amp; 24 provinces</span></div>
            </div>
            <div class="qt-trust__item">
                <span class="qt-trust__icon"><i class="fa-solid fa-gift"></i></span>
                <div><strong>Free Gift Bundle</strong><span>Backpack, mouse &amp; mousepad</span></div>
            </div>
            <div class="qt-trust__item">
                <span class="qt-trust__icon"><i class="fa-solid fa-headset"></i></span>
                <div><strong>Expert Support</strong><span>Telegram &amp; hotline help</span></div>
            </div>
        </div>
    </section>

    <!-- SHOP BY CATEGORY -->
    <section class="qt-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Browse</span>
                <h2>Shop by category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="qt-link-more">All products <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="qt-cats">
            <a href="{{ route('shop.index', ['category' => 'laptops-ultrabooks']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-laptop"></i></span><span>Laptops</span></a>
            <a href="{{ route('shop.index', ['category' => 'gaming-laptops']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-gamepad"></i></span><span>Gaming</span></a>
            <a href="{{ route('shop.index', ['category' => 'desktop-pc']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-desktop"></i></span><span>Desktop PC</span></a>
            <a href="{{ route('shop.index', ['category' => 'pc-components']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-microchip"></i></span><span>PC Parts</span></a>
            <a href="{{ route('shop.index', ['category' => 'monitors-peripherals']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-tv"></i></span><span>Monitors</span></a>
            <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-headphones"></i></span><span>Accessories</span></a>
            <a href="{{ route('shop.index', ['search' => 'SSD']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-hard-drive"></i></span><span>Storage</span></a>
            <a href="{{ route('shop.index', ['search' => 'printer']) }}" class="qt-cat"><span class="qt-cat__icon"><i class="fa-solid fa-print"></i></span><span>Printers</span></a>
        </div>
    </section>

    <!-- ASUS -->
    <section class="qt-section" id="asus-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Official Dealer</span>
                <h2>ASUS laptops</h2>
            </div>
            <div class="qt-chips qt-chips--scroll">
                <a href="{{ route('shop.index', ['search' => 'vivobook']) }}" class="qt-chip">Vivobook</a>
                <a href="{{ route('shop.index', ['search' => 'zenbook']) }}" class="qt-chip">Zenbook</a>
                <a href="{{ route('shop.index', ['search' => 'rog']) }}" class="qt-chip">ROG</a>
                <a href="{{ route('shop.index', ['search' => 'tuf']) }}" class="qt-chip">TUF Gaming</a>
                <a href="{{ route('shop.index', ['search' => 'zephyrus']) }}" class="qt-chip">Zephyrus</a>
                <a href="{{ route('shop.index', ['search' => 'expertbook']) }}" class="qt-chip">ExpertBook</a>
            </div>
        </div>
        <div class="qt-grid">
            @foreach($asusProducts->take(8) as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('shop.index', ['brand' => 'asus']) }}" class="btn btn-outline-primary">View all ASUS laptops <i class="fa-solid fa-arrow-right fa-xs"></i></a>
        </div>
    </section>

    <!-- GAMING -->
    @if($gamingLaptops->isNotEmpty())
    <section class="qt-section" id="gaming-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">High Performance</span>
                <h2>Gaming laptops &amp; RTX series</h2>
            </div>
            <div class="qt-chips qt-chips--scroll">
                <a href="{{ route('shop.index', ['search' => 'rog']) }}" class="qt-chip">ROG Strix</a>
                <a href="{{ route('shop.index', ['search' => 'tuf']) }}" class="qt-chip">TUF</a>
                <a href="{{ route('shop.index', ['search' => 'legion']) }}" class="qt-chip">Legion</a>
                <a href="{{ route('shop.index', ['search' => 'predator']) }}" class="qt-chip">Predator</a>
                <a href="{{ route('shop.index', ['search' => 'nitro']) }}" class="qt-chip">Nitro</a>
                <a href="{{ route('shop.index', ['search' => 'katana']) }}" class="qt-chip">Katana</a>
            </div>
        </div>
        <div class="qt-grid">
            @foreach($gamingLaptops as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('shop.index', ['category' => 'gaming-laptops']) }}" class="btn btn-primary">Explore gaming laptops <i class="fa-solid fa-arrow-right fa-xs"></i></a>
        </div>
    </section>
    @endif

    <!-- APPLE -->
    <section class="qt-section" id="apple-section">
        <a href="{{ route('shop.index', ['brand' => 'apple']) }}" class="qt-banner">
            <img src="{{ asset('cc_assets/apple_banner.png') }}" alt="Apple MacBook promotion" loading="lazy">
        </a>
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Featured</span>
                <h2>Editor's picks</h2>
            </div>
            <div class="qt-chips qt-chips--scroll">
                <a href="{{ route('shop.index', ['search' => 'macbook pro']) }}" class="qt-chip">MacBook Pro</a>
                <a href="{{ route('shop.index', ['search' => 'macbook air']) }}" class="qt-chip">MacBook Air</a>
                <a href="{{ route('shop.index', ['search' => 'm3']) }}" class="qt-chip">Apple M3</a>
                <a href="{{ route('shop.index', ['search' => 'm2']) }}" class="qt-chip">Apple M2</a>
            </div>
        </div>
        <div class="qt-grid">
            @foreach($featuredProducts->take(4) as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <!-- DESKTOP -->
    @if($desktopPcs->isNotEmpty())
    <section class="qt-section" id="desktop-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Custom Rigs</span>
                <h2>Desktop PCs &amp; workstations</h2>
            </div>
            <a href="{{ route('shop.index', ['category' => 'desktop-pc']) }}" class="qt-link-more">View all <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="qt-grid">
            @foreach($desktopPcs->take(4) as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    <!-- PC PARTS -->
    @if($pcComponents->isNotEmpty())
    <section class="qt-section" id="parts-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Hardware</span>
                <h2>PC parts, upgrades &amp; storage</h2>
            </div>
            <div class="qt-chips qt-chips--scroll">
                <a href="{{ route('shop.index', ['search' => 'rtx']) }}" class="qt-chip">Graphics Cards</a>
                <a href="{{ route('shop.index', ['search' => 'core']) }}" class="qt-chip">Processors</a>
                <a href="{{ route('shop.index', ['search' => 'ram']) }}" class="qt-chip">RAM</a>
                <a href="{{ route('shop.index', ['search' => 'ssd']) }}" class="qt-chip">NVMe SSD</a>
            </div>
        </div>
        <div class="qt-grid">
            @foreach($pcComponents->take(4) as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    <!-- BRANDS -->
    <section class="qt-section">
        <div class="qt-sec-head">
            <div>
                <span class="qt-eyebrow">Authorized</span>
                <h2>Shop by brand</h2>
            </div>
        </div>
        <div class="qt-brands">
            @foreach([
                ['ASUS', ['brand' => 'asus']], ['ROG', ['brand' => 'rog']], ['TUF', ['brand' => 'tuf-gaming']],
                ['MSI', ['brand' => 'msi']], ['ACER', ['brand' => 'acer']], ['APPLE', ['brand' => 'apple']],
                ['DELL', ['brand' => 'dell']], ['LENOVO', ['brand' => 'lenovo']], ['LEGION', ['brand' => 'legion']],
                ['PREDATOR', ['search' => 'predator']], ['RAZER', ['brand' => 'razer']], ['HP', ['brand' => 'hp']],
            ] as [$name, $params])
                <a href="{{ route('shop.index', $params) }}" class="qt-brand">{{ $name }}</a>
            @endforeach
        </div>
    </section>

    <!-- CTA -->
    <section class="qt-section">
        <div class="qt-cta">
            <div>
                <h3>Not sure which laptop fits you?</h3>
                <p>Tell us your budget and how you'll use it — our team will help you choose on Telegram.</p>
            </div>
            <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" class="btn btn-gold btn-lg">
                <i class="fa-brands fa-telegram"></i> Ask an expert
            </a>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
    const promoPopup = document.getElementById('promoPopup');

    function closePopup() {
        promoPopup.hidden = true;
        try { sessionStorage.setItem('qt_promo_seen', '1'); } catch (e) {}
    }

    (function () {
        let seen = false;
        try { seen = !!sessionStorage.getItem('qt_promo_seen'); } catch (e) {}
        if (!seen) {
            setTimeout(function () {
                promoPopup.hidden = false;
                promoPopup.querySelector('.popup-close').focus();
            }, 5000);
        }
    })();

    promoPopup.addEventListener('click', function (event) {
        if (event.target === promoPopup) closePopup();
    });

    document.addEventListener('keydown', function (event) {
        if (promoPopup.hidden) return;
        if (event.key === 'Escape') { closePopup(); return; }
        if (event.key === 'Tab') {
            const focusable = promoPopup.querySelectorAll('a[href], button:not([disabled])');
            const first = focusable[0], last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
    });
</script>
@endsection
