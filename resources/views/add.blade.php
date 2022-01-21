@extends('layouts.app')

@section('content')

<div class="wrapper">
	<div class="content">
		<div class="item" id="theme">
			{{ Form::open(['url' => '/']) }} 
			<label class="title">お題</label>
			<div class="body">
				{{ Form::textarea('body', '', ['placeholder'=>'テーマを記入してください。']) }}
			</div>
			<label class="title">投稿項目</label>
			<div class="vote-item-group">
				<div class="vote-item">
					{{ Form::text('vote', '', ['name'=>'vote-item', 'v-model' => 'texts[index]']) }}
				</div>
				<div class="vote-item" v-for="(text,index) in texts">
					{{ Form::text('vote', '', ['name'=>'vote-item', 'v-model' => 'texts[index]']) }}
				</div>
			</div>
			<i class="fas fa-plus-square" @click="add" v-if="texts.length < 4"></i>
			<i class="fas fa-minus-square" @click="del" v-if="texts.length > 0"></i>
			{{Form::close()}}
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