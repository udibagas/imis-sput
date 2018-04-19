<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='shortcut icon' type='image/x-icon' href='{{asset('img/logo.ng')}}' />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'IMIS - SPUT') }}</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700,900">
<link href="{{ asset('css/theme.css') }}" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.min.js') }}"></script>
      <script src="{{ asset('js/respond.min.js') }}"></script>
<![endif]-->

</head>
<body>

<div class="page-container" id="app">

  <div class="page-sidebar">

		<header class="site-header">
		  <div class="site-logo"><a href="{{url('/')}}"><img src="{{ asset('img/logo.png') }}" alt="Mouldifi" title="Mouldifi"></a></div>
		  <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		  <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
		</header>

		@include('layouts._sidebar')
  </div>
  <div class="main-container">
    <div class="main-header row">
        <div class="col-md-12">
            <ul class="user-info pull-right">
                <li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><img width="44" class="img-circle avatar" alt="" src="{{asset('img/user.png')}}">{{auth()->user()->name}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        <li><a href="#/"><i class="icon-user"></i>My profile</a></li>
                        <li><a href="#/"><i class="icon-mail"></i>Messages</a></li>
                        <li><a href="#"><i class="icon-clipboard"></i>Tasks</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-cog"></i>Account settings</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-logout"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <!-- <div class="clearfix">

        </div> -->
    </div>
	<div class="main-content">
		<!-- <h1 class="page-title">Page Title</h1>
		<ol class="breadcrumb breadcrumb-2">
			<li><a href="index.html"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="login.html">Various Screens</a></li>
			<li class="active"><strong>Blank Page</strong></li>
		</ol> -->
		<div class="row">
			<div class="col-lg-12">
			    @yield('content')
			</div>
		</div>

		<footer class="animatedParent animateOnce z-index-10">
			<div class="footer-main animated fadeInUp slow">&copy; {{ date('Y') }} <strong>KPP - SPUT</strong></div>
		</footer>

	  </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>

<script type="text/javascript">
    $('ul.nav > li.active').parent().parent().addClass('active');
    $(document).ready(function() {
        // $('select').css('width', '100%').select2();
        $('.datetime-picker').datetimepicker();
    });
</script>

@stack('scripts')

<script src="{{ asset('js/functions.js') }}"></script>

</body>
</html>
