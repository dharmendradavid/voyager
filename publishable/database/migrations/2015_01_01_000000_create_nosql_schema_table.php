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
            'name' => config('voyager.real_time_co.items_table_name'),
            'key' => [
                'primary' => [
                    'name' => config('voyager.real_time_co.primary_key_nosql'),
                    'dataType' => 'string'
                ],
                'secondary' => [
                    'name' => config('voyager.real_time_co.secondary_key_nosql'),
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
