@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="search-group">
			{{ Form::open(['method'=>'get', 'url' => route('top'), 'class' => 'search-form' ]) }} 
				{{ Form::text('search', '', ['placeholder' => '検索']) }}
				<div class="tab-group">
					<label class="tab"> {{Form::checkbox('is_close', '0', empty($is_close), [])}} 募集中</label>
					<label class="tab"> {{Form::checkbox('is_close', '1', !empty($is_close), [])}} 募集終了</label>
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