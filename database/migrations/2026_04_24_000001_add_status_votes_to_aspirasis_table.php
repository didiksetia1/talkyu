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
            $table->enum('status', ['submitted', 'being_considered', 'realized'])->default('submitted')->after('rating');
            $table->text('bem_response')->nullable()->after('status');
            $table->unsignedInteger('votes_count')->default(0)->after('bem_response');
            $table->unsignedInteger('comments_count')->default(0)->after('votes_count');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropColumn(['status', 'bem_response', 'votes_count', 'comments_count']);
        });
    }
};
