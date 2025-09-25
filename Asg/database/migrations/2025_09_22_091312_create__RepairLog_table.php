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
        Schema::create('repair_logs', function (Blueprint $table) {
            $table->id('logId'); // Primary Key
            $table->dateTime('startTime'); // Repair start time
            $table->dateTime('endTime'); // Repair completion time
            $table->text('technicianNotes'); // Notes entered by technician
            $table->string('partsUsed'); // Parts replaced during repair
            $table->decimal('cost', 10, 2); // Cost of repair (decimal with 2 decimals)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_repair_log');
    }
};
