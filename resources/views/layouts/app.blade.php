<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="QuickTech Cambodia - Laptops, gaming PCs, PC parts and accessories in Phnom Penh. Authorized ASUS, ACER, DELL, APPLE, LENOVO, HP and more, with nationwide delivery.">
    <meta name="keywords" content="QuickTech Cambodia, computer, laptop, gaming laptop, desktop PC, PC parts, Phnom Penh, Asus, Acer, Dell, HP, Lenovo, MacBook">
    <meta name="theme-color" content="#16264F">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'QuickTech Cambodia | Laptop & PC Store, Phnom Penh')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/quicktech-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/quicktech-icon.png') }}">

    <!-- Fonts: Plus Jakarta Sans (Latin) + Kantumruy Pro (Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('nevixra_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('nevixra_assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/qt-store.css') }}?v=2" rel="stylesheet">

    @yield('styles')
</head>
<body id="top">

    <!-- TOP INFO BAR -->
    <div class="qt-topbar d-none d-md-block">
        <div class="container">
            <div class="qt-topbar__msg">
                <span><i class="fa-solid fa-shield-halved"></i> 100% genuine with official warranty</span>
                <span class="d-none d-lg-inline-flex"><i class="fa-solid fa-truck-fast"></i> Fast delivery to all 25 provinces</span>
                <span class="d-none d-xl-inline-flex"><i class="fa-solid fa-qrcode"></i> Pay with ABA, ACLEDA &amp; Wing KHQR</span>
            </div>
            <div class="qt-topbar__links">
                <a href="{{ route('track.order') }}"><i class="fa-solid fa-location-crosshairs"></i> Track order</a>
                <a href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> Contact</a>
                <a href="tel:015646581"><i class="fa-solid fa-phone"></i> 015 646 581</a>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="qt-header">
        <div class="container">
            <div class="qt-header__row">
                <a href="{{ route('home') }}" class="qt-logo" aria-label="QuickTech Cambodia home">
                    <img src="{{ asset('images/quicktech-logo.png') }}" alt="QuickTech Cambodia">
                </a>

                <form class="qt-search d-none d-md-block" action="{{ route('shop.index') }}" method="GET" role="search">
                    <i class="fa-solid fa-magnifying-glass qt-search__icon"></i>
                    <input type="search" name="search" placeholder="Search laptops, PCs, parts, brands..." value="{{ request('search') }}" aria-label="Search products">
                    <button type="submit" class="qt-search__btn" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
                </form>

                <div class="qt-actions">
                    <a class="qt-action d-none d-xl-inline-flex" href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener">
                        <span class="qt-action__icon"><i class="fa-brands fa-telegram"></i></span>
                        <span class="qt-action__text"><small>Chat with us</small><strong>Telegram</strong></span>
                    </a>
                    <a class="qt-action d-none d-sm-inline-flex" href="tel:015646581">
                        <span class="qt-action__icon"><i class="fa-solid fa-headset"></i></span>
                        <span class="qt-action__text"><small>Hotline</small><strong>015 646 581</strong></span>
                    </a>
                    @auth
                        <div class="qt-user-menu" id="userMenu">
                            <button type="button" class="qt-action" aria-haspopup="true" aria-expanded="false" aria-controls="userMenuPanel" data-user-menu-toggle>
                                <span class="qt-avatar qt-avatar--sm">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="qt-action__text"><small>Hello,</small><strong>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::before(auth()->user()->name, ' ') ?: auth()->user()->name, 12) }}</strong></span>
                            </button>
                            <div class="dropdown-menu" id="userMenuPanel">
                                <div class="dropdown-header">
                                    <strong class="d-block text-dark">{{ auth()->user()->name }}</strong>
                                    <span class="small text-muted">{{ auth()->user()->email }}</span>
                                </div>
                                <a class="dropdown-item" href="{{ route('account.index') }}"><i class="fa-solid fa-box"></i> My orders</a>
                                <a class="dropdown-item" href="{{ route('account.profile') }}"><i class="fa-regular fa-user"></i> Profile &amp; security</a>
                                @if(auth()->user()->is_admin)
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i> Admin dashboard</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a class="qt-action" href="{{ route('login') }}" aria-label="Sign in">
                            <span class="qt-action__icon"><i class="fa-regular fa-user"></i></span>
                            <span class="qt-action__text"><small>Welcome</small><strong>Sign in</strong></span>
                        </a>
                    @endauth
                    <a class="qt-action" href="{{ route('cart.index') }}" aria-label="Shopping cart">
                        <span class="qt-action__icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span id="headerCartCount" class="qt-cart-badge">{{ $globalCartCount ?? 0 }}</span>
                        </span>
                        <span class="qt-action__text"><small>Your cart</small><strong>View cart</strong></span>
                    </a>
                    <button class="qt-action d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Open menu">
                        <span class="qt-action__icon"><i class="fa-solid fa-bars"></i></span>
                    </button>
                </div>
            </div>

            <form class="qt-search d-md-none pb-3" action="{{ route('shop.index') }}" method="GET" role="search">
                <i class="fa-solid fa-magnifying-glass qt-search__icon"></i>
                <input type="search" name="search" placeholder="Search products..." value="{{ request('search') }}" aria-label="Search products">
                <button type="submit" class="qt-search__btn" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
            </form>
        </div>
    </header>

    @php
        $navItems = [
            ['label' => 'Laptops', 'icon' => 'fa-laptop', 'params' => ['category' => 'laptops-ultrabooks'], 'key' => ['category', 'laptops-ultrabooks']],
            ['label' => 'Gaming', 'icon' => 'fa-gamepad', 'params' => ['category' => 'gaming-laptops'], 'key' => ['category', 'gaming-laptops']],
            ['label' => 'Desktop PC', 'icon' => 'fa-desktop', 'params' => ['category' => 'desktop-pc'], 'key' => ['category', 'desktop-pc']],
            ['label' => 'PC Parts', 'icon' => 'fa-microchip', 'params' => ['category' => 'pc-components'], 'key' => ['category', 'pc-components']],
            ['label' => 'Peripherals', 'icon' => 'fa-keyboard', 'params' => ['category' => 'monitors-peripherals'], 'key' => ['category', 'monitors-peripherals']],
            ['label' => 'Accessories', 'icon' => 'fa-headphones', 'params' => ['category' => 'accessories'], 'key' => ['category', 'accessories']],
            ['label' => 'Storage', 'icon' => 'fa-hard-drive', 'params' => ['search' => 'SSD'], 'key' => ['search', 'SSD']],
            ['drawerOnly' => true, 'label' => 'Network', 'icon' => 'fa-wifi', 'params' => ['search' => 'network'], 'key' => ['search', 'network']],
            ['drawerOnly' => true, 'label' => 'Printers', 'icon' => 'fa-print', 'params' => ['search' => 'printer'], 'key' => ['search', 'printer']],
            ['label' => 'Second Hand', 'icon' => 'fa-recycle', 'params' => ['search' => 'used'], 'key' => ['search', 'used']],
        ];
    @endphp

    <!-- CATEGORY NAV -->
    <nav class="qt-nav d-none d-lg-block" aria-label="Product categories">
        <div class="container">
            <ul class="qt-nav__list">
                <li>
                    <a class="qt-nav__link {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>
                @foreach(array_filter($navItems, fn ($i) => empty($i['drawerOnly'])) as $item)
                    <li>
                        <a class="qt-nav__link {{ request($item['key'][0]) === $item['key'][1] ? 'is-active' : '' }}" href="{{ route('shop.index', $item['params']) }}">
                            <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
                <li class="ms-auto">
                    <a class="qt-nav__link qt-nav__link--accent {{ request()->routeIs('shop.index') && !request()->hasAny(['category', 'search', 'brand']) ? 'is-active' : '' }}" href="{{ route('shop.index') }}">
                        <i class="fa-solid fa-grip"></i> All Products
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- MOBILE DRAWER -->
    <div class="offcanvas offcanvas-end qt-drawer" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <img id="mobileMenuLabel" src="{{ asset('images/quicktech-logo-light.png') }}" alt="QuickTech Cambodia">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="qt-drawer__contact">
                <div class="fw-bold text-dark mb-1"><i class="fa-solid fa-headset me-2" style="color: var(--qt-gold-600)"></i>015 646 581 / 012 646 581</div>
                <div class="text-muted small">Phnom Penh, Cambodia · 8:00 AM – 7:30 PM</div>
            </div>
            <div class="qt-drawer__links">
                <div class="qt-drawer__label">Shop</div>
                <a href="{{ route('shop.index') }}"><i class="fa-solid fa-grip"></i> All Products</a>
                @foreach($navItems as $item)
                    <a href="{{ route('shop.index', $item['params']) }}"><i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['label'] }}</a>
                @endforeach
                <div class="qt-drawer__label">Account</div>
                @auth
                    <a href="{{ route('account.index') }}"><i class="fa-solid fa-box"></i> My orders</a>
                    <a href="{{ route('account.profile') }}"><i class="fa-regular fa-user"></i> Profile &amp; security</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-100 border-0 bg-transparent text-start d-flex align-items-center gap-3 fw-semibold" style="padding: 11px 12px; border-radius: 10px; font-size: 14px; color: var(--qt-sale);"><i class="fa-solid fa-arrow-right-from-bracket" style="width: 18px; text-align: center;"></i> Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> Sign in</a>
                    <a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> Create account</a>
                @endauth
                <div class="qt-drawer__label">Help</div>
                <a href="{{ route('track.order') }}"><i class="fa-solid fa-location-crosshairs"></i> Track Your Order</a>
                <a href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> About Us</a>
                <a href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> Contact Us</a>
                <a href="{{ route('admin.login') }}"><i class="fa-solid fa-lock"></i> Admin Login</a>
            </div>
            <div class="px-4 py-3">
                <div class="qt-social">
                    <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="Facebook" style="background: var(--qt-navy)"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="Telegram" style="background: var(--qt-navy)"><i class="fa-brands fa-telegram"></i></a>
                    <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="WhatsApp" style="background: var(--qt-navy)"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success') || session('error'))
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-0" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-0" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    @endif

    <main class="qt-main">
        @yield('content')
    </main>

    <!-- TOAST -->
    <div id="ccToast" class="toast align-items-center text-white border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check" style="color: var(--qt-gold)"></i>
                <span id="ccToastMsg">Product added to cart!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <!-- FLOATING ACTIONS -->
    <div class="qt-float">
        <button type="button" class="qt-float__top" id="backToTopBtn" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
        <a href="https://t.me/QUICKTECHCAM" class="qt-float__tg" target="_blank" rel="noopener" aria-label="Chat on Telegram"><i class="fa-brands fa-telegram"></i></a>
    </div>

    <!-- MOBILE BOTTOM NAV -->
    <nav class="qt-bottom-nav" aria-label="Quick navigation">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}"><i class="fa-solid fa-house"></i> Home</a>
        <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'is-active' : '' }}"><i class="fa-solid fa-grip"></i> Shop</a>
        <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*', 'checkout.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-bag-shopping"></i> Cart
            <span class="qt-cart-badge js-cart-count">{{ $globalCartCount ?? 0 }}</span>
        </a>
        <a href="{{ route('track.order') }}" class="{{ request()->routeIs('track.*') ? 'is-active' : '' }}"><i class="fa-solid fa-location-crosshairs"></i> Track</a>
        <a href="{{ auth()->check() ? route('account.index') : route('login') }}" class="{{ request()->routeIs('account.*', 'login', 'register') ? 'is-active' : '' }}"><i class="fa-regular fa-user"></i> Account</a>
    </nav>

    <!-- FOOTER -->
    <footer class="qt-footer">
        <div class="container qt-footer__top">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4 col-md-6">
                    <img src="{{ asset('images/quicktech-logo-light.png') }}" alt="QuickTech Cambodia" class="qt-footer__logo">
                    <p class="mb-0" style="max-width: 340px; line-height: 1.7;">
                        Your trusted technology partner in Phnom Penh — genuine laptops, gaming rigs, PC parts and accessories with official warranty and after-sales support.
                    </p>
                    <div class="qt-footer__contact">
                        <div><i class="fa-solid fa-location-dot"></i> Phnom Penh, Cambodia</div>
                        <div><i class="fa-solid fa-phone"></i> <a href="tel:015646581">015 646 581</a> / <a href="tel:012646581">012 646 581</a></div>
                        <div><i class="fa-regular fa-clock"></i> Mon – Sun, 8:00 AM – 7:30 PM</div>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="{{ route('shop.index', ['category' => 'laptops-ultrabooks']) }}">Laptops</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'gaming-laptops']) }}">Gaming Laptops</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'desktop-pc']) }}">Desktop PCs</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'pc-components']) }}">PC Parts</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'accessories']) }}">Accessories</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-6">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="{{ auth()->check() ? route('account.index') : route('login') }}">My Account</a></li>
                        <li><a href="{{ route('track.order') }}">Track Order</a></li>
                        <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('admin.login') }}">Admin Login</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h4>We Accept</h4>
                    <div class="qt-footer__pay mb-4">
                        <span>ABA KHQR</span>
                        <span>ACLEDA</span>
                        <span>Wing Bank</span>
                        <span>Cash on Delivery</span>
                    </div>
                    <h4>Follow Us</h4>
                    <div class="qt-social">
                        <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="Telegram"><i class="fa-brands fa-telegram"></i></a>
                        <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" aria-label="WeChat"><i class="fa-brands fa-weixin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="qt-footer__bottom">
            <div class="container d-flex flex-wrap justify-content-between gap-2">
                <span>&copy; {{ date('Y') }} QuickTech Cambodia. All rights reserved.</span>
                <span>Authorized retailer &amp; technical support in Cambodia</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('nevixra_assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('nevixra_assets/js/bootstrap.min.js') }}"></script>

    <script>
        // Add to cart (AJAX)
        $(document).on('click', '.btn-ajax-add-cart', function (e) {
            e.preventDefault();
            const btn = $(this);
            const origHtml = btn.html();
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: btn.data('product-id'),
                    quantity: btn.data('qty') || 1
                },
                success: function (res) {
                    btn.html('<i class="fa-solid fa-check"></i> Added');
                    setTimeout(() => btn.prop('disabled', false).html(origHtml), 1200);
                    $('#headerCartCount, .js-cart-count').text(res.cart_count);
                    showCcToast(res.message || 'Product added to cart!');
                },
                error: function () {
                    btn.prop('disabled', false).html(origHtml);
                    showCcToast('Could not add product to cart.', true);
                }
            });
        });

        function showCcToast(msg, isError = false) {
            const toastEl = document.getElementById('ccToast');
            document.getElementById('ccToastMsg').innerText = msg;
            toastEl.classList.toggle('bg-danger', isError);
            new bootstrap.Toast(toastEl, { delay: 3000 }).show();
        }

        // Account menu (lightweight, no Popper needed)
        (function () {
            const menu = document.getElementById('userMenu');
            if (!menu) return;
            const toggle = menu.querySelector('[data-user-menu-toggle]');
            const panel = menu.querySelector('.dropdown-menu');
            const setOpen = (open) => { panel.classList.toggle('show', open); toggle.setAttribute('aria-expanded', open); };
            toggle.addEventListener('click', (e) => { e.stopPropagation(); setOpen(!panel.classList.contains('show')); });
            document.addEventListener('click', (e) => { if (!menu.contains(e.target)) setOpen(false); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { setOpen(false); toggle.focus(); } });
        })();

        // Back to top
        const backToTop = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => backToTop.classList.toggle('is-visible', window.scrollY > 400), { passive: true });
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    </script>

    @yield('scripts')
</body>
</html>
