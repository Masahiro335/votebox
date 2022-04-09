<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ThemeRequest;
use \App\Models\Theme;
use \App\Models\Vote;
use \App\Models\VoteUser;

class ThemesController extends AppMyController
{


	/**
	 * マイページTOP
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function index(Request $request)
	{
		$queryThemes = Theme::querytop($request, true);

		$type_id = Theme::TYPE['ACTIVE'];
		if( empty($request->input('type_id')) == false ){
			$type_id = $request->input('type_id');
		}

		$sort = '10';
		if( empty($request->input('sort')) == false ){
			$sort = $request->input('sort');
		}

		//検索キーワード
		$search = $request->input('search');

		$queryThemes = $queryThemes->get();

		return view('top', compact('queryThemes', 'type_id', 'search', 'sort'));
	}


	/**
	 * テーマの投稿処理
	 * 
	 * @author　matsubara
	 * @param Request $request
	 * @param $id テーマID
	 */
	public function edit(Request $request, $id = null)
	{

		//新規投稿
		if( empty($id) ){
			$entTheme = new Theme();
		}else{
			$entTheme = Theme::find($id);
			if( empty($entTheme) ){
				session()->flash('flash_error_message', '情報の取得に失敗しました。');
				return redirect()->route('mypage.top');
			}
			if( $entTheme->isEdit() == false ){
				session()->flash('flash_error_message', 'この投稿は編集できる状態ではありません。');
				return redirect()->route('mypage.top');
			}	
		}

		if( $request->isMethod('post') || $request->isMethod('put') ){
			$getData = $request->all();
			if( empty($getData['start_date_time'] == false) ){
				$getData['start_date_time'] = $getData['start_date_time'].' '.(empty($getData['start_time']) ? '00:00' : $getData['start_time']);
			}
			if( empty($getData['end_date_time'] == false) ){
				$getData['end_date_time'] = $getData['end_date_time'].' '.(empty($getData['end_time']) ? '00:00' : $getData['end_time']);
			}
			$is_invalid = empty($getData['is_invalid']);

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

				//保存データ
				$saveData = [
					'body' => $getData['body'],
					'start_date_time' => $getData['start_date_time'],
					'end_date_time' => $getData['end_date_time'],
					'is_invalid' => $is_invalid,	
				];
	
				if( empty($id) ){
					$entTheme = Theme::create( array_merge($saveData, ['user_id' => $request->Auth['id']]) );
				}else{
					$entTheme->update($saveData);
				}

				if( empty($id) == false){
					Vote::query()->where('theme_id', $entTheme->id)->delete();
				}

				foreach($getData['vote_names'] as $key => $vote_name){
					Vote::create([
						'theme_id' => $entTheme->id,
						'name' => $vote_name,
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
			return redirect()->route('mypage.top');
		}

		return view('mypage/themes/edit',['title' => 'お題の登録', 'entTheme' => $entTheme]);
	}



	/**
	 * テーマの無効
	 * 
	 * @author　matsubara
	 * @param Request $request
	 * @param $id テーマID
	 */
	public function invalid(Request $request, $id = null)
	{
	}


	/**
	 * グラフの作成
	 * 
	 * @author　matsubara
	 * @param Request $request
	 * @param $id テーマID
	 */
	public function graph(Request $request, $id )
	{
		if( $request->ajax() == false ) return redirect()->route('top');

		$entTheme = Theme::where('Themes.id', $id)->first();
		if( empty($entTheme) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}
		//投票できる場合は、グラフ非表示
		if( $entTheme->isVote( $request->Auth ) == true ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		//グラフのデータ
		$data = $entTheme->graphData( $request->Auth );

		return response()->json($data);
	}


	/**
	 * 投票項目を取得
	 * 
	 * @author　matsubara
	 * @param Request $request
	 * @param $id テーマID
	 */
	public function voteName(Request $request, $id )
	{
		if( $request->ajax() == false ) return redirect()->route('top');

		$entTheme = Theme::where('Themes.id', $id)->first();
		if( empty($entTheme) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}
		//投票できない場合は、投票項目を非表示
		if( $entTheme->isVote( $request->Auth ) == false ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		//投票項目を取得
		$data = [];
		foreach($entTheme->votes as $key => $entVote){
			$data[$key]['vote_id'] = $entVote->id;
			$data[$key]['vote_name'] = $entVote->name;
		}

		return response()->json($data);
	}


	/**
	 * 選択した投票項目に投票する
	 * 
	 * @author　matsubara
	 * @param Request $request
	 * @param $vote_id 投票ID
	 */
	public function vote(Request $request, $vote_id )
	{
		if( $request->ajax() == false ) return redirect()->route('top');

		$entVote = Vote::where('Votes.id', $vote_id)->first();
		if( empty($entVote) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}
		//投票できない場合
		if( $entVote->theme->isVote( $request->Auth ) == false ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		$entVoteUser = VoteUser::create([
			'user_id' => $request->Auth['id'],
			'vote_id' => $entVote->id,
		]);
		if( empty($entVoteUser) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		$entTheme = Theme::where('Themes.id', $entVote->theme->id)->first();

		//グラフのデータ
		$data = $entTheme->graphData();

		return response()->json($data);
	}

}
