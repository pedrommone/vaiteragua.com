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
				var mousedrop = document.querySelector('.mousedrop')
					, drop =  document.querySelector('.drop');
				
				mousedrop.onmousemove = function() {
					drop.style.left = window.event.clientX + 'px';
				};

				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', 'UA-59389995-1', 'auto');
				ga('send', 'pageview');
			</script>
	</body>
</html>
