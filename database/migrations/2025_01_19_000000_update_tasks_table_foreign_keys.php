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
        // Schema::table('tasks', function (Blueprint $table) {
        //     // Check if foreign key exists before dropping
        //     $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('tasks');
        //     $foreignKeyExists = false;
            
        //     foreach ($foreignKeys as $foreignKey) {
        //         if (in_array('assigned_to', $foreignKey->getLocalColumns())) {
        //             $foreignKeyExists = true;
        //             break;
        //         }
        //     }
            
        //     if ($foreignKeyExists) {
        //         $table->dropForeign(['assigned_to']);
        //     }
            
        //     // Add new foreign key constraint to users table
        //     $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('tasks', function (Blueprint $table) {
        //     // Drop the users foreign key constraint
        //     $table->dropForeign(['assigned_to']);
            
        //     // Restore the employees foreign key constraint
        //     $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('set null');
        // });
    }
}; 