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
            'name' => 'schema',
            'key' => [
                'primary' => [
                    'name' => 'name',
                    'dataType' => 'string'
                ],
                'secondary' => [
                    'name' => 'meta_data',
                    'dataType' => 'string'
                ]
            ],
            'content' => [
                'name' => 'schema',
                'structure' => [
                    'name' => 'schema',
                ]
            ]
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
