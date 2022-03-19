@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
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
@endsection