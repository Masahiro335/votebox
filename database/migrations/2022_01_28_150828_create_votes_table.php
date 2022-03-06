<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function (Blueprint $table) {
			$table->id()->autoIncrement();
			$table->foreignId('theme_id')->comment('テーマID')->constrained('themes');
			$table->string('name', 10)->comment('投票名');
			$table->integer('sort_number')->comment('ソートナンバー');
			$table->boolean('is_deleted')->default(false)->comment('論理削除');
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
		Schema::dropIfExists('votes');
	}
}
