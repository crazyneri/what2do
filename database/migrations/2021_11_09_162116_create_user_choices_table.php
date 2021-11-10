<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('session_id');
            $table->float('max_budget', 8, 2)->nullable();
            $table->unsignedBigInteger('category1_id')->nullable();
            $table->unsignedBigInteger('category2_id')->nullable();
            $table->unsignedBigInteger('category3_id')->nullable();
            $table->unsignedBigInteger('category4_id')->nullable();
            $table->unsignedBigInteger('category5_id')->nullable();
            $table->unsignedBigInteger('category6_id')->nullable();
            $table->unsignedBigInteger('category7_id')->nullable();
            $table->unsignedBigInteger('category8_id')->nullable();
            $table->unsignedBigInteger('category9_id')->nullable();
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
        Schema::dropIfExists('user_choices');
    }
}
