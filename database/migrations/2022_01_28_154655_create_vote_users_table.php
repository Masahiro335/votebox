<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vote_users', function (Blueprint $table) {
			$table->id()->autoIncrement();
			$table->foreignId('theme_id')->constrained('themes');
			$table->foreignId('vote_id')->constrained('votes');
			$table->timestamp('modified')->useCurrent();
			$table->timestamp('created')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('vote_users');
	}
}
