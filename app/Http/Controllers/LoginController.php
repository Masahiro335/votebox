<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use \App\Models\User;
use App\Http\Requests\UserRequest;
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
					->route('login')
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
					->route('login')
					->withInput()
				;
			}

			// パスワードの確認
			if ( Hash::check($getData['password'], $entUser->password) ) {
				if( $this->loginSession($entUser) ){
					session()->flash('flash_message', 'ログインに成功しました。');
					return redirect()->route('top');
				}
			}

			session()->flash('flash_error_message', '名前かパスワードが一致しませんでした。');
			return redirect()
				->route('login')
				->withInput()
			;
		}

		return view('/login',['title' => 'ログイン']);
	}


	/**
	 * 登録処理
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function register(Request $request)
	{
		if( $request->isMethod('post') || $request->isMethod('put') ){
			$getData = $request->all();

			$userRequest = new UserRequest();
			$validator = Validator::make($getData, $userRequest->rules(), $userRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '入力エラーがあります。');
				return redirect()
					->route('register')
					->withErrors($validator)
					->withInput()
				;
			}

			$entUser = User::create([
				'name' => $getData['name'],
				'password' => Hash::make($getData['password']),
			]);

			if( empty($entUser->id) == false ){
				session()->flash('flash_message', 'ユーザーを登録しました。');
				return redirect()->route('top');	
			}
	
			session()->flash('flash_error_message', '入力エラーがあります。');
			return redirect()
				->route('register')
				->withErrors($validator)
				->withInput()
			;
		}

		return view('/register',['title' => 'ユーザーの登録']);
	}


	/**
	 * ログアウト
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function Logout(Request $request)
	{
		if( $this->LoginSessionOut() ) session()->flash('flash_message', 'ログアウトに成功しました。');
		else session()->flash('flash_error_message', 'ログアウトに失敗しました。');

		return redirect()->route('top');
	}
}
