<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>QuickTech Cambodia | Upgrade Your World - Computer, Laptop & Gaming Store</title>
    <meta name="description" content="Your trusted destination for laptops, gaming PCs, computer components and accessories in Cambodia. Genuine brand warranty and fast delivery across Cambodia.">
    
    <!-- Google Fonts: Inter & Kantumruy Pro (Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/quicktech-icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-[#F8FAFC] text-[#111827] antialiased selection:bg-blue-600 selection:text-white">
    <div id="app"></div>
</body>
</html>
