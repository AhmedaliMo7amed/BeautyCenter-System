<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable();
            $table->string('nationality',25)->nullable();;
            $table->string('nat_id',20)->nullable();
            $table->string('phone',14)->nullable();
            $table->string('email')->nullable();
            $table->enum('user_type', ['user', 'provider'])->default('user')->nullable();
            $table->string('latitude',9)->nullable();
            $table->string('longitude',9)->nullable();
            $table->date("birthdate")->nullable();
            $table->string('image')->nullable()->default('assets/defult-user-avatar.jpg');
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
