<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add 'role' column to existing users table
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $t) {
                $t->enum('role', ['admin', 'staff'])->default('staff')->after('password');
            });
        }

        Schema::create('scooters', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique();
            $t->enum('category',['city','premium','longrange','highspeed','delivery']);
            $t->string('icon')->default('🛵'); $t->string('range'); $t->string('top_speed');
            $t->string('charging_time'); $t->string('motor_power'); $t->decimal('price',10,2);
            $t->text('description')->nullable(); $t->json('features')->nullable();
            $t->string('image')->nullable(); $t->boolean('is_active')->default(true);
            $t->boolean('is_featured')->default(false); $t->string('tag')->nullable(); $t->timestamps();
        });

        Schema::create('spare_parts', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique();
            $t->enum('category',['battery','electrical','mechanical','accessories']);
            $t->string('icon')->default('⚙️'); $t->decimal('price',10,2); $t->decimal('mrp',10,2);
            $t->integer('stock')->default(0); $t->text('description')->nullable();
            $t->string('tag')->nullable(); $t->string('image')->nullable();
            $t->boolean('is_active')->default(true); $t->timestamps();
        });

        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->string('order_no')->unique(); $t->string('name'); $t->string('phone');
            $t->string('email')->nullable(); $t->text('address'); $t->string('city');
            $t->string('state'); $t->string('pincode');
            $t->enum('payment_method',['cod','razorpay']);
            $t->string('payment_id')->nullable(); $t->string('razorpay_order_id')->nullable();
            $t->enum('status',['pending','confirmed','processing','shipped','delivered','cancelled'])->default('pending');
            $t->decimal('subtotal',10,2); $t->decimal('shipping',10,2)->default(0);
            $t->decimal('total',10,2); $t->text('notes')->nullable(); $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id(); $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->unsignedBigInteger('spare_part_id')->nullable();
            $t->string('part_name'); $t->decimal('price',10,2);
            $t->integer('qty'); $t->decimal('subtotal',10,2); $t->timestamps();
        });

        Schema::create('service_bookings', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('phone'); $t->string('vehicle_brand');
            $t->string('service_type'); $t->date('preferred_date'); $t->string('preferred_time');
            $t->text('description')->nullable();
            $t->enum('status',['pending','confirmed','in_progress','completed','cancelled'])->default('pending');
            $t->text('admin_notes')->nullable(); $t->timestamps();
        });

        Schema::create('test_ride_bookings', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('phone'); $t->date('preferred_date');
            $t->string('vehicle_interest');
            $t->enum('status',['pending','confirmed','completed','cancelled'])->default('pending');
            $t->timestamps();
        });

        Schema::create('dealer_applications', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('phone'); $t->string('email');
            $t->string('city'); $t->string('state'); $t->string('investment_capacity');
            $t->text('showroom_space')->nullable();
            $t->enum('status',['pending','reviewing','approved','rejected'])->default('pending');
            $t->text('admin_notes')->nullable(); $t->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('phone'); $t->string('email')->nullable();
            $t->string('subject'); $t->text('message'); $t->boolean('is_read')->default(false);
            $t->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique();
            $t->text('excerpt'); $t->longText('content'); $t->string('image')->nullable();
            $t->string('category')->default('General'); $t->string('author')->default('Green Wheel EV');
            $t->boolean('is_published')->default(false); $t->timestamp('published_at')->nullable();
            $t->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $t) {
            $t->id(); $t->string('title');
            $t->enum('category',['showroom','vehicles','service','delivery','events']);
            $t->string('image_path'); $t->text('description')->nullable();
            $t->integer('sort_order')->default(0); $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('reviews', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('location')->nullable();
            $t->integer('rating')->default(5); $t->text('review');
            $t->boolean('is_approved')->default(false); $t->timestamps();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->id(); $t->string('key')->unique(); $t->text('value')->nullable(); $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach(['settings','reviews','gallery_images','blog_posts','contact_messages',
            'dealer_applications','test_ride_bookings','service_bookings','order_items',
            'orders','spare_parts','scooters'] as $tbl) {
            Schema::dropIfExists($tbl);
        }
        // Remove role column if exists
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', fn($t) => $t->dropColumn('role'));
        }
    }
};
