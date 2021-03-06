@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">ユーザー名変更</div>
			{{ Form::open(['url' => route('Users.edit') ]) }} 
				<label class="form-title required">名前</label>
				<div class="form-item">
					{{ Form::text('name', $Auth->name, ['required' => true]) }}
				</div>
				<ul class="help-text">
					<li>20文字以内で入力して下さい。</li>
					<li>半角英数字のみで記入して下さい。</li>
				</ul>
				@if( $errors->has('name') )
					@foreach($errors->get('name') as $errorMessage)
						<div class="error-message">{{ $errorMessage }}</div>
					@endforeach
				@endif

				{{ Form::submit(empty($is_mypage) ? 'ログイン' : '変更', ['class'=>'btn add']) }}
			{{ Form::close() }}
			<br>

		</div>
	</div>
</div>

@endsection