<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

class UsersController extends AppController
{
    /**
	 * ユーザー登録処理
	 * 
	 * @author　matsubara
	 * @param $request Request
	 * @param $id ユーザーID
	 */
	public function edit(Request $request, $id = null)
	{
		if( $request->isMethod('post') || $request->isMethod('put') ){
			$getData = $request->all();

			$userRequest = new UserRequest();
			$validator = Validator::make($getData, $userRequest->rules(), $userRequest->messages());
			if( $validator->fails() ) {
				session()->flash('flash_error_message', '入力エラーがあります。');
				return redirect()
					->route('Users.edit')
					->withErrors($validator)
					->withInput()
				;
			}

			session()->flash('flash_message', 'お題を投稿しました');
			return redirect()->route('Top');
		}

		return view('users/edit',['title' => 'ユーザーの登録']);
	}
}
