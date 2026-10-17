{{-- Pill badge for an order or payment status. Pass $status (e.g. pending, shipping, paid). --}}
@php
    $labels = ['pending' => 'Pending', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipping' => 'Shipping', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled', 'paid' => 'Paid', 'rejected' => 'Rejected'];
@endphp
<span class="qt-badge qt-badge--{{ $status }}">{{ $label ?? ($labels[$status] ?? ucfirst($status)) }}</span>
