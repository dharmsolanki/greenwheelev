<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Green Wheel EV') – Electric Scooters | Nadiad, Gujarat</title>
    <meta name="description" content="@yield('meta_desc', 'Green Wheel EV – Authorized EV sales, service, spare parts & dealership in Nadiad, Gujarat.')">
    <meta property="og:title" content="@yield('title', 'Green Wheel EV')">
    <meta property="og:description" content="@yield('meta_desc', 'Green Wheel EV – Your trusted EV partner in Gujarat')">
    <meta property="og:type" content="website">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>

    @include('components.navbar')
    @include('components.cart-sidebar')

    <main>
        @if (session('success'))
            <div class="alert-float alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-float alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.whatsapp-btn')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script>
        // Flash alerts auto-dismiss
        document.querySelectorAll('.alert-float').forEach(el => {
            setTimeout(() => el.style.opacity = '0', 4000);
            setTimeout(() => el.remove(), 4500);
        });
    </script>
</body>

</html>
