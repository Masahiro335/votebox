@extends('layouts.app')

@section('content')
<div class="wrapper" id="app">
	<div class="content">
		<div class="search-group">
			{{ Form::open(['method'=>'get', 'url' => empty($is_mypage) ? route('top') : route('mypage.top'), 'class' => 'search-form' ]) }} 
				{{ Form::text('keyWord', empty($data['keyWord']) ? '' : $data['keyWord'], ['placeholder' => '検索']) }}<br>
				@if( $data['type_id'] != App\Models\Theme::TYPE['VOTE'] )
					{{ Form::select('sort', App\Models\Theme::SORT,['value' => $data['sort']]) }}
				@else
					{{ Form::select('sort', App\Models\Theme::VOTE_SORT,['value' => $data['sort']]) }}
				@endif
				<br>
				<div class="tab-group">
					<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['ACTIVE'], $data['type_id'] == App\Models\Theme::TYPE['ACTIVE'], [])}} 募集中</label>
					@if( empty($is_mypage) && empty($Auth) == false )
						<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['VOTE'], $data['type_id'] == App\Models\Theme::TYPE['VOTE'], [])}} 投票済み</label>
					@endif
					<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['CLOSE'], $data['type_id'] == App\Models\Theme::TYPE['CLOSE'], [])}} 募集終了</label>
					@if( empty($is_mypage) == false )
						<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['PLAN'], $data['type_id'] == App\Models\Theme::TYPE['PLAN'], [])}} 募集予定</label>
					@endif
				</div>
			{{ Form::close() }}
		</div>

		@include('element/themes',['queryThemes' => $queryThemes, 'data' => $data])

		<?php //ページング処理 ?>
		<paging-component
			:is_mypage = "{{ empty($is_mypage) ? 0 : 1 }}"
			<?= empty($data['search']) ? null : ':search = '.$data['search'] ?>
			<?= empty($data['sort']) ? null : ':sort = '.$data['sort'] ?>
			<?= empty($data['type_id']) ? null : ':type_id = '.$data['type_id'] ?>
		></paging-component>

	</div>
</div>

<script>
$(function(){
	$('label.tab input').parent().css('background-color','#0000');
	$('label.tab input:checked').parent().css('background-color','#f9141a78');

	//ラベルを選択
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

	//ソート選択
	$('body').on('change', 'select[name="sort"]', function(){ 
		$form = $('.search-form');
		$form.submit();
	})
});
</script>	
@endsection