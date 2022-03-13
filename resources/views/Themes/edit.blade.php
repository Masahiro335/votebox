@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			{{ Form::open(['url' => route('Users.edit') ]) }} 
			<label class="form-title">開始日時</label>
			<div class="form-item">
				{{ Form::date('start_date_time', date('Y-m-d'), ['min' => date('Y-m-d')]) }}
				{{ Form::time('start_time', date('H:i'), []) }}
			</div>
			<?php if( $errors->has('start_date_time') ){ ?>
				<?php foreach($errors->get('start_date_time') as $errorMessage){ ?>
					<div class="error-message">{{ $errorMessage }}</div>
				<?php } ?>
			<?php } ?>

			<label class="form-title">終了日時</label>
			<div class="form-item">
				{{ Form::date('end_date_time', date('Y-m-d',strtotime('+3 day')), ['min' => date('Y-m-d')]) }}
				{{ Form::time('end_time', date('H:i'), []) }}
			</div>
			<?php if( $errors->has('end_date_time') ){ ?>
				<?php foreach($errors->get('end_date_time') as $errorMessage){ ?>
					<div class="error-message">{{ $errorMessage }}</div>
				<?php } ?>
			<?php } ?>

			<label class="form-title">お題</label>
			<div class="form-item">
				{{ Form::textarea('body', '', ['placeholder' => 'お題を記入してください。']) }}
			</div>
			<?php if( $errors->has('body') ){ ?>
				<?php foreach($errors->get('body') as $errorMessage){ ?>
					<div class="error-message">{{ $errorMessage }}</div>
				<?php } ?>
			<?php } ?>

			<label class="form-title">投票項目</label>
			<div class="vote-item-group">
				<?php if( empty(session()->get('_old_input.vote-items')) ){ ?>
					<div class="vote-item">
						{{ Form::text('vote-items[]', '', []) }}
					</div>
				<?php }else{ ?>
					<?php foreach(session()->get('_old_input.vote-items') as $key => $voteItem){ ?>
						<div class="vote-item">
							{{ Form::text('vote-items[]', '', []) }}
							<?php if( $errors->has('vote-items.'.$key) ){ ?>
								<?php foreach($errors->get('vote-items.'.$key) as $errorMessage){ ?>
									<div class="error-message">{{ $errorMessage }}</div>
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
				<div class="vote-item-add" v-for="(text,index) in items">
					{{ Form::text('vote-items[]', '', []) }}
				</div>
			</div>
			<div class="vote-edit">
				<i class="fas fa-plus-square" @click="add" v-if="vote_item_count + items.length < 4"></i>
				<i class="fas fa-minus-square" @click="del" v-if="vote_item_count + items.length > 1"></i>
			</div>

			<label class="form-title">有効</label>
			<div class="form-item">
				{{ Form::checkbox('is_invalid', '', []) }}
			</div>
			<?php if( $errors->has('is_invalid') ){ ?>
				<?php foreach($errors->get('is_invalid') as $errorMessage){ ?>
					<div class="error-message">{{ $errorMessage }}</div>
				<?php } ?>
			<?php } ?>

			{{ Form::submit('登録', ['class'=>'btn add']) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

<script>
$(function(){
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
});
</script>
@endsection