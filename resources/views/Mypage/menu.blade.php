@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="item">
			<ul class="mypage-menu">
				<li><a href="{{ route('mypage.top') }}">投稿一覧</a></li>
				<li><a href="{{ route('Users.edit') }}">ユーザー名変更</a></li>
				<li><a href="{{ route('Users.edit') }}">パスワード変更</a></li>
				<li><a href="{{ route('logout') }}" onclick="return confirm('本当にログアウトしますか？')">ログアウト</a></li>
			</ul>
		</div>
	</div>
</div>
@endsection