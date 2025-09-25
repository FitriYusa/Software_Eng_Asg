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
        Schema::create('Equipment', function (Blueprint $table) {
            $table->id('equipmentId');
            $table->string('name');
            $table->string('model');
            $table->string('serialNumber');
            $table->date('installationDate');
            $table->date('lastMaintanenceDate');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
