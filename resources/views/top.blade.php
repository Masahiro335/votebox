@extends('layouts.app')

@section('content')
<div class="wrapper">
	<div class="content" id="app">
		<?php foreach($queryThemes as $entTheme){ ?>
			<div class="item">
				<div class="name">{{ $entTheme->user->name }}</div>
				<div class="body">
					{{ nl2br($entTheme->body) }}
				</div>
				<graph-component></graph-component>
			</div>
		<?php } ?>
	</div>
</div>

@endsection