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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('mkt_person');
            $table->string('sales_person');
            $table->string('partner_id');
            $table->string('client');
            $table->string('area');
            $table->string('product');
            $table->integer('qty');
            $table->decimal('rate', 10, 2);
            $table->decimal('transport', 10, 2)->nullable();
            $table->string('supplier');
            $table->decimal('partner_commission', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
