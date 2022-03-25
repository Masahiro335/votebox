@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="search-group">
			<?php if( Request::route()->getPrefix() == '/mypage' ){ ?>
				{{ Form::open(['method'=>'get', 'url' => route('mypage.top'), 'class' => 'search-form' ]) }} 
			<?php }else{ ?>
				{{ Form::open(['method'=>'get', 'url' => route('top'), 'class' => 'search-form' ]) }}
			<?php } ?>
				{{ Form::text('search', '', ['placeholder' => '検索']) }}
				<div class="tab-group">
					<label class="tab"> {{Form::checkbox('type_id', '10', $type_id == 10, [])}} 募集中</label>
					<label class="tab"> {{Form::checkbox('type_id', '20', $type_id == 20, [])}} 募集終了</label>
					<?php if( Request::route()->getPrefix() == '/mypage' ){ ?>
						<label class="tab"> {{Form::checkbox('type_id', '30', $type_id == 30, [])}} 募集予定</label>
					<?php } ?>
				</div>
			{{ Form::close() }}
		</div>
		<?php if( $queryThemes->isEmpty() == false ){ ?>
			<?php foreach($queryThemes as $entTheme){ ?>
				<div class="item">
					<div class="name">{{ $entTheme->user->name }}</div>
					<div class="body">
						{{ nl2br($entTheme->body) }}
					</div>
					<graph-component :theme_id="<?= $entTheme->id ?>"></graph-component>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</div>

<script>
$(function(){
	$('label.tab input').parent().css('background-color','#0000');
	$('label.tab input:checked').parent().css('background-color','#f9141a78');

	$('body').on('click', 'label.tab input', function(){ 
		var $this = $(this);
		if( $this.prop('checked') == false ) return false;

		$('label.tab input').prop('checked', false);
		$this.prop('checked', true);

		$('label.tab input').parent().css('background-color','#0000');
		$('label.tab input:checked').parent().css('background-color','#f9141a78');

		$form = $('.search-form');
		$form.submit();
	})
});
</script>	
@endsection