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
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('in_time');
            $table->bigInteger('out_time')->nullable();
            $table->string('in_time_location')->nullable();
            $table->decimal('in_time_latitude')->nullable();
            $table->decimal('in_time_longitude')->nullable();
            $table->string('out_time_location')->nullable();
            $table->decimal('out_time_latitude')->nullable();
            $table->decimal('out_time_longitude')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
