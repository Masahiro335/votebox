@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="search-group">
			{{ Form::open(['method'=>'get', 'url' => route('top'), 'class' => 'search-form' ]) }} 
				{{ Form::text('search', '', ['placeholder' => '検索']) }}
				<div class="tab-group">
					<label class="tab"><input type="checkbox" name="is_active" <?= empty($is_close) ? 'checked="checked"' : '' ?>>募集中</label>
					<label class="tab"><input type="checkbox" name="is_close" <?= empty($is_close) ? '' : 'checked="checked"' ?>>募集終了</label>
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
	$('body').on('change', 'label.tab input', function(){ 
		var $this = $(this);
		alert($this.prop('checked'));
		if( $this.prop('checked') == true ){
			$this.parent().css('background-color','#f9141a78');
		}else{
			$this.parent().css('background-color','#0000');
		}
		$form = $('.search-form');
		//$form.submit();
	})
});
</script>	
@endsection