<?php

use Illuminate\Database\Migrations\Migration;

class CreateNoSqlSchemaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'ItemsTable',
            'key' => [
                'primary' => [
                    'name' => 'table_name',
                    'dataType' => 'string'
                ],
                'secondary' => [
                    'name' => 'id',
                    'dataType' => 'numeric'
                ]
            ],
            'content' => [
                'name' => 'ItemsTable',
            ]
        ]));


    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        /*event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'ItemsTable'
        ]));
        */
    }
}
