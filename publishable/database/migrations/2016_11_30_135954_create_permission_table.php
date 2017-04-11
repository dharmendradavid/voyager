<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->index()->nullable()->default(NULL);
            $table->string('table_name')->nullable()->default(NULL);
            $table->timestamps();
        });
        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'permissions',
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
                'name' => 'permissions',
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
        Schema::dropIfExists('permissions');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'permissions'
        ]));
    }
}
