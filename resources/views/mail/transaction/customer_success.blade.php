<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .btn-green{background-color: #69BB70;border: 1px solid #69BB70;color: #fff;transition: .2s ease;}
        .btn-green:hover{opacity: .7;transition: .2s ease;cursor: pointer;}
        .btn-white{background-color: #fff;color: #69BB70;transition: .2s ease;}
        .btn-white:hover{opacity: .7;transition: .2s ease;cursor: pointer;}
        #emailMsg{font-family: 'Roboto', sans-serif;}
        #emailMsg h1{text-align: center;color: #F8B118;font-size:28px;}
        #emailMsg h2{text-align: center;font-size:36px;}
        #emailMsg a{text-decoration: none;}
    </style>
    <title>Selamat! Pengajuan Diterima</title> <!-- email subject then -->
</head>
<body>
<div id="emailMsg">
    <h1>Si-Permata</h1>
    <h2>Selamat!</h2>
    <p>Pengajuan riset Anda dengan,</p>
    <table>
        <tr>
            <td>Pengaju</td>
            <td>:</td>
            <td>{{$data->user->name}}</td>
        </tr>
        <tr>
            <td>ID Pengajuan</td>
            <td>:</td>
            <td>{{$data->id}}</td>
        </tr>
        <tr>
            <td>Judul Penelitian</td>
            <td>:</td>
            <td>{{$data->title}}</td>
        </tr>
    </table>

    <p>Telah memenuhi persyaratan dan selesai diproses. Silahkan datang ke kantor Bakesbangpol Kota Madiun yang beralamat di <strong><a class="btn-white" href="https://goo.gl/maps/kteR4sFVUE5VLmUa6" data-target="_blank"> Jl. D. I. Pandjaitan No. 17 Kota Madiun</a></strong> untuk mengambil berkas.</p>
    <p style="text-align: center;margin: 100px;"><a href="{{route("submission")}}"><button class="btn-green" style="padding: 20px;border-radius: 5px;">Lihat Detail Pengajuan</button></a></p> <!-- link to submission-list -->
    <div style="text-align:center;">
        <img src="{{asset("public/gallery/material/web-branding-400.png")}}" width="120px"> <!-- from bahan_web.rar -->
        <p><small>Si-Permata - 2019</small></p>
    </div>
</div>
</body>
</html>