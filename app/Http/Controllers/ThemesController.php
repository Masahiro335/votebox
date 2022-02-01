<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThemesController extends Controller
{
	public function edit(Request $request, $id = 0)
	{
		if(empty($request->input()) == false){
			$getData = $request->input();
			
			$ThemeModel = new \App\Models\Theme();
			$entTheme = $ThemeModel->create([
				'user_id' => '1',
				'body' => $getData['body'],
			]);
			var_dump($entTheme);

		
			exit;

			return view('top');
		}
		return view('Themes/edit', ['title' => 'テーマの登録']);
	}
}
