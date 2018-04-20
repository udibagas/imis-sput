@extends('layouts.auth')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h2>Lupa password?</h2>
<p>Kami akan mengirimkan link untuk mereset password Anda lewat email.</p>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <input type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Masukkan alamat email Anda">
        @if ($errors->has('email'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <p>Tidak ingat email Anda? <a href="mailto:imis@kpp.go.id">Hubungi Admin</a>.</p>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Kirim link untuk reset password</button>
    </div>
</form>
@endsection
