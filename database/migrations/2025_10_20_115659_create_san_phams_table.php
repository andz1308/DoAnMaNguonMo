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
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->double('gia')->nullable();
            $table->longText('gioi_thieu')->nullable();
            $table->longText('mo_ta')->nullable();
            $table->string('thuong_hieu', 100)->nullable();
            $table->string('man_hinh', 100)->nullable();
            $table->string('do_phan_giai', 100)->nullable();
            $table->string('camera', 100)->nullable();
            $table->string('cpu', 100)->nullable();
            $table->string('pin', 100)->nullable();
            $table->dateTime('ngay_phat_hanh')->nullable();
            $table->string('dung_luong', 100)->nullable();
            $table->string('kich_thuoc', 100)->nullable();
            $table->string('trong_luong', 100)->nullable();
            $table->integer('so_luong_con')->nullable();
            $table->foreignId('loai_san_pham_id')->nullable()->constrained('loai_san_pham')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
