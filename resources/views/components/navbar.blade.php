<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon"><i class="fas fa-bolt" style="color:#ffc107"></i></div>
            <div class="logo-text">
                <span class="logo-name">Green Wheel EV</span>
                <span class="logo-sub">SMOOTH RIDES, SMART CHOICES</span>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('scooters.index') }}"
                    class="{{ request()->routeIs('scooters.*') ? 'active' : '' }}">EV Scooters</a></li>
            <li><a href="{{ route('parts.index') }}" class="{{ request()->routeIs('parts.*') ? 'active' : '' }}">Spare
                    Parts</a></li>
            <li><a href="{{ route('service.index') }}"
                    class="{{ request()->routeIs('service.*') ? 'active' : '' }}">Service</a></li>
            <li><a href="{{ route('dealership.index') }}"
                    class="{{ request()->routeIs('dealership.*') ? 'active' : '' }}">Dealership</a></li>
            <li><a href="{{ route('blog.index') }}"
                    class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ route('gallery.index') }}"
                    class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">Gallery</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            </li>
            <li>
                <a href="{{ route('cart.index') }}" class="nav-cart-link">
                    <i class="fas fa-shopping-cart"></i> <span class="cart-badge"
                        id="navCartCount">{{ count(session()->get('cart', [])) }}</span>
                </a>
            </li>
            <li><a href="{{ route('contact.index') }}"
                    class="nav-cta {{ request()->routeIs('contact.*') ? 'active' : '' }}">Contact Us</a></li>
        </ul>
        <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('scooters.index') }}"><i class="fas fa-motorcycle"></i> EV Scooters</a>
        <a href="{{ route('parts.index') }}"><i class="fas fa-cogs"></i> Spare Parts</a>
        <a href="{{ route('service.index') }}"><i class="fas fa-tools"></i> Service</a>
        <a href="{{ route('dealership.index') }}"><i class="fas fa-handshake"></i> Dealership</a>
        <a href="{{ route('blog.index') }}"><i class="fas fa-blog"></i> Blog</a>
        <a href="{{ route('gallery.index') }}"><i class="fas fa-camera"></i> Gallery</a>
        <a href="{{ route('about') }}"><i class="fas fa-info-circle"></i> About</a>
        <a href="{{ route('contact.index') }}"><i class="fas fa-map-marker-alt"></i> Contact</a>
        <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i> Cart
            ({{ count(session()->get('cart', [])) }})</a>
    </div>
</nav>
