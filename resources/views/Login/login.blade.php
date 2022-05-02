@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">LOGIN</div>
			{{ Form::open(['url' => route('login') ]) }} 
				<label class="form-title required">名前</label>
				<div class="form-item">
					{{ Form::text('name', '', ['required' => true]) }}
				</div>

				<label class="form-title required">パスワード</label>
				<div class="form-item">
					{{ Form::password('password', ['required' => true]) }}
				</div>

				{{ Form::submit('ログイン', ['class'=>'btn add']) }}
			{{ Form::close() }}
			<br>
			登録は<a href="{{ route('register') }}">こちら</a>です。
		</div>
	</div>
</div>

@endsection