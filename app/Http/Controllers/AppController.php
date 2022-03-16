<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
 * 共通コントローラー
*/
class AppController extends Controller
{
	/**
	 * ログインセッションに保存
	 * 
	 * @author　matsubara
	 * @param Entity $entUser ユーザー情報
	 * @return bool true:成功 false:失敗
	 */
	public function LoginSession( $entUser = null){
		//セッションが保存されていない場合
		if( empty(session()->has('Auth')) ){
			if( empty($entUser) ) return false;

			//不要なカラムは隠す
			$userData = $entUser->setHidden(['password', 'is_deleted','updated_at','created_at'])->toArray();
			session()->put('Auth', $userData);
		}

		$this->Auth = session()->get('Auth');		
		if( empty($this->Auth) ) return false;

		return true;
	}
}
