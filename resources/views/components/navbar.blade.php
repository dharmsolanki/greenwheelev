<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="logo" style="display:flex;align-items:center;gap:4px;text-decoration:none">
            <img src="{{ asset('images/logo.png') }}" alt="Green Wheel EV"
                style="height:50px;width:50px;object-fit:contain;filter:invert(48%) sepia(79%) saturate(476%) hue-rotate(86deg) brightness(95%) contrast(95%);flex-shrink:0">
            <div style="display:flex;flex-direction:column;justify-content:center;gap:1px">
                <span style="font-size:16px;font-weight:700;color:#fff;line-height:1;white-space:nowrap">Green Wheel
                    EV</span>
                <span
                    style="font-size:9px;font-weight:500;color:#4aab6d;letter-spacing:.8px;line-height:1;white-space:nowrap">SMOOTH
                    RIDES, SMART CHOICES</span>
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
                    🛒 <span class="cart-badge" id="navCartCount">{{ count(session()->get('cart', [])) }}</span>
                </a>
            </li>
            <li><a href="{{ route('contact.index') }}"
                    class="nav-cta {{ request()->routeIs('contact.*') ? 'active' : '' }}">Contact Us</a></li>
        </ul>
        <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}">🏠 Home</a>
        <a href="{{ route('scooters.index') }}">🛵 EV Scooters</a>
        <a href="{{ route('parts.index') }}">⚙️ Spare Parts</a>
        <a href="{{ route('service.index') }}">🔧 Service</a>
        <a href="{{ route('dealership.index') }}">🤝 Dealership</a>
        <a href="{{ route('blog.index') }}">📝 Blog</a>
        <a href="{{ route('gallery.index') }}">📸 Gallery</a>
        <a href="{{ route('about') }}">ℹ️ About</a>
        <a href="{{ route('contact.index') }}">📍 Contact</a>
        <a href="{{ route('cart.index') }}">🛒 Cart ({{ count(session()->get('cart', [])) }})</a>
    </div>
</nav>
