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
            $table->unsignedBigInteger('referenced_by')->nullable()->after('verified_by');
            $table->foreign('referenced_by')->references('id')->on('contractors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropForeign(['referenced_by']);
            $table->dropColumn('referenced_by');
        });
    }
};
