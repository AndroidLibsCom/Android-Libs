<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibrariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('libraries', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('disqus', 20)->nullable();
            $table->string('gradle', 255)->nullable();
            $table->text('img')->nullable();
            $table->text('description')->nullable();
            $table->string('submittor_email', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->boolean('public');
            $table->boolean('featured');
            $table->integer('min_sdk');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
