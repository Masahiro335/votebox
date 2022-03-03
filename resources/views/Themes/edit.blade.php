@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item" id="theme">
			{{ Form::open(['url' => '/themes/edit']) }} 
			<label class="title">テーマ</label>
			<div class="body">
				{{ Form::textarea('body', '', ['placeholder'=>'テーマを記入してください。']) }}
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
						{{ Form::text('vote-items[0]', '', []) }}
					</div>
				<?php }else{ ?>
					<?php foreach(session()->get('_old_input.vote-items') as $key => $voteItem){ ?>
						<div class="vote-item">
							{{ Form::text('vote-items['.$key.']', '', []) }}
							<?php if( $errors->has('vote-items.'.$key) ){ ?>
								<?php foreach($errors->get('vote-items.'.$key) as $errorMessage){ ?>
									<div class="error-message">{{ $errorMessage }}</div>
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
				<div class="vote-item" v-for="(text,index) in items">
					{{ Form::text('vote-items[]', '', []) }}
				</div>
			</div>
			<div class="vote-edit">
				<i class="fas fa-plus-square" @click="add" v-if="vote_items_count < 4"></i>
				<i class="fas fa-minus-square" @click="del" v-if="vote_items_count > 1"></i>
			</div>
			{{ Form::submit('登録', ['class'=>'btn add']) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

<script>
new Vue({
    el: '#theme',
	data: {
		items: [],
		vote_items_count: $('.vote-item-group input[name^="vote-items"]').length,
	},
    methods: {
        add: function(){
			this.vote_items_count = $('.vote-item-group input[name^="vote-items"]').length;
			if( this.vote_items_count > 3 ){
				alert('これ以上項目は増やせません');
				return false;
			}
			this.items.push('').val();
			this.vote_items_count = this.vote_items_count + 1;
        },
        del: function(){
			 if( !this.items.pop() && this.vote_items_count > 1){
				$('input[name^="vote-items"]:last').remove();
			 }
			this.vote_items_count = this.vote_items_count - 1;
        },
    }
})
</script>
@endsection