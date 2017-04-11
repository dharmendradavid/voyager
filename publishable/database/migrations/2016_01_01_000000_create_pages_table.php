<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use TCG\Voyager\Models\Page;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->text('excerpt')->nullable()->default(NULL);
            $table->text('body')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->text('meta_keywords')->nullable()->default(NULL);
            $table->enum('status', Page::$statuses)->default(Page::STATUS_INACTIVE);
            $table->timestamps();
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'pages',
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
                'name' => 'pages',
                'structure' => [
                    'id' => 'integer',
                    'author_id' => 'integer',
                    'title' => 'string',
                    'excerpt' => 'string',
                    'body' => 'string',
                    'image' => 'string',
                    'slug' => 'string',
                    'read' => 'string',
                    'meta_description' => 'string',
                    'meta_keywords' => 'string',
                    'status' => 'array',
                    'created_at' => 'dateTime',
                    'updated_at' => 'dateTime',
                ]
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
        Schema::drop('pages');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'pages'
        ]));
    }
}
