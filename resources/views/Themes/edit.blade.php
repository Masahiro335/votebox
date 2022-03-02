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
				<?= var_dump($getData) ?>
				<?php if( empty($getData) ){ ?>
					<div class="vote-item">
						{{ Form::text('vote-items[]', '', ['v-model' => 'texts[index]']) }}
					</div>
				<?php }else{ ?>
					<?php foreach($getData['vote-items'] as $key => $voteItem){ ?>
						<div class="vote-item">
							{{ Form::text('vote-items[]', '', ['v-model' => 'texts[index]']) }}
						</div>
						<?php if( $errors->has('vote-items.*')[$key] ){ ?>
							<?php foreach($errors->get('vote-items.*')[$key] as $errorMessage){ ?>
								<div class="error-message">{{ $errorMessage }}</div>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<div class="vote-item" v-for="(text,index) in texts">
					{{ Form::text('vote-items[]', '', ['v-model' => 'texts[index]']) }}
				</div>
			</div>
			<div class="vote-edit">
				<i class="fas fa-plus-square" @click="add" v-if="texts.length < 4"></i>
				<i class="fas fa-minus-square" @click="del" v-if="texts.length > 0"></i>
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
		texts: [],
	},
    methods: {
        add: function(){
			if( this.texts.length > 3 ){
				alert('これ以上項目は増やせません');
				return false;
			}
			this.texts.push('');
        },
        del: function(){
			this.texts.pop();
        },
    }
})
</script>
@endsection