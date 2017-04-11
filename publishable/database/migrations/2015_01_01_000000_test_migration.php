<?php

use Illuminate\Database\Migrations\Migration;

class AddVoyagerUserFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('test_table', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'test_table',
            'content' => [
                'name' => 'test_table',
                'structure' => [
                    'id' => 'integer',
                    'name' => 'string',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime'
                ]
            ]
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('test_table');
    }
}
