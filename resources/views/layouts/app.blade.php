<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script src="https://kit.fontawesome.com/cd97f58519.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<title>{{ empty($title) ? 'VOTEBOX' : $title.'|VOTEBOX' }}</title>
	</head>
	<body>
		<header>
			<h1>
				<a href="{{ url('/') }}">VOTEBOX</a>
			</h1>
			<nav class="header-nav">
				<ul>
					<li><a href="#">ENTRY</a></li>
					<li><a href="#">LOGIN</a></li>
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
		<a href="{{ url('themes/edit') }}" class="btn-new">投稿</a>
		@yield('content')
		<footer>
			
		</footer>
	</body>
</html>
