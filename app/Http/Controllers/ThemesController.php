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

		$type_id = Theme::TYPE['ACTIVE'];
		if( empty($request->input('type_id')) == false ){
			$type_id = $request->input('type_id');
		}

		$sort = '10';
		if( empty($request->input('sort')) == false ){
			$sort = $request->input('sort');
		}

		//ログインの場合
		if( empty($request->Auth) == false ){
			$queryThemes->where('Themes.user_id', '<>', $request->Auth['id']);
		}

		$queryThemes = $queryThemes->get();

		//検索キーワード
		$search = $request->input('search');

		return view('top', compact('queryThemes', 'type_id', 'search', 'sort'));
	}

}
