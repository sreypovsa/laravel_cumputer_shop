@php $me = auth()->user(); @endphp
<aside class="qt-card qt-acc-nav">
    <div class="qt-acc-nav__user">
        <span class="qt-avatar">{{ strtoupper(mb_substr($me->name, 0, 1)) }}</span>
        <div class="min-w-0">
            <strong>{{ $me->name }}</strong>
            <span>{{ $me->email }}</span>
        </div>
    </div>
    <nav class="qt-acc-nav__links" aria-label="Account">
        <a href="{{ route('account.index') }}" class="{{ request()->routeIs('account.index', 'account.order') ? 'is-active' : '' }}"><i class="fa-solid fa-box"></i> My orders</a>
        <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile') ? 'is-active' : '' }}"><i class="fa-regular fa-user"></i> Profile &amp; security</a>
        <a href="{{ route('track.order') }}"><i class="fa-solid fa-location-crosshairs"></i> Track an order</a>
        @if($me->is_admin)
            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i> Admin dashboard</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="is-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign out</button>
        </form>
    </nav>
</aside>
