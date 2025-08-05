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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('completed')->default(false);
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('completed');
            $table->index('due_date');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
