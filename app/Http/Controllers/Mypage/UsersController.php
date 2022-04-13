<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends AppMyController
{
	/**
	 * ユーザー名の変更
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function edit(Request $request)
	{
		if( $request->isMethod('post') ){
			$name = $request->input('name');

			if( $name == $request->Auth['name']){
				session()->flash('flash_error_message', '名前が変更されておりません。');
				return redirect()
					->route('Users.edit')
					->withInput()
				;
			}

			$userRequest = new UserRequest();
			$validator = Validator::make(['name' => $name], $userRequest->ruleName(), $userRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '入力エラーがあります。');
				return redirect()
					->route('Users.edit')
					->withErrors($validator)
					->withInput()
				;
			}

			$entUser = User::find($request->Auth['id']);
			if( $entUser->update(['name' => $name]) ){
				session()->flash('flash_message', 'ユーザーを登録しました。');
				return redirect()->route('mypage.top');	
			}
	
			session()->flash('flash_error_message', '入力エラーがあります。');
			return redirect()
				->route('Users.edit')
				->withErrors($validator)
				->withInput()
			;
		}

		return view('/mypage/users/edit',['title' => 'ユーザー名変更']);
	}


	/**
	 * パスワードの確認
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function password(Request $request)
	{
		if( $request->isMethod('post') ){
			$password = $request->input('password');
			$entUser = User::find($request->Auth['id']);
	
			// パスワードの確認
			if( Hash::check($password, $entUser->password) ) {
				$randomNumber = $this->randomNumber();
				session()->put('password_key', $randomNumber);

				session()->flash('flash_message', 'パスワードを確認しました。');
				return redirect()->route('Users.passwordEdit', ['password_key' => Hash::make($randomNumber)]);
			}
	
			session()->flash('flash_error_message', 'パスワードが違います。');
			return redirect()->route('Users.password');
		}

		return view('/mypage/users/password',['title' => 'パスワード確認']);
	}


	/**
	 * パスワードの変更
	 * 
	 * @author　matsubara
	 * @param Request $request
	 */
	public function passwordEdit(Request $request)
	{
		// パスワードの確認
		if( Hash::check(session()->get('password_key'), $request->query('password_key')) == false) {
			session()->forget('password_key');
			session()->flash('flash_error_message', 'パスワードの確認ができまでんでした。');
			return redirect()->route('Users.password');
		}

		//パスワードの変更
		if( $request->isMethod('post') ){
			$password = $request->input('password');

			$userRequest = new UserRequest();
			$validator = Validator::make(['password' => $password], $userRequest->rulePassword(), $userRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', 'パスワードの変更に失敗しました。');
				return redirect()->route('Users.passwordEdit', ['password_key' => $request->query('password_key')]);
			}

			$entUser = User::find($request->Auth['id']);
			$entUser->update(['password' => Hash::make($password)]);

			session()->flash('flash_message', 'パスワードを変更しました。');
			session()->forget('password_key');
			return redirect()->route('mypage.top');
		}

		return view('/mypage/users/password',['title' => 'パスワード変更', 'is_confirm' => true, 'password_key' => $request->query('password_key')]);
	}
}
