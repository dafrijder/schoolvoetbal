<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team1_id')->nullable();
            $table->unsignedBigInteger('team2_id')->nullable();
            $table->integer('team1_score')->default(0);
            $table->integer('team2_score')->default(0);
            $table->string('field')->nullable();
            $table->unsignedBigInteger('referee_id')->nullable();
            $table->date('time')->nullable();
            $table->timestamps();

            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('referee_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
