<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends AppController
{
	/**
	 * ログイン
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function login(Request $request)
	{
		if( $request->isMethod('post') ){
			$getData = $request->all();

			if( empty($getData['name']) || empty($getData['password']) ){
				session()->flash('flash_error_message', '全て入力して下さい。');
				return redirect()
					->route('Login')
					->withInput()
				;
			}

			$entUser = User::where('Users.name', $getData['name'])
				->where('is_deleted', false)
				->first()
			;
			if( empty($entUser) ){
				session()->flash('flash_error_message', '名前かパスワードが一致しませんでした。');
				return redirect()
					->route('Login')
					->withInput()
				;
			}

			// パスワードの確認
			if ( Hash::check($getData['password'], $entUser->password) ) {
				if( empty($this->LoginSession($entUser)) == false ){
					session()->flash('flash_message', 'ログインに成功しました。');
					return redirect()->route('Top');
				};
			}

			session()->flash('flash_error_message', '名前かパスワードが一致しませんでした。');
			return redirect()
				->route('Login')
				->withInput()
			;
		}

		return view('/login',['title' => 'ログイン']);
	}
}
