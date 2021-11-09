<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->time('start_time', $precision = 0);
            $table->date('end_date')->nullable();
            $table->time('end_time', $precision = 0);
            $table->text('description')->nullable();
            $table->tinyInteger('has_end');
            $table->tinyInteger('is_recurring');
            $table->tinyInteger('monday')->nullable();
            $table->tinyInteger('tuesday')->nullable();
            $table->tinyInteger('wednesday')->nullable();
            $table->tinyInteger('thursday')->nullable();
            $table->tinyInteger('friday')->nullable();
            $table->tinyInteger('saturday')->nullable();
            $table->tinyInteger('sunday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
