<?php

use Illuminate\Database\Migrations\Migration;

class AddVoyagerUserFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('avatar')->nullable()->after('email');
            $table->integer('role_id')->nullable()->after('id');
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'users',
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
                'name' => 'users',
                'structure' => [
                    'id' => 'integer',
                    'avatar' => 'string',
                    'role_id' => 'integer',
                ]
            ]
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('avatar');
            $table->dropColumn('role_id');
        });
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'users'
        ]));
    }
}
