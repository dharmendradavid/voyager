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
            $table->integer('author_id')->nullable()->default(NULL);
            $table->integer('category_id')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('seo_title')->nullable()->default(NULL);
            $table->text('excerpt')->nullable()->default(NULL);
            $table->text('body')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->text('meta_keywords')->nullable()->default(NULL);
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');
            $table->boolean('featured')->default(0);
            $table->timestamps();

            //$table->foreign('author_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
