<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IMIS - KPP</title>
<link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/theme.css') }}" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.min.js') }}"></script>
      <script src="{{ asset('js/respond.min.js') }}"></script>
<![endif]-->
</head>

<body class="login-page">

<br><br><br>

<div class="login-pag-inner">
	<div class="animatedParent animateOnce z-index-50">
		<div class="login-container animated growIn slower">
		    <div class="login-content">
				<div class="text-center">
				    <img src="{{asset('img/logo.png')}}">
				</div>
				<br><br>
				@yield('content')
			</div>
		</div>
	</div>
</div>


<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>

</body>
</html>
