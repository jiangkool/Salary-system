<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hospital_code');
            $table->decimal('money',10,2)->comment('金额');
            $table->timestamps();
        });
        
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->decimal('yz_total',10,2)->comment('已做金额');
            $table->decimal('yj_total',10,2)->comment('已结金额');
            $table->decimal('wj_total',10,2)->comment('未结金额');
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
        Schema::dropIfExists('cashouts');
        Schema::dropIfExists('companies');
    }
}
