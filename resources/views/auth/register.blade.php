@extends('layouts.login')

@section('content')
<div class="login-pag-inner">
	<div class="animatedParent animateOnce z-index-50">
		<div class="login-container animated growIn slower">
			<div class="login-content">
                <div class="text-center">
                    <img src="{{ asset('img/logo.png')}}">
                </div>
                <br><br>
				<form method="POST" action="{{ route('register') }}">
                    @csrf
					<div class="form-group">
						<input type="text" placeholder="Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
					</div>
					<div class="form-group">
						<input type="text" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
					</div>
					<div class="form-group">
						<input type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
					</div>
					<div class="form-group form-action">
						<button type="submit" class="btn btn-primary btn-block">Daftar</button>
					</div>
					<p class="text-center">Sudah terdaftar? <a href="{{ route('login') }}">Login</a></p>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
