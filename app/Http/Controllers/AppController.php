<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\Factory;
use \App\Models\User;

/*
 * 共通コントローラー
*/
class AppController extends Controller
{
	//コンストラクタ
	public function __construct()
    {
    }

	/**
	 * ログインセッションに保存
	 * 
	 * @author　matsubara
	 * @param Entity $entUser ユーザー情報
	 * @return bool true:成功 false:失敗
	 */
	public function LoginSession( $entUser = null ){
		if( empty($entUser) ) return false;

		$entUser = User::where('Users.id', $entUser->id)
			->where('is_deleted', false)
			->first()
		;
		if( empty($entUser) ) return false;

		$entUser->last_login_date = date('Y-m-d H:i:s'); 

		//不要なカラムは隠す
		$userData = $entUser->setHidden(['password', 'is_deleted','updated_at','created_at'])->toArray();

		session()->put('Auth', $userData);
		return !empty(session()->has('Auth'));
	}

	/**
	 * ログインセッションの破棄
	 * 
	 * @author　matsubara
	 * @return bool true:成功 false:失敗
	 */
	public function LoginSessionOut(){
		session()->forget('Auth');
		return empty(session()->has('Auth'));
	}

}
