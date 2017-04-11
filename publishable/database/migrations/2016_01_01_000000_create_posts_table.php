<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->integer('category_id')->nullable();
            $table->string('title');
            $table->string('seo_title')->nullable();
            $table->text('excerpt');
            $table->text('body');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');
            $table->boolean('featured')->default(0);
            $table->timestamps();

            //$table->foreign('author_id')->references('id')->on('users');
        });

        event(new \TCG\Voyager\Events\NoSqlSchemaCreated([
            'name' => 'posts',
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
                'name' => 'posts',
                'structure' => [
                    'id' => 'integer',
                    'author_id' => 'integer',
                    'category_id' => 'integer',
                    'title' => 'string',
                    'seo_title' => 'string',
                    'excerpt' => 'string',
                    'body' => 'string',
                    'image' => 'string',
                    'slug' => 'string',
                    'meta_description' => 'string',
                    'meta_keywords' => 'string',
                    'status' => 'array',
                    'feature' => 'boolean',
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
        Schema::drop('posts');
        event(new \TCG\Voyager\Events\NoSqlSchemaDeleted([
            'name' => 'posts'
        ]));
    }
}
