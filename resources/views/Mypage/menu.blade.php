@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="item">
			<ul class="mypage-menu">
				<li><a href="{{ route('mypage.top') }}">投稿一覧</a></li>
				<li><a href="{{ route('Users.edit') }}">プロフィール編集</a></li>
				<li><a href="{{ route('logout') }}" onclick="return confirm('本当にログアウトしますか？')">ログアウト</a></li>
			</ul>
		</div>
	</div>
</div>
@endsection