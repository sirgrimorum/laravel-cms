<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSirgrimorumCmsArticles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function($table)
		{
			$table->increments('id');
			$table->string('nickname');
			$table->string('scope');
			$table->string('lang');
			$table->longtext('content')->nullable();
			$table->boolean('activated')->default(0);
			$table->integer('user_id')->nullable();
			$table->timestamps();
			$table->unique(array('nickname','lang','scope'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
