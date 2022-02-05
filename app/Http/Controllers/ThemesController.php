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
			$VoteModel = new \App\Models\Vote();

			try {
				DB::beginTransaction();

				$entTheme = $ThemeModel->create([
					'user_id' => '1',
					'body' => $getData['body'],
				]);
				foreach($getData['vote-items'] as $key => $vote_item){
					$VoteModel->create([
						'theme_id' => $entTheme->id,
						'name' => $vote_item,
						'sort_number' => $key + 1,
					]);
				}

				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
				session()->flash('flash_error_message', '投稿に失敗しました');
				return redirect()->route('Themes.edit');
			}

			session()->flash('flash_message', 'テーマを投稿しました');
			return redirect()->route('Top');
		}
		return view('Themes/edit', ['title' => 'テーマの登録']);
	}
}
