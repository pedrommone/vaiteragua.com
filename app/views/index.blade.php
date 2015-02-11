<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Vai ter água</title>

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Play" type="text/css">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

		<meta name="viewport" content="width=device-width,initial-scale=1">

		<meta property="og:type" content="website" />
		<meta property="og:url" content="{{ url('/') }}" />
		<meta property="og:description" 
			content="Veja o volume de água dos reservatórios da Região Metropolitana de Belo Horizonte e faça sua parte para dizermos juntos que vai ter água." />
		<meta property="og:locale" content="pt_br" />
		<meta property="og:site_name" content="Vai ter água" />
		<meta property="og:title" content="Vai ter água" />
		<meta property="og:image" content="{{ asset('assets/img/og.png') }}" />
	</head>

	<body>
		<!-- Modal -->
		<div class="modal" id="history" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<h2>Reservatórios nos últimos 30 dias</h2>
					<a href="#close" class="btn-close" aria-hidden="true">×</a>
				</div>

				<div class="modal-body">
					<div id="curve_chart"></div>
				</div>

				<div class="modal-footer">
					<a href="#close" class="btn btn-fechar">Fechar</a>
				</div>
			</div>
		</div>
		<!-- /Modal -->

		<img src="{{ asset('assets/img/vaiteragua.png') }}" class="brand" alt="">
		<p>Se todo mundo colaborar, não vai faltar para ninguém</p>

		<section class="water">
			<div class="mouse-drop">
				<div class="drop">100%</div>
			</div>

			<div class="waves">
				<div class="wave-1"></div>
				<div class="wave-2"></div>
			</div>
		</section>

		<a href="#history" class="btn">Ver histórico</a>
		<br>
		<div class="fb-like" data-href="https://www.facebook.com/vaiteragua?ref=br_tf" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		<div class="ruler"></div>

		<p class="copyright">O vaiteragua.com é um projeto <a href="http://github.com/pedrommone/vaiteragua.com">open-source.</a> Todos os dados apresentados são coletados do site de <a href="http://www.copasatransparente.com.br">transparência da Copasa.</a></p>

		<script> var base_url = "{{ url('/') }}"; </script>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
		<script src="{{ asset('assets/js/main.js') }}"></script>

		@if (App::environment('production'))
			<script src="//d2wy8f7a9ursnm.cloudfront.net/bugsnag-2.min.js" data-apikey="{{ $_ENV['BUGSNAG_KEY'] }}"></script>
		@endif

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=967323029949505&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	</body>
</html>
