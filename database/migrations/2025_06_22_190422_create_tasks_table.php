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
            $table->string('description')->nullable();
            $table->timestamp('dueDate');
            $table->uuid('subjectId');
            $table->uuid('tenantId');
            $table->boolean('isActive')->default(true);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('updated')->useCurrent()->nullable();
            $table->timestamp('deleted')->nullable()->nullable();
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
