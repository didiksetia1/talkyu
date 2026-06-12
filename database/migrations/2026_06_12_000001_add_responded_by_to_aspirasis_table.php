<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->unsignedBigInteger('responded_by')->nullable()->after('bem_response');
            $table->foreign('responded_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['responded_by']);
            $table->dropColumn('responded_by');
        });
    }
};
