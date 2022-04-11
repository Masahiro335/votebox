<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ThemeRequest;
use \App\Models\Theme;

class TopController extends AppController
{


	/**
	 * TOP画面
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function index(Request $request)
	{
		$queryThemes = Theme::querytop($request, false);

		// TOP画面に使用するデータ
		$data = $this->topData($request);

		return view('top', compact('queryThemes', 'data'));
	}

}
