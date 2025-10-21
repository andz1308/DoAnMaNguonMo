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
        Schema::create('chi_tiet_khuyen_mai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khuyen_mai_id')->nullable()->constrained('khuyen_mai')->onDelete('cascade');
            $table->foreignId('san_pham_id')->nullable()->constrained('san_pham')->onDelete('cascade');
            $table->date('ngay_bd')->nullable();
            $table->date('ngay_kt')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_khuyen_mai');
    }
};
