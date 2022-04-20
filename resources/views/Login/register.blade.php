@extends('layouts.app')

@section('content')

<div class="wrapper" id="app">
	<div class="content">
		<div class="item">
			<div class="title">ENTRY</div>
			{{ Form::open(['url' => route('register') ]) }} 
				<label class="form-title required">名前</label>
				<div class="form-item">
					{{ Form::text('name', '', ['required' => true]) }}
				</div>
				<ul class="help-text">
					<li>20文字以内で入力して下さい。</li>
					<li>半角英数字のみで記入して下さい。</li>
				</ul>
				<?php if( $errors->has('name') ){ ?>
					<?php foreach($errors->get('name') as $errorMessage){ ?>
						<div class="error-message">{{ $errorMessage }}</div>
					<?php } ?>
				<?php } ?>

				<label class="form-title required">パスワード</label>
				<div class="form-item">
					{{ Form::password('password', ['required' => true]) }}
				</div>
				<ul class="help-text">
					<li>8文字以上で記入して下さい。</li>
					<li>20文字以内で記入して下さい。</li>
					<li>半角英数字のみで記入して下さい。</li>
				</ul>
				<?php if( $errors->has('password') ){ ?>
					<?php foreach($errors->get('password') as $errorMessage){ ?>
						<div class="error-message">{{ $errorMessage }}</div>
					<?php } ?>
				<?php } ?>

				{{ Form::submit('登録', ['class'=>'btn add']) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

@endsection