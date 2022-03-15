<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

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

			$entUser = User::create([
				'name' => $getData['name'],
				'password' => Hash::make($getData['password']),
			]);

			if( empty($entUser->id) == false ){
				session()->flash('flash_message', 'ユーザーを登録しました。');
				return redirect()->route('Top');	
			}
	
			session()->flash('flash_error_message', '入力エラーがあります。');
			return redirect()
				->route('Users.edit')
				->withErrors($validator)
				->withInput()
			;
		}

		return view('users/edit',['title' => 'ユーザーの登録']);
	}
}
