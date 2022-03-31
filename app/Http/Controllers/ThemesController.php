<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
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
		$queryThemes = Theme::querytop($request);

		$type_id = 10;
		if( empty($request->input('type_id')) == false ){
			$type_id = $request->input('type_id');
		}

		//ログインの場合
		if( empty($request->Auth) == false ){
			$queryThemes->where('Themes.user_id', '<>', $request->Auth['id']);
		}

		$queryThemes = $queryThemes->get();

		//検索キーワード
		$search = $request->input('search');

		return view('top', compact('queryThemes', 'type_id', 'search'));
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
