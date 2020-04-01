@extends('layouts.admin')

@section('content')
    <div class="text-center content-home">
        <img src="{{asset("public/gallery/material/city_logo.png")}}" style="width: 100px;">
        <br/><span>Selamat Datang di SI-PERMATA</span>


    </div>
    <style>
        .content-home{
            padding-top: 18%;
            color: grey;

        }
        .content-home span{
            font-size: 20pt;
        }
    </style>
@endsection
