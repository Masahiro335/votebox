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
			$entUser->update(['name' => $name]);

			if( empty($entUser->id) == false ){
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
		if( $request->query('password_key') != session()->put('password_key')){
			session()->flash('flash_error_message', 'パスワードが違います。');
			return redirect()->route('Users.password');
		}

		return view('/mypage/users/password',['title' => 'パスワード確認']);
	}
}
