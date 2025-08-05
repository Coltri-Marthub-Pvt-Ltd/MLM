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
            $table->string('pan_card', 10)->unique()->nullable()->after('aadhar_card');
            $table->string('aadhar_photo')->nullable()->after('pan_card');
            $table->string('pan_photo')->nullable()->after('aadhar_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropColumn(['pan_card', 'aadhar_photo', 'pan_photo']);
        });
    }
};
