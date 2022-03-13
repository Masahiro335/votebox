<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends AppController
{
    /**
	 * ユーザー登録処理
	 * 
	 * @author　matsubara
	 * @param $request Request
	 * @param $id ユーザーID
	 */
	public function edit(Request $request, $id = null)
	{
		if( $request->isMethod('post') ){
			$getData = $request->all();

			$themeRequest = new ThemeRequest();
			$validator = Validator::make($getData, $themeRequest->rules(), $themeRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '入力エラーがあります。');
				return redirect()
					->route('Users.edit')
					->withErrors($validator)
					->withInput()
				;
			}
			try {
				DB::beginTransaction();

				$entTheme = Theme::create([
					'user_id' => '1',
					'body' => $getData['body'],
					'start_date_time' => $getData['start_date_time'],
					'end_date_time' => $getData['end_date_time'],
					'is_invalid' => $getData['is_invalid'],
				]);
				foreach($getData['vote-items'] as $key => $vote_item){
					Vote::create([
						'theme_id' => $entTheme->id,
						'name' => $vote_item,
						'sort_number' => $key + 1,
					]);
				}

				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
				session()->flash('flash_error_message', '投稿に失敗しました');
				return redirect()
					->route('Users.edit')
					->withErrors($validator)
					->withInput()
				;
			}

			session()->flash('flash_message', 'お題を投稿しました');
			return redirect()->route('Top');
		}

		return view('users/edit',['title' => 'ユーザーの登録']);
	}
}
