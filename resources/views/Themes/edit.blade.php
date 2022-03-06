@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item">
			{{ Form::open(['url' => '/themes/edit']) }} 
			<label class="title">お題</label>
			<div class="body">
				{{ Form::textarea('body', '', ['placeholder' => 'お題を記入してください。']) }}
			</div>
			<?php if( $errors->has('body') ){ ?>
				<?php foreach($errors->get('body') as $errorMessage){ ?>
					<div class="error-message">{{ $errorMessage }}</div>
				<?php } ?>
			<?php } ?>
			<label class="title">投票項目</label>
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
				<div class="vote-item-dummy" v-for="(text,index) in items">
					{{ Form::text('vote-items[]', '', []) }}
				</div>
			</div>
			<div class="vote-edit">
				<i class="fas fa-plus-square" @click="add" v-if="vote_item_count + items.length < 4"></i>
				<i class="fas fa-minus-square" @click="del" v-if="vote_item_count + items.length > 1"></i>
			</div>
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
			if( $('.error-message').length > 0){
				$('.error-message:last').remove();
			}
        },
    }
})
});
</script>
@endsection