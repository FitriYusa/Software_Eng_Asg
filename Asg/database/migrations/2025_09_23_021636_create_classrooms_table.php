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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
$table->string('building');
$table->string('floor');
$table->string('roomNumber');
$table->unique(['building', 'floor', 'roomNumber']);
            $table->integer('capacity');
            $table->longText('description')->nullable();
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
