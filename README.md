# 🌿 Green Wheel EV – Laravel Website

**Complete Laravel website for Green Wheel EV, Nadiad, Gujarat**

---

## 🚀 Quick Setup (5 Steps)

### Step 1 – Install Laravel & Dependencies
```bash
composer create-project laravel/laravel greenwheel-ev
cd greenwheel-ev
```

Then copy all files from this package into your Laravel project folder.

### Step 2 – Configure .env
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```
DB_DATABASE=greenwheel_ev
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
RAZORPAY_KEY_ID=rzp_live_xxx
RAZORPAY_KEY_SECRET=xxx
```

### Step 3 – Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 4 – Storage Link (for file uploads)
```bash
php artisan storage:link
```

### Step 5 – Run
```bash
php artisan serve
```
Open: http://localhost:8000

---

## 🔑 Admin Login
- URL: `/admin/login`
- Email: `admin@greenwheelev.com`
- Password: `Admin@123`

---

## 📋 Features Included

### Frontend
- Home Page (Hero, EMI Calculator, Test Ride, Reviews, Blog)
- EV Scooters (List, Detail, Compare)
- Spare Parts Shop (Cart, COD + Razorpay Checkout)
- Service Booking Form
- Dealership Application
- Gallery (with lightbox)
- Blog (with categories + pagination)
- Contact Page (Maps + Form)
- About Page
- Order Tracking

### Admin Panel
- Dashboard (stats, revenue, recent orders)
- Order Management (status updates, view details)
- Spare Parts Inventory (add/edit/delete, live stock update)
- Scooter Management (CRUD)
- Service Booking Management
- Test Ride Management
- Dealer Application Management
- Blog CMS (create/edit/publish)
- Gallery Upload (by category)
- Reviews Moderation (approve/reject)
- Contact Messages
- Settings (Razorpay keys, phone, address, shipping)

### Payments
- Cash on Delivery (COD)
- Razorpay (UPI, Credit/Debit Card, Net Banking)

---

## 🏪 Showroom Details
- **Name:** Green Wheel EV
- **Address:** Near Riya Party Plot, Piplag Road, Nadiad, Gujarat
- **Phone:** +91 79843 04504
- **Email:** greenwheelev03@gmail.com
- **Hours:** Mon–Sat 9:00 AM – 7:00 PM

---

## 🗂 Project Structure
```
├── app/
│   ├── Http/Controllers/          # Frontend Controllers
│   │   └── Admin/                 # Admin Controllers
│   ├── Http/Middleware/           # AdminAuth Middleware
│   └── Models/                   # All Models
├── database/
│   ├── migrations/                # All Table Migrations
│   └── seeders/                  # Sample Data Seeder
├── resources/views/
│   ├── layouts/                   # app.blade.php, admin.blade.php
│   ├── components/                # navbar, footer, cart-sidebar, whatsapp
│   ├── pages/                     # All frontend pages
│   └── admin/                     # All admin pages
├── public/
│   ├── css/app.css               # Frontend styles
│   └── js/app.js                 # Frontend scripts
└── routes/web.php                 # All Routes
```

---

## 🔧 Razorpay Setup
1. Create account at [razorpay.com](https://razorpay.com)
2. Get API Key ID and Secret from Dashboard
3. Add to `.env` file OR update via Admin → Settings

---

## 📞 Support
WhatsApp: +91 79843 04504
