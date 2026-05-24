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
            $table->dropForeign(['aspirasi_event_id']);
            $table->unsignedBigInteger('aspirasi_event_id')->nullable()->change();
            $table->foreign('aspirasi_event_id')->references('id')->on('aspirasi_events')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['aspirasi_event_id']);
            $table->unsignedBigInteger('aspirasi_event_id')->nullable(false)->change();
            $table->foreign('aspirasi_event_id')->references('id')->on('aspirasi_events')->cascadeOnDelete();
        });
    }
};
