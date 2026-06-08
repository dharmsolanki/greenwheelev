<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Dashboard') – Green Wheel EV Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@stack('styles')
</head>
<body class="admin-body">
<div class="admin-wrap">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">⚡</div>
            <div><div class="brand-name">Green Wheel EV</div><div class="brand-sub">Admin Panel</div></div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <div class="nav-group">Orders</div>
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Orders</a>
            <div class="nav-group">Inventory</div>
            <a href="{{ route('admin.inventory.index') }}" class="nav-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}"><i class="fas fa-boxes"></i> Spare Parts</a>
            <a href="{{ route('admin.scooters.index') }}" class="nav-item {{ request()->routeIs('admin.scooters.*') ? 'active' : '' }}"><i class="fas fa-motorcycle"></i> Scooters</a>
            <div class="nav-group">Bookings</div>
            <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> Service Bookings</a>
            <a href="{{ route('admin.test-rides.index') }}" class="nav-item {{ request()->routeIs('admin.test-rides.*') ? 'active' : '' }}"><i class="fas fa-road"></i> Test Rides</a>
            <a href="{{ route('admin.dealers.index') }}" class="nav-item {{ request()->routeIs('admin.dealers.*') ? 'active' : '' }}"><i class="fas fa-handshake"></i> Dealer Apps</a>
            <div class="nav-group">Content</div>
            <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}"><i class="fas fa-blog"></i> Blog</a>
            <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"><i class="fas fa-images"></i> Gallery</a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"><i class="fas fa-star"></i> Reviews</a>
            <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="fas fa-envelope"></i> Messages</a>
            <div class="nav-group">System</div>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="fas fa-cog"></i> Settings</a>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:8px">
                @csrf<button type="submit" class="nav-item logout-btn" style="width:100%;text-align:left;border:none;background:none;cursor:pointer"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </aside>
    <!-- Main content -->
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="fas fa-bars"></i></button>
            <div class="header-title">@yield('title','Dashboard')</div>
            <div class="header-right">
                <span class="admin-badge">{{ session('admin_role','Admin') }}</span>
                <span style="font-size:13px;color:#666">{{ session('admin_name') }}</span>
            </div>
        </header>
        <div class="admin-content">
            @if(session('success'))<div class="a-alert a-success">✅ {{ session('success') }}</div>@endif
            @if(session('error'))<div class="a-alert a-error">❌ {{ session('error') }}</div>@endif
            @if($errors->any())<div class="a-alert a-error">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>@endif
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
