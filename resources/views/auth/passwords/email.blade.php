@extends('layouts.auth')

@section('content')
    <div  class="bg-darkgrey" style="height: 100vh">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 text-center" id="register">
                    <img src="{{asset("public/gallery/material/web-branding-400.png")}}" width="40%">
                    <div class="bg-white" id="registerBox">
                        <h1>SI-PERMATA</h1>
                        <h3>Reset Password</h3><br>
                        <form method="POST" action="{{ route('password.email') }}">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
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
                            <div class="form-group text-center">
          						<button type="submit" class="btn btn-success btn-block"><b>Kirim Link Reset</b></button><br/>
                                <a href="{{route("welcome")}}"><button type="button" class="btn btn-default btn-block"><b>Cancel</b></button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
