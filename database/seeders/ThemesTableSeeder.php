<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [];
		for($i = 1; $i <= 50; $i++){
			$data[] = [
				'id' => $i,
				'user_id' =>  $i % 2 == 0 ? '2' : '1',
				'body' => 'お題'.$i,
				'start_date_time' => '2022-04-01 12:00:00',
				'end_date_time' => '2023-04-01 12:00:00',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
		}

		DB::table('themes')->insert($data);
	}
}
