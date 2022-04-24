<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script src="https://kit.fontawesome.com/cd97f58519.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
		<script src="{{ mix('/js/app.js') }}" defer></script>
		<title>{{ empty($title) ? 'VOTEBOX' : $title.'|VOTEBOX' }}</title>
	</head>
	<body>
		<header>
			<h1>
				<a href="{{ route('top') }}" <?= empty($is_mypage) ? 'style="color:#de7b7b;"' : '' ?>>VOTEBOX</a>
			</h1>
			<nav class="header-nav">
				<ul>
					<?php if( empty($Auth) ){ ?>
						<li><a href="{{ route('register') }}">ENTRY</a></li>
						<li><a href="{{ route('login') }}">LOGIN</a></li>
					<?php }else{ ?>
						<li><a href="{{ route('mypage.top') }}" <?= empty($is_mypage) ? '' : 'style="color:#de7b7b;"' ?>>MYPOST</a></li>
						<li><a href="{{ route('menu') }}">MENU</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>
		@if (session('flash_message'))
			<div class="flash-message">
				{{ session('flash_message') }}
			</div>
		@endif
		@if (session('flash_error_message'))
			<div class="flash-message error">
				{{ session('flash_error_message') }}
			</div>
		@endif
		<?php if( empty($Auth) ){ ?>
			<a href="{{ route('login') }}" class="btn-new" onclick="return confirm('ログインをして下さい。')">POST</a>
		<?php }else{ ?>
			<a href="{{ route('Themes.edit') }}" class="btn-new">POST</a>
		<?php } ?>
		@yield('content')
		<footer>
			
		</footer>
		<script>
			$(function(){
				$('body').on('click', '.flash-message', function(){ $(this).hide(); })
			});
		</script>
	</body>
</html>
