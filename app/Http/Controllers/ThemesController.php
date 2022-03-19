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
	 */
	public function index()
	{
		$queryThemes = Theme::orderBy('Themes.created_at', 'desc')
			->where('Themes.is_deleted', false)
			->where('Themes.is_invalid', false)
			->whereDate('Themes.start_date_time', '<=', date('Y-m-d') )
			->whereDate('Themes.end_date_time', '>=', date('Y-m-d') )
			->get()
		;

		return view('top', ['queryThemes' => $queryThemes]);
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
		if( $request->ajax() == false ) return redirect()->route('Top');
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
