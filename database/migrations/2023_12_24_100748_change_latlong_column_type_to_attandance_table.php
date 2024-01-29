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
        Schema::table('attendance', function (Blueprint $table) {
            $table->decimal('in_time_latitude', 25, 20)->change();
            $table->decimal('in_time_longitude', 25, 20)->change();
            $table->decimal('out_time_latitude', 25, 20)->change();
            $table->decimal('out_time_longitude', 25, 20)->change();
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
