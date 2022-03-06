<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
			$table->foreignId('user_id')->comment('ユーザーID')->constrained('users');
			$table->foreignId('vote_id')->comment('投票ID')->constrained('votes');
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
		Schema::dropIfExists('vote_users');
	}
}
