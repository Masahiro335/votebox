<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [];
		$theme_id = 1;
		$sort_number = 1;
		for($i = 1; $i <= 200; $i++){
			$data[] = [
				'id' => $i,
				'theme_id' => $theme_id,
				'name' => '投票項目'.$i,
				'sort_number' => $sort_number,
				'is_deleted' => false,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$sort_number++; 

			if( $i % 4 == 0 ) $theme_id++;
			if( $sort_number % 5 == 0 ) $sort_number = 1;	
		}

		DB::table('votes')->insert($data);
	}
}
