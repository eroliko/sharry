<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 128);
            $table->string('content', 2048);
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
            $table->string('gps_lat', 64);
            $table->string('gps_lng', 64);
            $table->timestamps();
        });

        Schema::create('users_events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->primary(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users_events');
        Schema::dropIfExists('events');
    }
};
