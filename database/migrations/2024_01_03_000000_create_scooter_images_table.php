<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('scooter_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('scooter_id')->constrained()->cascadeOnDelete();
            $t->string('image_path');
            $t->string('alt_text')->nullable();
            $t->boolean('is_primary')->default(false);
            $t->integer('sort_order')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('scooter_images');
    }
};
