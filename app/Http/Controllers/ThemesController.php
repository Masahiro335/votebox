<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ThemeRequest;
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
			if( empty($getData['start_date_time'] == false) ){
				$getData['start_date_time'] = $getData['start_date_time'].' '.(empty($getData['start_time']) ? '00:00' : $getData['start_time']);
			}
			if( empty($getData['end_date_time'] == false) ){
				$getData['end_date_time'] = $getData['end_date_time'].' '.(empty($getData['end_time']) ? '00:00' : $getData['end_time']);
			}
			$getData['is_invalid'] = !empty($getData['is_invalid']);

			$themeRequest = new ThemeRequest();
			$validator = Validator::make($getData, $themeRequest->rules(), $themeRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '入力エラーがあります。');
				return redirect()
					->route('Themes.edit')
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
					->route('Themes.edit')
					->withErrors($validator)
					->withInput()
				;
			}

			session()->flash('flash_message', 'お題を投稿しました');
			return redirect()->route('Top');
		}

		return view('Themes/edit',['title' => 'お題の登録']);
	}
}
