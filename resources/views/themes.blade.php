@if( $queryThemes->isEmpty() == false )
	@foreach($queryThemes as $entTheme)
		<div class="item{{ empty($entTheme->is_invalid) ? '' : ' invalid' }}">
			{{ empty($entTheme->is_invalid) ? '' : '無効状態' }}
			@if( $data['type_id'] == App\Models\Theme::TYPE['ACTIVE'] )
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
			@elseif( $data['type_id'] == App\Models\Theme::TYPE['PLAN'] )
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
				@if( empty($entTheme->is_invalid) )
					<a href="{{ route('Themes.invalid', ['id' => $entTheme->id])  }}" class="btn invalid">無効</a>
				@endif
			@endif
		</div>
	@endforeach

	<?php //ページング処理 ?>
	<paging-component
		:is_mypage = 0
		<?= empty($data['search']) ? null : ':search = '.$data['search'] ?>
		<?= empty($data['sort']) ? null : ':sort = '.$data['sort'] ?>
		<?= empty($data['type_id']) ? null : ':type_id = '.$data['type_id'] ?>
	></paging-component>

@else
	<div class="item">
		該当する投稿がありません。
	</div>
@endif