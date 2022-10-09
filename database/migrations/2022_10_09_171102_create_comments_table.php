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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('nick_name', 128);
            $table->string('content', 2048);
            $table->timestamps();
        });

        Schema::create('news_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('new_id');
            $table->unsignedBigInteger('comment_id');
            $table->foreign('comment_id')->references('id')->on('comments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('new_id')->references('id')->on('news')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->primary(['new_id', 'comment_id']);
        });

        Schema::create('events_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('comment_id');
            $table->foreign('comment_id')->references('id')->on('comments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('event_id')->references('id')->on('events')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->primary(['event_id', 'comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('events_comments');
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('comments');
    }
};
