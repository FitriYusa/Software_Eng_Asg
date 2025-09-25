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
        Schema::create('Classroom', function (Blueprint $table) {
            $table->id('classroomId');
            $table->string('building')->unique();
            $table->text('floow');
            $table->text('roomNumber');
            $table->longText('capacity');
            $table->longText('description');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
