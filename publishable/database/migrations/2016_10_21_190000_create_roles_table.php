<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable()->default(NULL);
            $table->string('display_name')->nullable()->default(NULL);
            $table->timestamps();
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'roles',
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
                'name' => 'roles',
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
        Schema::drop('roles');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'roles'
        ]));
    }
}
