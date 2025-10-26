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
        // Bảng roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->timestamps();
        });

        // Bảng users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('dien_thoai', 20);
            $table->string('dia_chi');
            $table->string('password');
            $table->string('gioi_tinh', 10);
            $table->timestamps();
        });

        // Bảng loai_san_pham
        Schema::create('loai_san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        // Bảng san_pham
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('gia');
            $table->text('gioi_thieu')->nullable();
            $table->text('mo_ta')->nullable();
            $table->string('thuong_hieu', 100);
            $table->string('man_hinh', 100)->nullable();
            $table->string('do_phan_giai', 100)->nullable();
            $table->string('camera', 100)->nullable();
            $table->string('cpu', 100)->nullable();
            $table->string('pin', 100)->nullable();
            $table->datetime('ngay_phat_hanh')->nullable();
            $table->string('dung_luong', 100)->nullable();
            $table->string('kich_thuoc', 100)->nullable();
            $table->string('trong_luong', 100)->nullable();
            $table->integer('so_luong_con');
            $table->foreignId('loai_san_pham_id')->constrained('loai_san_pham');
            $table->timestamps();
        });

        // Bảng images
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('san_pham_id')->constrained('san_pham');
            $table->timestamps();
        });

        // Bảng don_hang
        Schema::create('don_hang', function (Blueprint $table) {
            $table->id();
            $table->text('ghi_chu')->nullable();
            $table->integer('trang_thai');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        // Bảng chi_tiet_don_hang
        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->id();
            $table->integer('so_luong');
            $table->foreignId('san_pham_id')->constrained('san_pham');
            $table->foreignId('don_hang_id')->constrained('don_hang');
            $table->timestamps();
        });

        // Bảng khuyen_mai
        Schema::create('khuyen_mai', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('gia');
            $table->timestamps();
        });

        // Bảng chi_tiet_khuyen_mai
        Schema::create('chi_tiet_khuyen_mai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khuyen_mai_id')->constrained('khuyen_mai');
            $table->foreignId('san_pham_id')->constrained('san_pham');
            $table->date('ngay_bd');
            $table->date('ngay_kt');
            $table->timestamps();
        });

        // Bảng danh_gia
        Schema::create('danh_gia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('san_pham_id')->constrained('san_pham');
            $table->text('noi_dung')->nullable();
            $table->integer('vote');
            $table->timestamps();
        });

        // Bảng feedback
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung')->nullable();
            $table->datetime('ngay_phan_hoi');
            $table->timestamps();
        });

        // Bảng thanh_toan
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->foreignId('don_hang_id')->primary()->constrained('don_hang');
            $table->datetime('ngay_thanh_toan');
            $table->float('tong_tien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('danh_gia');
        Schema::dropIfExists('chi_tiet_khuyen_mai');
        Schema::dropIfExists('khuyen_mai');
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
        Schema::dropIfExists('images');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('loai_san_pham');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
