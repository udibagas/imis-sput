@extends('layouts.login')

@section('content')
<div class="login-container animated growIn slower">
    <div class="login-content">
        <div class="text-center">
            <img src="{{ asset('img/logo.png')}}">
        </div>
        <br><br>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <p class="help-block text-danger"> {{ $errors->first('email') }} </p>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
                @if ($errors->has('password'))
                    <p class="help-block text-danger"> {{ $errors->first('password') }} </p>
                @endif
            </div>
            <div class="form-group">
                 <div class="checkbox checkbox-replace">
                    <input type="checkbox" name="remeber" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remeber">Remeber me</label>
                  </div>
             </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Login</button>
            </div>
            <!-- <p class="text-center"><a href="forgot-password.html">Forgot your password?</a></p> -->
        </form>
    </div>
</div>
@endsection
