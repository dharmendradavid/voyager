<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique()->nullable()->default(NULL);
            $table->string('display_name')->nullable()->default(NULL);
            $table->text('value')->nullable()->default(NULL);
            $table->text('details')->nullable()->default(NULL);
            $table->string('type')->nullable()->default(NULL);
            $table->integer('order')->default('1');
        });
        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'settings',
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
                'name' => 'settings',
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
        Schema::dropIfExists('settings');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'settings'
        ]));
    }
}
