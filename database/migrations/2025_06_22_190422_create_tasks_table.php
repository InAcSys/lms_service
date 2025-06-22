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
            $table->id('Id');
            $table->string('Title');
            $table->string('Description')->nullable();
            $table->timestamp('DueDate');
            $table->uuid('SubjectId');
            $table->uuid('TenantId');
            $table->boolean('IsActive')->default(true);
            $table->timestamp('Created')->useCurrent();
            $table->timestamp('Updated')->useCurrent()->nullable();
            $table->timestamp('Deleted')->nullable()->nullable();
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
