<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CcComputerKhSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin & Customer Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Administrator',
                'phone' => '015 646 581',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Sokha Mean',
                'phone' => '012 345 678',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // 2. Categories
        $categoriesData = [
            'laptops' => ['name' => 'Laptops & Ultrabooks', 'icon' => 'ti-device-laptop', 'image' => 'nevixra_assets/images/category-item-image-1.png'],
            'gaming-laptops' => ['name' => 'Gaming Laptops', 'icon' => 'ti-device-gamepad-2', 'image' => 'nevixra_assets/images/category-item-image-2.png'],
            'desktop-pc' => ['name' => 'Desktop PC & Workstations', 'icon' => 'ti-device-desktop', 'image' => 'nevixra_assets/images/category-item-image-3.png'],
            'pc-components' => ['name' => 'PC Components & Parts', 'icon' => 'ti-cpu', 'image' => 'nevixra_assets/images/category-item-image-4.png'],
            'monitors-peripherals' => ['name' => 'Monitors & Peripherals', 'icon' => 'ti-screen-share', 'image' => 'nevixra_assets/images/category-item-image-5.png'],
            'accessories' => ['name' => 'Computer Accessories', 'icon' => 'ti-headphones', 'image' => 'nevixra_assets/images/category-item-image-6.png'],
        ];

        $categories = [];
        foreach ($categoriesData as $slug => $data) {
            $categories[$slug] = Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'image' => $data['image'],
                    'description' => 'High quality ' . $data['name'] . ' from top brands.',
                    'is_active' => true,
                ]
            );
        }

        // 3. Brands
        $brandsList = [
            'ASUS' => 'nevixra_assets/images/our-brands-image-1.svg',
            'ROG' => 'nevixra_assets/images/our-brands-image-2.svg',
            'TUF Gaming' => 'nevixra_assets/images/our-brands-image-3.svg',
            'MSI' => 'nevixra_assets/images/our-brands-image-4.svg',
            'Apple' => 'nevixra_assets/images/our-brands-image-5.svg',
            'Acer' => 'nevixra_assets/images/our-brands-image-6.svg',
            'DELL' => 'nevixra_assets/images/our-brands-image-7.svg',
            'Alienware' => 'nevixra_assets/images/our-brands-image-8.svg',
            'Lenovo' => 'nevixra_assets/images/our-brands-image-1.svg',
            'Legion' => 'nevixra_assets/images/our-brands-image-2.svg',
            'HP' => 'nevixra_assets/images/our-brands-image-3.svg',
            'Razer' => 'nevixra_assets/images/our-brands-image-4.svg',
            'Intel' => 'nevixra_assets/images/our-brands-image-5.svg',
            'AMD' => 'nevixra_assets/images/our-brands-image-6.svg',
            'NVIDIA' => 'nevixra_assets/images/our-brands-image-7.svg',
            'Samsung' => 'nevixra_assets/images/our-brands-image-8.svg',
            'Kingston' => 'nevixra_assets/images/our-brands-image-1.svg',
            'Corsair' => 'nevixra_assets/images/our-brands-image-2.svg',
            'Logitech' => 'nevixra_assets/images/our-brands-image-3.svg',
            'HyperWork' => 'nevixra_assets/images/our-brands-image-4.svg',
        ];

        $brands = [];
        foreach ($brandsList as $name => $logo) {
            $brands[strtoupper($name)] = Brand::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'logo' => $logo,
                ]
            );
        }

        // 4. Parse cccomputerkh HTML files
        $sourceFiles = [
            base_path('cccomputerkh_raw.html') => 'laptops',
            base_path('cc_newpc.html') => 'desktop-pc',
            base_path('cc_pcpart.html') => 'pc-components',
            base_path('cc_peripherals.html') => 'monitors-peripherals',
        ];

        $insertedCount = 0;
        $seenTitles = [];

        foreach ($sourceFiles as $filePath => $defaultCatSlug) {
            if (!file_exists($filePath)) continue;

            $html = file_get_contents($filePath);
            $dom = new DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            $xpath = new DOMXPath($dom);

            $boxes = $xpath->query('//div[contains(@class, "leftbox") or contains(@class, "centerbox") or contains(@class, "rightbox")]');

            foreach ($boxes as $box) {
                $titleNode = $xpath->query('.//p[contains(@class, "title")]', $box);
                $priceNode = $xpath->query('.//p[contains(@class, "sp")]', $box);
                $imgNode = $xpath->query('.//img[contains(@class, "pro") or @src]', $box);
                $txtNode = $xpath->query('.//p[contains(@class, "txt")]', $box);

                if ($titleNode->length === 0 || $priceNode->length === 0) continue;

                $title = trim($titleNode->item(0)->textContent);
                $priceText = trim($priceNode->item(0)->textContent);
                $descText = $txtNode->length ? trim($txtNode->item(0)->textContent) : '';
                $imgSrc = $imgNode->length ? trim($imgNode->item(0)->getAttribute('src')) : '';

                if (empty($title) || empty($priceText)) continue;

                // Parse prices
                preg_match_all('/\$([0-9,]+(?:\.[0-9]{1,2})?)/', $priceText, $priceMatches);
                if (empty($priceMatches[1])) continue;

                $prices = array_map(fn($p) => (float)str_replace(',', '', $p), $priceMatches[1]);
                if (count($prices) >= 2) {
                    $originalPrice = max($prices);
                    $price = min($prices);
                } else {
                    $price = $prices[0];
                    $originalPrice = round($price * 1.12, 2);
                }

                if ($price <= 0) continue;

                // Extract product code and free gifts
                $code = null;
                if (preg_match('/Code\s*:\s*([A-Za-z0-9\-_]+)/i', $descText, $cm)) {
                    $code = trim($cm[1]);
                }

                $freeGifts = null;
                if (preg_match_all('/Free\s*:\s*([^\r\n]+)/i', $descText, $gm)) {
                    $freeGifts = implode(', ', array_map('trim', $gm[1]));
                }

                // Detect Brand
                $detectedBrandId = null;
                $upperTitle = strtoupper($title . ' ' . $descText);
                foreach ($brands as $bName => $bModel) {
                    if (str_contains($upperTitle, $bName)) {
                        $detectedBrandId = $bModel->id;
                        break;
                    }
                }

                // Categorize
                $catSlug = $defaultCatSlug;
                if ($defaultCatSlug === 'laptops') {
                    if (
                        str_contains($upperTitle, 'ROG') ||
                        str_contains($upperTitle, 'TUF') ||
                        str_contains($upperTitle, 'KATANA') ||
                        str_contains($upperTitle, 'CYBORG') ||
                        str_contains($upperTitle, 'PREDATOR') ||
                        str_contains($upperTitle, 'NITRO') ||
                        str_contains($upperTitle, 'LEGION') ||
                        str_contains($upperTitle, 'LOQ') ||
                        str_contains($upperTitle, 'ALIENWARE') ||
                        str_contains($upperTitle, 'VICTUS') ||
                        str_contains($upperTitle, 'OMEN') ||
                        str_contains($upperTitle, 'RAZER')
                    ) {
                        $catSlug = 'gaming-laptops';
                    }
                }

                $categoryId = $categories[$catSlug]->id ?? $categories['laptops']->id;

                // Image URL
                $imageUrl = null;
                if (!empty($imgSrc)) {
                    $imageUrl = 'https://cccomputerkh.com/' . ltrim($imgSrc, '/');
                }

                // Ensure unique name/code in seeder
                $uniqueKey = $title . ($code ? '-' . $code : '-' . $price);
                if (isset($seenTitles[$uniqueKey])) continue;
                $seenTitles[$uniqueKey] = true;

                $slug = Str::slug($title);
                if (Product::where('slug', $slug)->exists()) {
                    $slug .= '-' . Str::lower(Str::random(6));
                }

                Product::create([
                    'category_id' => $categoryId,
                    'brand_id' => $detectedBrandId,
                    'name' => $title . ($code ? ' (' . $code . ')' : ''),
                    'slug' => $slug,
                    'code' => $code ?: 'CC-' . strtoupper(Str::random(6)),
                    'original_price' => $originalPrice,
                    'price' => $price,
                    'stock' => rand(5, 30),
                    'image' => $imageUrl,
                    'specs' => $descText,
                    'description' => "Genuine Cambodian stock from CC COMPUTER KH. Full manufacturer warranty with free gifts and technical service support.",
                    'free_gifts' => $freeGifts,
                    'is_featured' => rand(0, 100) < 25,
                    'is_new' => true,
                    'status' => 'active',
                ]);

                $insertedCount++;
            }
        }

        // 5. Create realistic sample orders in Cambodia
        $sampleOrders = [
            [
                'order_number' => 'CC-20260925-1011',
                'tracking_code' => 'TRK-982145',
                'customer_name' => 'Chann Vandy',
                'customer_phone' => '098 765 432',
                'customer_email' => 'vandy.chann@gmail.com',
                'delivery_province' => 'Phnom Penh',
                'delivery_district' => 'Khan Tuol Kouk',
                'delivery_commune' => 'Sangkat Boeng Kak 1',
                'delivery_address' => 'St. 315, House #42, Phnom Penh',
                'delivery_carrier' => 'Phnom Penh Same-Day Express',
                'shipping_fee' => 1.50,
                'payment_method' => 'aba_khqr',
                'payment_status' => 'paid',
                'order_status' => 'shipping',
                'courier_tracking_number' => 'GRAB-882194',
                'notes' => 'Customer requested call 15 minutes before arrival',
                'confirmed_at' => now()->subHours(5),
                'shipped_at' => now()->subHours(2),
            ],
            [
                'order_number' => 'CC-20260925-1012',
                'tracking_code' => 'TRK-615284',
                'customer_name' => 'Rithy Seng',
                'customer_phone' => '077 112 233',
                'customer_email' => 'rithy.seng@gmail.com',
                'delivery_province' => 'Siem Reap',
                'delivery_district' => 'Krong Siem Reap',
                'delivery_commune' => 'Sangkat Svay Dangkum',
                'delivery_address' => 'Wat Bo Road, Near Old Market, Siem Reap',
                'delivery_carrier' => 'Virak Buntham (VET Express)',
                'shipping_fee' => 2.50,
                'payment_method' => 'acleda_khqr',
                'payment_status' => 'paid',
                'order_status' => 'confirmed',
                'courier_tracking_number' => 'VET-SR-91823',
                'notes' => 'Deliver to Virak Buntham Siem Reap Branch for pickup',
                'confirmed_at' => now()->subHours(1),
            ],
            [
                'order_number' => 'CC-20260925-1013',
                'tracking_code' => 'TRK-447192',
                'customer_name' => 'Bopha Pich',
                'customer_phone' => '015 998 877',
                'customer_email' => 'bopha.pich@gmail.com',
                'delivery_province' => 'Battambang',
                'delivery_district' => 'Krong Battambang',
                'delivery_commune' => 'Sangkat Svay Pao',
                'delivery_address' => 'Street 2.5, House #18, Battambang',
                'delivery_carrier' => 'J&T Express Cambodia',
                'shipping_fee' => 2.00,
                'payment_method' => 'wing_khqr',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'courier_tracking_number' => null,
                'notes' => 'Pending admin verification of Wing transfer',
            ],
            [
                'order_number' => 'CC-20260925-1014',
                'tracking_code' => 'TRK-223910',
                'customer_name' => 'Visal Chea',
                'customer_phone' => '089 554 433',
                'customer_email' => 'visal.chea@gmail.com',
                'delivery_province' => 'Kandal',
                'delivery_district' => 'Krong Ta Khmau',
                'delivery_commune' => 'Sangkat Ta Khmau',
                'delivery_address' => 'National Road 2, Near Ta Khmau Market',
                'delivery_carrier' => 'Capitol Express',
                'shipping_fee' => 1.50,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'order_status' => 'processing',
                'courier_tracking_number' => 'CAP-KD-1029',
                'notes' => 'Cash on delivery, prepare exact change',
                'confirmed_at' => now()->subDay(),
            ],
            [
                'order_number' => 'CC-20260925-1015',
                'tracking_code' => 'TRK-771829',
                'customer_name' => 'Serey Roth',
                'customer_phone' => '012 887 766',
                'customer_email' => 'serey.roth@gmail.com',
                'delivery_province' => 'Sihanoukville',
                'delivery_district' => 'Krong Preah Sihanouk',
                'delivery_commune' => 'Sangkat 4',
                'delivery_address' => 'Ekareach Street, Downtown Sihanoukville',
                'delivery_carrier' => 'Virak Buntham (VET Express)',
                'shipping_fee' => 2.50,
                'payment_method' => 'aba_khqr',
                'payment_status' => 'paid',
                'order_status' => 'delivered',
                'courier_tracking_number' => 'VET-SHV-33910',
                'notes' => 'Package received by customer',
                'confirmed_at' => now()->subDays(3),
                'shipped_at' => now()->subDays(2),
                'delivered_at' => now()->subDay(),
            ],
        ];

        // Attach random products to sample orders
        $allProducts = Product::take(15)->get();
        if ($allProducts->isNotEmpty()) {
            foreach ($sampleOrders as $ord) {
                $p1 = $allProducts->random();
                $p2 = $allProducts->random();

                $subtotal = $p1->price + $p2->price;
                $total = $subtotal + $ord['shipping_fee'];

                $order = Order::create(array_merge($ord, [
                    'user_id' => $customer->id,
                    'subtotal' => $subtotal,
                    'total' => $total,
                ]));

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p1->id,
                    'product_name' => $p1->name,
                    'product_code' => $p1->code,
                    'product_image' => $p1->image,
                    'price' => $p1->price,
                    'quantity' => 1,
                    'total' => $p1->price,
                ]);

                if ($p1->id !== $p2->id) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p2->id,
                        'product_name' => $p2->name,
                        'product_code' => $p2->code,
                        'product_image' => $p2->image,
                        'price' => $p2->price,
                        'quantity' => 1,
                        'total' => $p2->price,
                    ]);
                }
            }
        }
    }
}
