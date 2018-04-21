@extends('layouts.auth')

@section('title', 'Page Not Found')

@section('content')
<div class="text-center font-white">
	<h1 style="font-size:100px;">404</h1> <br>
	<h2>Halaman yang Anda cari tidak ditemukan</h2>
	<br><br>
	<a href="{{url('home')}}" class="btn btn-lg btn-danger">TAKE ME HOME</a>
	<br><br><br>
</div>
@endsection
