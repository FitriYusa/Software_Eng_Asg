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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notificationId'); // Primary Key
            $table->string('title'); // Short title of notification
            $table->text('message'); // Full notification message
            $table->dateTime('sentDate'); // Date and time notification was sent
            $table->boolean('isRead')->default(false); // Status of notification (default: unread)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_notification');
    }
};
