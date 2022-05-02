@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">{{ empty($is_confirm) ? 'パスワード確認' : 'パスワード変更' }}</div>
			{{ Form::open(['url' => empty($is_confirm) ? route('Users.password') : route('Users.passwordEdit',['password_key' => $password_key]) ]) }} 
				<label class="form-title required">パスワード</label>
				<div class="form-item">
					{{ Form::password('password', ['required' => true]) }}
				</div>

				@if( empty($is_confirm) == false )
					<ul class="help-text">
						<li>8文字以上で記入して下さい。</li>
						<li>20文字以内で記入して下さい。</li>
						<li>半角英数字のみで記入して下さい。</li>
					</ul>
				@endif

				@if( $errors->has('password') )
					@foreach($errors->get('password') as $errorMessage)
						<div class="error-message">{{ $errorMessage }}</div>
					@endforeach
				@endif

				{{ Form::submit(empty($is_confirm) ? '確認' : '変更', ['class'=>'btn add']) }}
			{{ Form::close() }}
			<br>

		</div>
	</div>
</div>

@endsection