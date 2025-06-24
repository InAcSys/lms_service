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
        Schema::create('grades', function (Blueprint $table) {
            $table->id('Id');
            $table->uuid('TenantId');
            $table->uuid('StudentId');
            $table->uuid('SubjectId');
            $table->integer('TaskId');
            $table->decimal('Grade', 5, 2);
            $table->string('Comment')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->timestamp('Created')->useCurrent();
            $table->timestamp('Updated')->nullable();
            $table->timestamp('Deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
