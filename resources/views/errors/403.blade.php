@extends('layouts.login')

@section('title', 'Access Denied')

@section('content')
<div class="text-center font-white" style="margin-top:150px;">
	<h1 style="font-size:100px;">403</h1> <br>
	<h2>Anda tidak diperkenankan mengakses halaman ini</h2>
	<br> <br> <br>
	<a href="{{url('home')}}" class="btn btn-lg btn-danger">TAKE ME HOME</a>
</div>
@endsection
