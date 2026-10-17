{{-- Checkout progress indicator. Pass $current: 1 = Cart, 2 = Delivery, 3 = Payment, 4 = Done --}}
<ol class="qt-steps" aria-label="Checkout progress">
    @foreach(['Cart', 'Delivery', 'Payment'] as $i => $label)
        @php $n = $i + 1; @endphp
        <li class="{{ $n < $current ? 'is-done' : ($n === $current ? 'is-current' : '') }}" @if($n === $current) aria-current="step" @endif>
            <span class="qt-steps__dot">
                @if($n < $current)<i class="fa-solid fa-check"></i>@else{{ $n }}@endif
            </span>
            {{ $label }}
        </li>
    @endforeach
</ol>
