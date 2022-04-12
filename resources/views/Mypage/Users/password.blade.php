@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			<div class="title">パスワード確認</div>
			{{ Form::open(['url' => route('Users.password') ]) }} 
				<label class="form-title required">パスワード</label>
				<div class="form-item">
					{{ Form::password('password', ['required' => true]) }}
				</div>
				@if( $errors->has('password') )
					@foreach($errors->get('password') as $errorMessage)
						<div class="error-message">{{ $errorMessage }}</div>
					@endforeach
				@endif

				{{ Form::submit('確認', ['class'=>'btn add']) }}
			{{ Form::close() }}
			</br>

		</div>
	</div>
</div>

@endsection