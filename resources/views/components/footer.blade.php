<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">
                <div style="margin-bottom:14px">
                    <img src="{{ asset('images/logo.png') }}" alt="Green Wheel EV"
                        style="height:52px;width:auto;object-fit:contain">
                </div>
                <p>Your trusted destination for electric two-wheelers, service, spare parts & dealership opportunities
                    in Gujarat.</p>
                <p style="margin-top:12px;font-size:13px">📍 Near Riya Party Plot, Piplag Road, Nadiad, Gujarat</p>
                <div class="social-links" style="margin-top:14px">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/917984304504" class="social-link"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('scooters.index') }}">EV Scooters</a></li>
                    <li><a href="{{ route('parts.index') }}">Spare Parts</a></li>
                    <li><a href="{{ route('service.index') }}">Service</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('scooters.index') }}">EV Sales</a></li>
                    <li><a href="{{ route('service.index') }}">Battery Repair</a></li>
                    <li><a href="{{ route('service.index') }}">Motor Service</a></li>
                    <li><a href="{{ route('parts.index') }}">Spare Parts Shop</a></li>
                    <li><a href="{{ route('dealership.index') }}">Dealership</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="tel:+917984304504">+91 79843 04504</a></li>
                    <li><a href="mailto:greenwheelev03@gmail.com">greenwheelev03@gmail.com</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog & News</a></li>
                    <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                    <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} Green Wheel EV. All rights reserved.</p>
            <p>Made with ⚡ for a greener India</p>
        </div>
    </div>
</footer>
