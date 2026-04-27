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
        Schema::table('aspirasis', function (Blueprint $table) {
            if (Schema::hasColumn('aspirasis', 'nama')) {
                $table->dropColumn(['nama', 'kritik', 'saran', 'masukan', 'rating']);
            }
            if (!Schema::hasColumn('aspirasis', 'judul')) {
                $table->string('judul')->nullable()->after('user_id');
            }
            // kategori is already added by previous migration
            if (!Schema::hasColumn('aspirasis', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('aspirasis', 'tujuan_manfaat')) {
                $table->text('tujuan_manfaat')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('aspirasis', 'lampiran')) {
                $table->string('lampiran')->nullable()->after('tujuan_manfaat');
            }
            if (!Schema::hasColumn('aspirasis', 'is_anonim')) {
                $table->boolean('is_anonim')->default(false)->after('lampiran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropColumn(['judul', 'deskripsi', 'tujuan_manfaat', 'lampiran', 'is_anonim']);
            $table->string('nama')->nullable();
            $table->text('kritik')->nullable();
            $table->text('saran')->nullable();
            $table->text('masukan')->nullable();
            $table->integer('rating')->default(5);
        });
    }
};
