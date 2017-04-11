<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('table_name')->nullable()->default(NULL);
            $table->string('column_name')->nullable()->default(NULL);
            $table->integer('foreign_key')->unsigned()->nullable()->default(NULL);
            $table->string('locale')->nullable()->default(NULL);

            $table->text('value')->nullable()->default(NULL);

            $table->unique(['table_name', 'column_name', 'foreign_key', 'locale']);

            $table->timestamps();
        });
        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'translations',
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
                'name' => 'translations',
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
        Schema::dropIfExists('translations');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'translations'
        ]));
    }
}
