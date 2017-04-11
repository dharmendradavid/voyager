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

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'menus',
            'key' => [
                'primary' => [
                    'name' => 'id',
                    'dataType' => 'numeric'
                ],
                'secondary' => [
                    'name' => 'meta_data',
                    'dataType' => 'string'
                ]
            ],
            'content' => [
                'name' => 'menus',
                'structure' => [
                    'id' => 'integer',
                    'name' => 'string',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime',
                ]
            ]
        ]));

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

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'menu_items',
            'key' => [
                'primary' => [
                    'name' => 'id',
                    'dataType' => 'numeric'
                ],
                'secondary' => [
                    'name' => 'meta_data',
                    'dataType' => 'string'
                ]
            ],
            'content' => [
                'name' => 'menu_items',
                'structure' => [
                    'id' => 'integer',
                    'menu_id' => 'integer',
                    'parent_id' => 'integer',
                    'order' => 'integer',
                    'title' => 'integer',
                    'url' => 'string',
                    'target' => 'string',
                    'icon_class' => 'string',
                    'color' => 'string',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime',
                ]
            ]
        ]));

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

        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'menu_items'
        ]));
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'menus'
        ]));
    }
}
