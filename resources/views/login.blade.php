@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">LOGIN</div>
			{{ Form::open(['url' => route('Login') ]) }} 
			<label class="form-title">名前</label>
			<div class="form-item">
				{{ Form::text('name', '', ['placeholder' => '']) }}
			</div>

			<label class="form-title">パスワード</label>
			<div class="form-item">
				{{ Form::password('password') }}
			</div>

			{{ Form::submit('ログイン', ['class'=>'btn add']) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

@endsection