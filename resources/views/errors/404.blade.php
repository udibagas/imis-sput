@extends('layouts.login')

@section('title', 'Page Not Found')

@section('content')
<div class="text-center font-white" style="margin-top:150px;">
	<h1 style="font-size:100px;">404</h1> <br>
	<h2>Halaman yang Anda cari tidak ditemukan</h2>
	<br> <br> <br>
	<a href="{{url('home')}}" class="btn btn-lg btn-danger">TAKE ME HOME</a>
</div>
@endsection
