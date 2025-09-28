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
        Schema::create('report_faults', function (Blueprint $table) {
        $table->id();
        $table->foreignId('users_id')->constrained()->onDelete('cascade'); // reporter
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
        $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
        $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // technician
        $table->text('description')->nullable();
        $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
        $table->timestamps();
    });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_faults');
    }
};
