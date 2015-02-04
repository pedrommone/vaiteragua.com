<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Vai ter água</title>

	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
		<img src="{{ asset('assets/img/vaiteragua.png') }}" class="brand" alt="">
		<p>Se todo mundo colaborar não vai faltar pra ninguém</p>

		<section class="water">
			<div class="mousedrop">
				<div class="drop">100%</div>
			</div>
			<a href="#" class="btn">Ver por reservatórios</a>
		</section>
		<div class="ruler"></div>

		<script>
				var mousedrop = document.querySelector('.mousedrop'),
						drop =  document.querySelector('.drop');
				
				mousedrop.onmousemove = function() {
					drop.style.left = window.event.clientX + 'px';
				};
		</script>
</body>
</html>
