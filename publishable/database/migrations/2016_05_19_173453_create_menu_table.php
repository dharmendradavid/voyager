<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable()->default(NULL);
            $table->timestamps();
        });


        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('url')->nullable()->default(NULL);
            $table->string('target')->default('_self');
            $table->string('icon_class')->nullable()->default(NULL);
            $table->string('color')->nullable()->default(NULL);
            $table->integer('parent_id')->nullable()->default(NULL);
            $table->integer('order')->nullable()->default(NULL);
            $table->timestamps();
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_items');
        Schema::drop('menus');
    }
}
