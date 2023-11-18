<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseSupplierPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_supplier', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_id')->index();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->primary(['purchase_id', 'supplier_id']);
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('qty');
            $table->string('currency');
            $table->string('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_supplier');
    }
}
