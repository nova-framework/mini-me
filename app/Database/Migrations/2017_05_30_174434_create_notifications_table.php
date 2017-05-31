<?php

use Mini\Database\Schema\Blueprint;
use Mini\Database\Migrations\Migration;


class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function (Blueprint $table)
		{
			$table->string('id', 40)->primary();
			$table->string('type');
			$table->morphs('notifiable');
			$table->text('data');
			$table->timestamp('read_at')->nullable();
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
		Schema::drop('notifications');
	}
}