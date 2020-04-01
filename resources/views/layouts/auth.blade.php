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


    <!-- Custom Theme JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="{{asset("public/js/custom.js")}}?<?php echo time(); ?>"></script>
</head>
<body>
<div class="content-data">
    @yield('content')
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

<script>
    // navbar change on scroll
    $(window).scroll(function(){
        $('nav').toggleClass('scrolled', $(this).scrollTop()>50);
    });

    $(document).ready(function(){
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

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
