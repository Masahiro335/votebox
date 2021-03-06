<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use \App\Models\User;

class Login
{
	public function __construct(Factory $viewFactory)
	{
		$this->viewFactory = $viewFactory;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{  
		$entUser = null;

		//ログインセッション処理
		if( empty(session()->has('Auth')) == false ){
			$Auth = session()->get('Auth');
			$entUser = User::where('users.id', $Auth['id'])
				->where('is_deleted', false)
				->first()
			;

			if( empty($entUser) == false ){
				$entUser->setHidden(['password', 'is_deleted','updated_at','created_at']);
				if( (new \App\Http\Controllers\AppController())->LoginSession($entUser) == false ){
					$entUser = null;
				}
			}
		}

		//コントローラに反映
		$request->merge(['Auth' => $entUser]);
		//ビューに反映
		$this->viewFactory->share('Auth', $entUser);

		return $next($request);
	}
}
