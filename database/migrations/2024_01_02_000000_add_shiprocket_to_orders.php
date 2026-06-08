<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->string('shiprocket_order_id')->nullable()->after('razorpay_order_id');
            $t->string('shiprocket_shipment_id')->nullable()->after('shiprocket_order_id');
            $t->string('tracking_number')->nullable()->after('shiprocket_shipment_id');
            $t->string('courier_name')->nullable()->after('tracking_number');
            $t->string('tracking_url')->nullable()->after('courier_name');
        });
    }
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->dropColumn(['shiprocket_order_id','shiprocket_shipment_id','tracking_number','courier_name','tracking_url']);
        });
    }
};
