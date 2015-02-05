<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Vai ter água</title>

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Play" type="text/css">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
	</head>

	<body>
		<img src="{{ asset('assets/img/vaiteragua.png') }}" class="brand" alt="">
		<p>Se todo mundo colaborar não vai faltar pra ninguém</p>

		<section class="water">
			<div class="mouse-drop">
				<div class="drop">100%</div>
			</div>

			<div class="waves">
				<div class="wave-1"></div>
				<div class="wave-2"></div>
			</div>
		</section>

		<a href="#" class="btn">Ver por reservatórios</a>
		<div class="ruler"></div>

		<script> var base_url = "{{ url('/') }}"; </script>
		<script src="{{ asset('assets/js/main.js') }}"></script>
	</body>
</html>
