@extends('layouts.guest')

@section('content')
    <div class="landing-bg">
        <div class="landing-page">
            <div class="row">
                <div class="col-sm-6">
                    <img src="{{asset("public/gallery/material/web-branding-400.png")}}" width="100%">
                </div>
                <div class="col-sm-6">
                    <div class="container-fluid"><h1>Sistem Informasi Pengajuan<br> Rekomendasi Izin Penelitian<br> Madiun Kota</h1></div>
                </div>
            </div>
        </div>
    </div>
    <div id="aboutUs">
        @if(sizeof($carousels))
            <div id="pamphlet-carousel" class="carousel slide" data-ride="carousel" >
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php $i=0;?>
                    @foreach($carousels as $carousel)
                        <li data-target="#pamphlet-carousel" data-slide-to="{{$i}}" @if($i == 0) class="active" @endif></li>
                        <?php $i++?>
                    @endforeach
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner text-center" role="listbox">
                    <?php $i=0;?>
                    @foreach($carousels as $carousel)
                        <div class="item @if($i == 0) active @endif text-center" style="width: 100%" >
                            <img src="{{upload_dir().$carousel->photo}}" style="height: 500px;width: auto;margin: auto">
                        </div>
                        <?php $i++?>
                    @endforeach
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control hidden" href="#pamphlet-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control hidden" href="#pamphlet-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        @endif
    </div>
    <div id="info">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">Langkah-Langkah Proses Pengajuan</h2>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img src="{{asset("public/gallery/material/how_to_1.jpg")}}" width="100%" height="260px">
                            <h3>1. Pengajuan Online</h3>
                            <p>Pemohon cukup mengakses website SI-PERMATA melakukan registrasi dan mengikuti langkah-langkah pengajuan . Tidak perlu lagi datang ke kantor, pengajuan rekomendasi dapat dilakukan kapanpun dan dimanapun.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img src="{{asset("public/gallery/material/how_to_2.jpg")}}" width="100%" height="260px">
                            <h3>2. Verifikasi Admin</h3>
                            <p>Permohonan yang masuk akan segera ditindaklanjuti oleh admin kami, guna memberikan verifikasi kelengkapan berkas. Berkas yang lengkap akan diterbitkan surat rekomendasinya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img src="{{asset("public/gallery/material/how_to_3.jpg")}}" width="100%" height="260px">
                            <h3>3. Pengambilan Surat Rekom</h3>
                            <p>Apabila Permohonan selesai diproses,Pemohon akan menerima notifikasi untuk  datang ke Kantor Bakesbangpol guna mengambil surat rekomendasi yang sudah selesai.</p>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
