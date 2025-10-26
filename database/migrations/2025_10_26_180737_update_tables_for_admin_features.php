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
        // Update users table - add trang_thai if not exists
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'trang_thai')) {
                $table->tinyInteger('trang_thai')->default(1)->after('password');
            }
        });

        // Update danh_gia table - add so_sao and timestamps
        Schema::table('danh_gia', function (Blueprint $table) {
            if (!Schema::hasColumn('danh_gia', 'so_sao')) {
                $table->integer('so_sao')->default(5)->after('noi_dung');
            }
            if (!Schema::hasColumn('danh_gia', 'created_at')) {
                $table->timestamps();
            }
        });

        // Update feedback table - add user_id, chu_de, email, loai, trang_thai, and timestamps
        Schema::table('feedback', function (Blueprint $table) {
            if (!Schema::hasColumn('feedback', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('feedback', 'chu_de')) {
                $table->string('chu_de', 255)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('feedback', 'email')) {
                $table->string('email', 255)->nullable()->after('noi_dung');
            }
            if (!Schema::hasColumn('feedback', 'loai')) {
                $table->string('loai', 50)->default('other')->after('email'); // complain, suggestion, question, other
            }
            if (!Schema::hasColumn('feedback', 'trang_thai')) {
                $table->tinyInteger('trang_thai')->default(0)->after('loai'); // 0: pending, 1: processed
            }
            if (!Schema::hasColumn('feedback', 'created_at')) {
                $table->timestamps();
            }
            
            // Drop old columns if they exist
            if (Schema::hasColumn('feedback', 'tieu_de')) {
                $table->dropColumn('tieu_de');
            }
            if (Schema::hasColumn('feedback', 'ngay_phan_hoi')) {
                $table->dropColumn('ngay_phan_hoi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'trang_thai')) {
                $table->dropColumn('trang_thai');
            }
        });

        Schema::table('danh_gia', function (Blueprint $table) {
            if (Schema::hasColumn('danh_gia', 'so_sao')) {
                $table->dropColumn('so_sao');
            }
            if (Schema::hasColumn('danh_gia', 'created_at')) {
                $table->dropTimestamps();
            }
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'chu_de', 'email', 'loai', 'trang_thai', 'created_at', 'updated_at']);
            $table->string('tieu_de', 255)->nullable();
            $table->dateTime('ngay_phan_hoi')->nullable();
        });
    }
};
