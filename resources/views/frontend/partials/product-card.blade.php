@php
    $isSale = $product->original_price && $product->original_price > $product->price;
    $isFeatured = !empty($product->is_featured) || $product->price >= 800;

    // Pick up to 3 key spec lines (CPU / RAM / Storage / GPU first) for a compact summary
    $specIcons = ['CPU' => 'fa-microchip', 'RAM' => 'fa-memory', 'SSD' => 'fa-hard-drive', 'STORAGE' => 'fa-hard-drive', 'VGA' => 'fa-display', 'GPU' => 'fa-display', 'DISPLAY' => 'fa-display'];
    $keySpecs = [];
    foreach ($product->specs_list as $line) {
        $clean = trim(ltrim($line, "- \t"));
        if ($clean === '') continue;
        $label = strtoupper(trim(explode(':', $clean, 2)[0]));
        $value = str_contains($clean, ':') ? trim(explode(':', $clean, 2)[1]) : $clean;
        $icon = 'fa-circle-check';
        foreach ($specIcons as $k => $ic) {
            if (str_contains($label, $k)) { $icon = $ic; break; }
        }
        $keySpecs[] = ['icon' => $icon, 'value' => $value];
        if (count($keySpecs) === 3) break;
    }
    $tgText = urlencode('Hello QuickTech, I want to inquire about: ' . $product->name . ' ($' . number_format($product->price, 0) . ') - Code: ' . ($product->code ?? $product->slug));
@endphp

<article class="qt-product">
    <div class="qt-product__badges">
        @if($product->discount_percent)
            <span class="qt-tag qt-tag--sale">-{{ $product->discount_percent }}%</span>
        @endif
        @if($isFeatured)
            <span class="qt-tag qt-tag--hot"><i class="fa-solid fa-crown"></i> Premium</span>
        @endif
    </div>

    <a href="https://t.me/QUICKTECHCAM?text={{ $tgText }}" target="_blank" rel="noopener" class="qt-product__quick" title="Ask on Telegram" aria-label="Ask about {{ $product->name }} on Telegram">
        <i class="fa-brands fa-telegram"></i>
    </a>

    <a href="{{ route('shop.show', $product->slug) }}" class="qt-product__media" title="{{ $product->name }}">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/mock-laptop-1.png') }}';">
    </a>

    <div class="qt-product__body">
        <div class="qt-product__brand">{{ $product->brand->name ?? ($product->category->name ?? 'QuickTech') }}</div>
        <a href="{{ route('shop.show', $product->slug) }}" class="qt-product__title" title="{{ $product->name }}">{{ $product->name }}</a>

        @if(count($keySpecs))
            <ul class="qt-specs">
                @foreach($keySpecs as $spec)
                    <li><i class="fa-solid {{ $spec['icon'] }}"></i><span>{{ $spec['value'] }}</span></li>
                @endforeach
            </ul>
        @else
            <ul class="qt-specs">
                <li><i class="fa-solid fa-shield-halved"></i><span>1 year official warranty</span></li>
                <li><i class="fa-solid fa-circle-check"></i><span>In stock · Ready to ship</span></li>
            </ul>
        @endif

        <div class="qt-gift"><i class="fa-solid fa-gift"></i> Free backpack, mouse &amp; mousepad</div>

        <div class="qt-product__foot">
            <div class="qt-price">
                @if($isSale)
                    <span class="qt-price__old">${{ number_format($product->original_price, 0) }}</span>
                @endif
                <span class="qt-price__now {{ $isSale ? 'is-sale' : '' }}">${{ number_format($product->price, 0) }}</span>
            </div>
            <button type="button" class="qt-add-btn btn-ajax-add-cart" data-product-id="{{ $product->id }}" aria-label="Add {{ $product->name }} to cart">
                <i class="fa-solid fa-cart-plus"></i> Add
            </button>
        </div>
    </div>
</article>
