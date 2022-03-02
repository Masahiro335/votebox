<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use \App\Models\Theme;
use \App\Models\Vote;

class ThemesController extends Controller
{


	/**
	 * TOP画面
	 * 
	 * @author　matsubara
	 */
	public function index()
	{
		return view('top');
	}


	/**
	 * テーマの投稿処理
	 * 
	 * @author　matsubara
	 * @param $request Request
	 * @param $id テーマID
	 */
	public function edit(Request $request, $id = null)
	{
		if( $request->isMethod('post') ){
			$getData = $request->all();
			$rulus = [
				'body' => ['required', 'max:100'],
				'vote-items.*' => ['required', 'max:10'],
			];
			$errors = [
				'body.required' => 'テーマは必須項目です。',
				'body.max' => '100文字以内で入力して下さい。',
				'vote-items.*.required' => '投票項目は必須項目です。',
				'vote-items.*.max' => '10文字以内で入力して下さい。',
			];
			$validator = Validator::make($request->all(), $rulus, $errors);
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '投稿に失敗しました');
				return redirect()
					->route('Themes.edit')
					->with(compact('getData'))
					->withErrors($validator)
					->withInput()
				;
			}
			try {
				DB::beginTransaction();

				$entTheme = Theme::create([
					'user_id' => '1',
					'body' => $getData['body'],
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
					->route('Themes.edit')
					->with(compact('getData'))
					->withErrors($validator)
					->withInput()
				;
			}

			session()->flash('flash_message', 'テーマを投稿しました');
			return redirect()->route('Top');
		}
		if( empty($getData) ){
			$getData = null;
		}
		return view('Themes/edit',['title' => 'テーマの登録', 'getData' => $getData]);
	}
}
