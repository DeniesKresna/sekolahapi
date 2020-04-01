<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SI-PERMATA | Sistem Informasi Pengajuan Rekomendasi Izin Penelitian Madiun Kota">
    <meta name="author" content="SI PERMATA MADIUN">
    <title>SI-PERMATA | Sistem Informasi Pengajuan Rekomendasi Izin Penelitian Madiun Kota</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('public/css/chosen.min.css')}}?<?php echo time(); ?>">
    <link rel="stylesheet" href="{{asset('public/css/jquery.paginate.min.css')}}?<?php echo time(); ?>">
    <link href="{{asset("public/css/custom.css")}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Theme JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="{{asset("public/js/custom.js")}}?<?php echo time(); ?>"></script>
</head>
<body @if(!isset($scrolled)) class="bg-grey" @endif>
<nav class="navbar navbar-def navbar-fixed-top @if(!isset($scrolled)) scrolled @endif" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route("welcome")}}">
                <img src="{{asset("public/gallery/material/city_logo.png")}}" style="width: 35px; margin-top: -12px;">
            </a>
            <p class="navbar-text">SI-PERMATA</p>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route("submission")}}">Pengajuan</a></li>
                <!-- <li><a href="#info">Info Aplikasi</a></li> -->
                <li><a target="_blank" href="{{asset("public/gallery/panduan_si_permata.pdf")}}">Panduan</a></li>
                @if(Auth::user() && Auth::user()->hasRole("customer"))
                    <li><a href="{{route("user.account")}}">Profile</a></li>
                    <li>
                        <a href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" >Log out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @else
                    <li><a href="{{route("login")}}">Login/Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<div id="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <div class="list-account">
                    <!-- while no logged in -->
                    @if(Auth::user() && Auth::user()->hasRole("customer"))
                        <p><a href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" >Log out</a></p>
                        <p><a href="{{route("password.request")}}">Ubah Password</a></p>
                    @else
                        <p><a href="{{route("register")}}">Buat Akun</a></p>
                        <p><a href="{{route("login")}}">Login</a></p>
                        <p><a href="">Lupa Password</a></p>
                    @endif
                    <!--while logged in -->
                    <p><a href="#">Profil Saya</a></p>
                    <p><a href="#">Pengajuan Saya</a></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="list-menu">
                    <p><a href="#">Tentang Kami</a></p>
                    <p><a href="#">Info Aplikasi</a></p>
                    <p><a href="#">Kebijakan</a></p>
                    <p><a href="#">Bantuan</a></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact">
                    <h3>Bakesbangpol Kota Madiun</h3>
                    <p><span class="fa fa-building"></span> Gedung Krida Praja Lt III</p>
                    <p><span class="fa fa-map-marker"></span><a href="https://goo.gl/maps/kteR4sFVUE5VLmUa6" data-target="_blank"> Jl. D. I. Pandjaitan No. 17 Kota Madiun</a></p>
                    <p><span class="fa fa-phone-square"></span> (0351) 462153</p>
                </div>
            </div>
            <div class="col-sm-12 no-padding">
                <div class="copyright text-center"><a href="http://limagangsal.com" target="_blank">Copyright<span class="fa fa-copyright"></span>2019 Pemerintah Kota Madiun. All Rights Reserved</a></div>
            </div>
        </div>
    </div>
</div>

<div id="confirm-success" class="modal fade">
    <div class="modal-dialog modal-confirm modal-sm">
        <div class="modal-content ">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">&#xE876;</i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>Berhasil!</h4>
                <p class="modal-message">Item ini sudah ditambahkan ke Keranjang.</p>
            </div>
        </div>
    </div>
</div>
<div id="loading" class="modal fade">
    <div class="modal-dialog modal-light modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <div class="loader"></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>Mohon Tunggu!</h4>
            </div>
        </div>
    </div>
</div>
<div id="confirm-failed" class="modal fade">
    <div class="modal-dialog modal-failed modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">error</i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>Gagal!</h4>
                <p class="modal-message">Item gagal di tambahkan.</p>
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->
<div class="modal fade loading" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div class="loader-txt">
                    <p>Mohon tunggu beberapa saat.. <br><br><small>Kami sedang memproses perintah anda... #love</small></p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>


    $(".photo").change(function(e) {
        console.log(this.files[0].size);
        if(this.files[0].size > 3000000){
            $(this).val(null);
            $('#blah').attr('src', null);
            alert("Ukuran File Terlalu Besar (Max. 3MB)")
        }
        printImage(this)
    });



    @if(isset($scrolled))
    // navbar change on scroll
    $(window).scroll(function(){
        $('nav').toggleClass('scrolled', $(this).scrollTop()>50);
    });
    @endif
    $(document).ready(function(){
        // Add smooth scrolling to all links
        $("nav a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 600, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });

</script>
</body>

</html>
