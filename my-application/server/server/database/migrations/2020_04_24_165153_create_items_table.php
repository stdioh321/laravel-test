<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('items');
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(true);
            $table->double('price')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('id_brand');
            $table->unsignedBigInteger('id_model');
            $table->string('color')->nullable(true);
            $table->foreign('id_brand')->references('id')->on('brands');
            $table->foreign('id_model')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
