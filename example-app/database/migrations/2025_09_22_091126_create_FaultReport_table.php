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
        Schema::create('report_evidence', function (Blueprint $table) {
            $table->id('evidenceId'); // Primary Key (Integer Auto Increment)
            $table->string('filePath'); // Location of uploaded file
            $table->string('fileType'); // Type of file (image, video, document)
            $table->dateTime('uploadDate'); // Date and time file was uploaded
            $table->string('description')->nullable(); // Description of the evidence (nullable)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fault_report');
    }
};
