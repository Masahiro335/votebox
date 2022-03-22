<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ThemeRequest;
use \App\Models\Theme;
use \App\Models\Vote;

class ThemesController extends AppController
{


	/**
	 * TOP画面
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function index(Request $request)
	{
		$queryThemes = Theme::query()
			->where('Themes.is_deleted', false)
			->where('Themes.is_invalid', false)
			->whereDate('Themes.start_date_time', '<=', date('Y-m-d') )
			->whereDate('Themes.end_date_time', '>=', date('Y-m-d') )
			->orderBy('Themes.created_at', 'desc')
		;

		//ログインの場合
		if( empty($request->Auth) == false ){
			$queryThemes->where('Themes.user_id', '<>', $request->Auth['id']);
		}

		$is_close = false;

		if( empty($request->input('is_close')) == false ){
			$is_close = true;
		}

		//検索
		if( empty($request->input('search')) == false ){
			//$queryThemes->where('Themes.body', '<>', $request->Auth['id']);
		}

		$queryThemes = $queryThemes->get();

		return view('top', compact('queryThemes', 'is_close'));
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
		if( empty($id) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		$entTheme = Theme::where('Themes.id', $id)->first();
		if( empty($entTheme) ){
			return response()->json('情報の取得に失敗しました。', 400);
		}

		$data = [];
		foreach($entTheme->votes as $entVote){
			$data['vote_name'][] = $entVote->name;
			$data['vote_coount'][] = empty($entVote->vote_users) ? 0 : count($entVote->vote_users);
		}

		return response()->json($data);
	}
}
