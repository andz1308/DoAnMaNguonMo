<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->foreignId('don_hang_id')->constrained('don_hang')->onDelete('cascade');
            $table->dateTime('ngay_thanh_toan')->nullable();
            $table->double('tong_tien')->nullable();
            $table->primary('don_hang_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
    }
};
