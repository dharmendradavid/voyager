<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('data_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->string('display_name_singular')->nullable()->default(NULL);
            $table->string('display_name_plural')->nullable()->default(NULL);
            $table->string('icon')->nullable()->default(NULL);
            $table->string('model_name')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->boolean('generate_permissions')->default(false);
            $table->timestamps();
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'data_types',
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
                'name' => 'data_types',
                'structure' => [
                    'id' => 'integer',
                    'name' => 'string',
                    'slug' => 'string',
                    'display_name_singular' => 'string',
                    'display_name_plural' => 'string',
                    'icon' => 'string',
                    'description' => 'string',
                    'model_name' => 'string',
                    'generate_permissions' => 'boolean',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime',
                ]
            ]
        ]));

        // Create table for storing roles
        Schema::create('data_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('data_type_id')->unsigned()->nullable()->default(NULL);
            $table->string('field')->nullable()->default(NULL);
            $table->string('type')->nullable()->default(NULL);
            $table->string('display_name')->nullable()->default(NULL);
            $table->boolean('required')->default(false);
            $table->boolean('browse')->default(true);
            $table->boolean('read')->default(true);
            $table->boolean('edit')->default(true);
            $table->boolean('add')->default(true);
            $table->boolean('delete')->default(true);
            $table->text('details')->nullable()->default(NULL);

            $table->foreign('data_type_id')->references('id')->on('data_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });


        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'data_rows',
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
                'name' => 'data_rows',
                'structure' => [
                    'id' => 'integer',
                    'data_type_id' => 'integer',
                    'field' => 'string',
                    'type' => 'string',
                    'display_name' => 'string',
                    'required' => 'boolean',
                    'browse' => 'boolean',
                    'read' => 'boolean',
                    'edit' => 'boolean',
                    'add' => 'boolean',
                    'delete' => 'boolean',
                    'details' => 'string',
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
        Schema::drop('data_rows');
        Schema::drop('data_types');

        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'data_rows'
        ]));
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'data_types'
        ]));
    }
}
