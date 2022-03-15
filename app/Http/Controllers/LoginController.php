<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends AppController
{
	/**
	 * ログイン
	 * 
	 * @author　matsubara
	 * @param $request Request
	 */
	public function login(Request $request)
	{
		if( $request->isMethod('post') ){
			$getData = $request->all();

			
			
		}

		return view('/login',['title' => 'ログイン']);
	}
}
