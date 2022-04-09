@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<div class="search-group">
			{{ Form::open(['method'=>'get', 'url' => empty($is_mypage) ? route('top') : route('mypage.top'), 'class' => 'search-form' ]) }} 
				{{ Form::text('search', $search, ['placeholder' => '検索']) }}</br>
				{{ Form::select('sort', App\Models\Theme::SORT,['value' => $sort]) }}</br>
				<div class="tab-group">
					<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['ACTIVE'], $type_id == App\Models\Theme::TYPE['ACTIVE'], [])}} 募集中</label>
					<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['CLOSE'], $type_id == App\Models\Theme::TYPE['CLOSE'], [])}} 募集終了</label>
					@if( empty($is_mypage) == false )
						<label class="tab"> {{Form::checkbox('type_id', App\Models\Theme::TYPE['PLAN'], $type_id == App\Models\Theme::TYPE['PLAN'], [])}} 募集予定</label>
					@endif
				</div>
			{{ Form::close() }}
		</div>
		@if( $queryThemes->isEmpty() == false )
			@foreach($queryThemes as $entTheme)
				<div class="item{{ empty($entTheme->is_invalid) ? '' : ' invalid' }}">
					{{ empty($entTheme->is_invalid) ? '' : '無効' }}
					@if( $type_id == App\Models\Theme::TYPE['ACTIVE'] )
						<?php $voteLeftDay = $entTheme->voteLeftDay() ?>
						<div class="period">
							<span <?= !empty(strpos($voteLeftDay, '時間')) ? 'style="color:#f9141a;"' : ''  ?>>あと{{ $voteLeftDay }}で終了</span></br>
							{{ date('n月j日 G時i分', strtotime($entTheme->start_date_time)).' 〜 '.date('n月j日 G時i分', strtotime($entTheme->end_date_time)) }}
						</div>
					@else
						<div class="period">
							{{ date('n月j日 G時i分', strtotime($entTheme->start_date_time)).' 〜 '.date('n月j日 G時i分', strtotime($entTheme->end_date_time)) }}
						</div>
					@endif

					<div class="name">{{ $entTheme->user->name }}</div>
					<div class="body">
						<?= nl2br(htmlspecialchars($entTheme->body)) ?>
					</div>
				
					@if( empty($Auth) )
						<div class="help-text">※投票結果をご覧になりたい場合は<a href="{{ route('login') }}" style="color:blue;">ログイン</a>して下さい。</div>
					@elseif( $type_id == App\Models\Theme::TYPE['PLAN'] )
						投票名
						<div class="vote-group">
							<?php foreach($entTheme->votes as $entVote){?>
								<div class="vote-name">
									{{ $entVote->name }}
								</div>
							<?php } ?>
						</div>
					@else
						<graph-component 
							:theme_id = "{{ $entTheme->id }}" 
							:auth_id = "{{  $Auth['id']; }}"
							:is_vote = "{{ $entTheme->isVote( $Auth ) ? 1 : 0 }}"
						></graph-component>
					@endif

					@if( empty($is_mypage) == false && $entTheme->isEdit() )
						<a href="{{ route('Themes.edit', ['id' => $entTheme->id])  }}" class="btn edit">変更</a>
						<a href="" class="btn delete">削除</a>
					@endif
				</div>
			@endforeach
		@endif
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