<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       //客户 customers
       Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->integer('sex')->comment('性别 0 女 1 男');
            $table->integer('area_id')->comment('所在区');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            $table->string('age')->comment('年龄')->nullable();
            $table->string('hospital_code')->comment('住院号');
            $table->integer('status')->default(0)->comment('状态 0 在院 1 出院');
            $table->unique('hospital_code');//添加索引 
            $table->timestamps();
        });

       //商品 products
       Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->comment('类型');
            $table->foreign('type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->string('product_name')->comment('名称');
            $table->decimal('price',10,2)->comment('价格');
            $table->integer('num')->nullable()->default(0)->comment('库存');
            $table->timestamps();
        });

       //商品类型 product_types
       Schema::create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('名称');
            $table->timestamps();
        });

       //工种 works
       Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('工种名称');
            $table->string('work_unit')->comment('数量单位');
            $table->decimal('price', 10, 2)->default(0.00)->comment('每单位工薪');
            $table->timestamps();
        });

       //所在区 areas
       Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('area')->comment('所在区名称');
            $table->timestamps();
        });

       //余额  balances
       Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hospital_code')->comment('住院号');
            $table->decimal('balance', 10, 2)->default(0.00)->comment('余额');
            $table->timestamps();
        });

        //消费订单 orders
       Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->comment('订单号');
            $table->string('hospital_code')->comment('住院号');
            $table->string('name')->comment('姓名');
            $table->json('order_details')->comment('订单详细');
            $table->decimal('total', 10, 2)->default(0.00)->comment('订单金额');
            $table->integer('area_id')->comment('区号');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            $table->integer('status')->default(0)->comment('是否出单 0 未出  1 已出');
            $table->unique('hospital_code');//添加索引
            $table->unique('order_code');//添加索引  
            $table->timestamps();
        });

       //工作收入 incomes
       Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->integer('work_id')->comment('工种');
            $table->foreign('work_id')->references('id')->on('works')->onDelete('set null');
            $table->integer('work_num')->comment('工种单位数量');
            $table->decimal('total', 10, 2)->default(0.00)->comment('总收入');
            $table->dateTime('workdate')->comment('日期');
            $table->string('hospital_code')->comment('住院号');
            $table->integer('area_id')->comment('区号');
            $table->unique('hospital_code');//添加索引
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
         Schema::dropIfExists('customers');
         Schema::dropIfExists('products');
         Schema::dropIfExists('product_types');
         Schema::dropIfExists('works');
         Schema::dropIfExists('areas');
         Schema::dropIfExists('balances');
         Schema::dropIfExists('orders');
         Schema::dropIfExists('incomes');
    }
}
