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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer("offer_price")->unsigned();
            $table->enum('payment', ['online', 'cash'])->default('cash');
            $table->boolean('wallet_balance')->default(0);
            $table->string('location','50');
            $table->string('latitude',9)->nullable();
            $table->string('longitude',9)->nullable();
            $table->boolean('used_coupon')->default(0);
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->double('before_discount');
            $table->double('total');
            $table->dateTime('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
