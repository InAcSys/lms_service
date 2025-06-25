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
            $table->id();
            $table->uuid('tenantId');
            $table->uuid('studentId');
            $table->uuid('subjectId');
            $table->integer('taskId');
            $table->decimal('grade', 5, 2);
            $table->string('comment')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('updated')->nullable();
            $table->timestamp('deleted')->nullable();
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
