<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned()->index()->nullable()->default(NULL);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('role_id')->unsigned()->index()->nullable()->default(NULL);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->index(['permission_id', 'role_id']);
        });
        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'permission_role',
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
                'name' => 'permission_role',
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
        Schema::dropIfExists('permission_role');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'permission_role'
        ]));
    }
}
