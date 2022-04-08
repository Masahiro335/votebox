@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			{{ Form::open(['url' => route('Themes.edit') ]) }} 
			<label class="form-title required">開始日時</label>
			<div class="form-item">
				{{ Form::date('start_date_time', empty($entTheme) ? date('Y-m-d',strtotime('+3 day')) : date('Y-m-d', strtotime($entTheme->start_date_time)), ['min' => date('Y-m-d'), 'required' => true]) }}
				{{ Form::time('start_time', empty($entTheme) ? date('H:i') : date('H:i', strtotime($entTheme->start_date_time)), []) }}
			</div>
			@if( $errors->has('start_date_time') )
				@foreach($errors->get('start_date_time') as $errorMessage)
					<div class="error-message">{{ $errorMessage }}</div>
				@endforeach
			@endif

			<label class="form-title required">終了日時</label>
			<div class="form-item">
				{{ Form::date('end_date_time', empty($entTheme) ? date('Y-m-d',strtotime('+3 day')) : date('Y-m-d', strtotime($entTheme->end_date_time)), ['min' => date('Y-m-d'), 'required' => true]) }}
				{{ Form::time('end_time', empty($entTheme) ? date('H:i') : date('H:i', strtotime($entTheme->end_date_time)), []) }}
			</div>
			@if( $errors->has('end_date_time') )
				@foreach($errors->get('end_date_time') as $errorMessage)
					<div class="error-message">{{ $errorMessage }}</div>
				@endforeach
			@endif

			<label class="form-title required">お題</label>
			<div class="form-item">
				{{ Form::textarea('body', empty($entTheme) ? '' : $entTheme->body, ['placeholder' => 'お題を記入してください。', 'required' => true]) }}
			</div>
			@if( $errors->has('body') )
				@foreach($errors->get('body') as $errorMessage)
					<div class="error-message">{{ $errorMessage }}</div>
				@endforeach
			@endif

			<label class="form-title required">投票項目</label>
			<div class="vote-item-group">
				<?php //フォーム送信後 ?>
				@if( empty(session()->get('_old_input.vote-items')) == false )
					@foreach(session()->get('_old_input.vote-items') as $key => $voteItem)
						<div class="vote-item">
							{{ Form::text('vote-items[]', '', ['required' => true]) }}
							@if( $errors->has('vote-items.'.$key) )
								@foreach($errors->get('vote-items.'.$key) as $errorMessage)
									<div class="error-message">{{ $errorMessage }}</div>
								@endforeach
							@endif
						</div>
					@endforeach
				<?php //編集 ?>
				@elseif( empty($entTheme) == false )
					@foreach($entTheme->votes as $key => $entVote)
						<div class="vote-item">
							{{ Form::text('vote-items[]', $entVote->name, ['required' => true]) }}
						</div>
					@endforeach
				<?php //新規投稿 ?>
				@else
					<div class="vote-item">
						{{ Form::text('vote-items[]', '', ['required' => true]) }}
					</div>
					<div class="vote-item">
						{{ Form::text('vote-items[]', '', ['required' => true]) }}
					</div>
				@endif
				<div class="vote-item-add" v-for="(text,index) in items">
					{{ Form::text('vote-items[]', '', ['required' => true]) }}
				</div>
			</div>
			<div class="vote-edit">
				<i class="fas fa-plus-square" @click="add" v-if="vote_item_count + items.length < 4"></i>
				<i class="fas fa-minus-square" @click="del" v-if="vote_item_count + items.length > 2"></i>
			</div>

			<div class="form-item">
				<label class="form-title">
					{{Form::checkbox('is_invalid', '1', empty($entTheme) ? true : !$entTheme->is_invalid, [])}}
					有効
				</label>
			</div>
			@if( $errors->has('is_invalid') )
				@foreach($errors->get('is_invalid') as $errorMessage)
					<div class="error-message">{{ $errorMessage }}</div>
				@endforeach
			@endif

			{{ Form::submit('登録', ['class'=>'btn add']) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

<script>
new Vue({
	el: '.item',
	data: {
		items: [],
		//デフォルトの投票項目の数
		vote_item_count: $('.vote-item input[name^="vote-items"]').length,
	},
	methods: {
		add: function(){
			this.items.push('').val();
		},
		del: function(){
			//追加したダミーを削除
			if( this.items.length > 0 ){
				this.items.pop();

			//デフォルトの投票項目を削除
			}else{
				$('input[name^="vote-items"]:last').remove();
				this.vote_item_count = this.vote_item_count - 1;
			}

			//エラーメッセージの削除
			if( $('.error-message').length > 0){
				$('.error-message:last').remove();
			}
		},
	}
})
</script>
@endsection