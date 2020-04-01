@extends('layouts.auth')

@section('content')
    <div class="login-bg">
        <div class="row login">
            <div class="col-sm-6">
                <div class="login-head text-center">
                    <img src="{{asset("public/gallery/material/web-branding-400.png")}}" width="100%">
                    <h1>SI-PERMATA</h1>
                    <p>Sistem Informasi Pengajuan Rekomendasi Izin Penelitian Madiun Kota</p>
                </div>
            </div>
            <div class="col-sm-6 no-padding">
                <div class="login-box">
                    <h2>Login</h2>
                    <div class="login-form">
                        <form action="{{route("login")}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Alamat Email:</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Password:</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-lg btn-green">Login</button>
                            <a href="{{route("register")}}"><button type="button" class="btn btn-block btn-lg btn-white">Belum punya akun?</button></a>
                            <a href="{{URL::to('/')}}/password/reset"><button type="button" class="btn btn-block btn-lg btn-white">Lupa password?</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
