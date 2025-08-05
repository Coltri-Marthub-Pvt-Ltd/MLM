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
        Schema::table('contractors', function (Blueprint $table) {
            $table->boolean('status')->default(0)->after('pan_photo'); // 0 = inactive, 1 = active
            $table->timestamp('verified_at')->nullable()->after('status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['status', 'verified_at', 'verified_by']);
        });
    }
}; 