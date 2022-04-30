<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\Factory;
use \App\Models\User;
use \App\Models\Theme;

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

		$entUser = User::where('users.id', $entUser->id)
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


	/**
	 * TOP画面に使用するデータ
	 * 
	 * @return bool true:できる false:できない
	 */
	public function topData($request)
	{
		$data = [];

		$data['type_id'] = Theme::TYPE['ACTIVE'];
		if( empty($request->input('type_id')) == false ){
			$data['type_id'] = $request->input('type_id');
		}

		$data['sort'] = '10';
		if( empty($request->input('sort')) == false ){
			$data['sort'] = $request->input('sort');
		}

		//検索キーワード
		$data['search'] = $request->input('search');

		return $data;
	}


	/**
	 * 乱数を出力
	 * 
	 * @param int $length　桁数
	 * @return int 乱数
	 */
	public function randomNumber($length = 4)
	{
		$max = pow(10, $length) - 1;
		$rand = mt_rand(0, $max); 
		$rand = sprintf('%0'. $length. 'd', $rand); //0埋め

		return $rand;
	}

}
