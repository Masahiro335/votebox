<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('themes', function (Blueprint $table) {
			$table->id()->autoIncrement();
			$table->foreignId('user_id')->comment('ユーザーID')->constrained('users');
			$table->string('body', 200)->comment('本文');
			$table->timestamp('start_date_time')->nullable()->comment('開始日時');
			$table->timestamp('end_date_time')->nullable()->comment('終了日時');
			$table->boolean('is_invalid')->default(false)->comment('無効フラグ');
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
		Schema::dropIfExists('themes');
	}
}
