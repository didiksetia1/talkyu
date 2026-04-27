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
        Schema::table('aduans', function (Blueprint $table) {
            $table->timestamp('ditinjau_at')->nullable()->after('status');
            $table->timestamp('diproses_at')->nullable()->after('ditinjau_at');
            $table->timestamp('selesai_at')->nullable()->after('diproses_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->dropColumn(['ditinjau_at', 'diproses_at', 'selesai_at']);
        });
    }
};
