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
			$table->foreignId('theme_id')->constrained('themes');
			$table->string('name', 10);
			$table->integer('sort_number');
			$table->boolean('is_deleted')->default(false);
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
		Schema::dropIfExists('votes');
	}
}
