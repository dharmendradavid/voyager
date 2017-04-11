<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing categories
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->integer('order')->default(1);
            $table->string('name')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->timestamps();
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'categories',
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
                'name' => 'categories',
                'structure' => [
                    'id' => 'integer',
                    'parent_id' => 'integer',
                    'order' => 'integer',
                    'name' => 'string',
                    'slug' => 'string',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime',
                ]
            ]
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'categories'
        ]));
    }
}
