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
		if( $request->isMethod('post') || $request->isMethod('put') ){
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
				return redirect()->route('top');	
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
}
