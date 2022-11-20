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
        Schema::create('providers_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->longText('description');
            $table->integer("min_cost");
            $table->integer("delivery_cost");
            $table->boolean('booking_status')->default(1);
            $table->boolean('direct_serv_status')->default(1);
            $table->integer('experience');
            $table->integer("avg_rate")->nullable();
            $table->string('address_info',100);
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
        Schema::dropIfExists('expert_infos');
    }
};
