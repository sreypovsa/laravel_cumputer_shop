{{-- Five-stage delivery timeline for an order. Pass $order. --}}
@php
    $step = $order->tracking_step;
    $stages = [
        ['icon' => 'fa-receipt', 'title' => 'Order placed', 'time' => $order->created_at->format('d M, h:i A')],
        ['icon' => 'fa-money-check-dollar', 'title' => 'Payment confirmed', 'time' => $order->confirmed_at ? $order->confirmed_at->format('d M, h:i A') : 'Pending'],
        ['icon' => 'fa-box-open', 'title' => 'Packing & testing', 'time' => $step >= 3 ? 'In progress' : 'Upcoming'],
        ['icon' => 'fa-truck-fast', 'title' => 'Out for delivery', 'time' => $order->shipped_at ? $order->shipped_at->format('d M, h:i A') : 'Upcoming'],
        ['icon' => 'fa-house-circle-check', 'title' => 'Delivered', 'time' => $order->delivered_at ? $order->delivered_at->format('d M, h:i A') : 'Upcoming'],
    ];
@endphp
<div class="qt-track">
    @foreach($stages as $i => $stage)
        @php
            $n = $i + 1;
            $state = ($n < $step || ($n === 5 && $step >= 5)) ? 'is-done' : ($n === $step ? 'is-current' : '');
        @endphp
        <div class="qt-track__step {{ $state }}">
            <span class="qt-track__icon"><i class="fa-solid {{ $stage['icon'] }}"></i></span>
            <div>
                <div class="qt-track__title">{{ $stage['title'] }}</div>
                <div class="qt-track__time">{{ $stage['time'] }}</div>
            </div>
        </div>
    @endforeach
</div>
