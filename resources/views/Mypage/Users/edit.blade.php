@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">ユーザー名変更</div>
			{{ Form::open(['url' => route('Users.edit',['id' => $Auth['id']]) ]) }} 
				<label class="form-title required">名前</label>
				<div class="form-item">
					{{ Form::text('name', $Auth['name'], ['required' => true]) }}
				</div>

				{{ Form::submit(empty($is_mypage) ? 'ログイン' : '変更', ['class'=>'btn add']) }}
			{{ Form::close() }}
			</br>

		</div>
	</div>
</div>

@endsection