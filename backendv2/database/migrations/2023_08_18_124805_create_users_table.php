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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('username');
            $table->string('surname');
            $table->string('email');
            $table->string('password');
            $table->boolean('status');
            $table->string('dni');
            $table->string('profile');
            $table->string('cellphone');
            $table->string('shift');
            $table->date('birthday');
            $table->string('image');
            $table->date('date_start');
            $table->date('date_end');

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
