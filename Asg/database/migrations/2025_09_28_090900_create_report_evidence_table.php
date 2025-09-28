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
            $table->id();
            $table->unsignedBigInteger('report_id'); // links to report_faults
            $table->string('file_path');
            $table->string('file_type');
            $table->text('description')->nullable(); // optional description
            $table->timestamps();

            $table->foreign('report_id')
                ->references('id')
                ->on('report_faults')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_evidence');
    }
};
