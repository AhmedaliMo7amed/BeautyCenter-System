<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('offers', function($table) {
            $table->enum('status', ['accepted', 'expired'])->nullable();
        });
    }

    public function down()
    {
        Schema::table('offers', function($table) {
            $table->dropColumn('status');
        });
    }
};
