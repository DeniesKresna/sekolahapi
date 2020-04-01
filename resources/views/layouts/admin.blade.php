<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SI - PERMATA | ADMIN PAGE">
    <meta name="author" content="SI - PERMATA">
    <title>SI - PERMATA | ADMIN PAGE</title>
    <!-- Favicons -->
    <link href="{{asset("public/gallery/logo.png")}}" rel="icon">
    <!-- CSS -->
    
    <link href="{{asset('public/theme/sb-admin/vendor/bootstrap/css/bootstrap.min.css')}}?<?php echo time(); ?>" rel="stylesheet">

    <link href="{{asset('public/theme/sb-admin/vendor/metisMenu/metisMenu.min.css')}}?<?php echo time(); ?>" rel="stylesheet">
    <link href="{{asset('public/theme/sb-admin/dist/css/sb-admin-2.css')}}?<?php echo time(); ?>" rel="stylesheet">
    <link href="{{asset('public/theme/sb-admin/vendor/morrisjs/morris.css')}}?<?php echo time(); ?>" rel="stylesheet">
    <link href="{{asset('public/theme/sb-admin/vendor/font-awesome/css/font-awesome.min.css')}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">

    <link href="{{asset('public/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css')}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link ref="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" />

    <link href="{{asset('public/chart/css/highcharts.css')}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link href="{{asset('public/css/custom.css')}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js?<?php echo time(); ?>"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js?<?php echo time(); ?>"></script>
    <![endif]-->

    <!-- DataTables CSS -->
    <link href="{{asset('public/theme/sb-admin/vendor/datatables-plugins/dataTables.bootstrap.css')}}?<?php echo time(); ?>" rel="stylesheet">
    <link href="{{asset('public/theme/sb-admin/vendor/datatables-responsive/dataTables.responsive.css')}}?<?php echo time(); ?>" rel="stylesheet">
    <!--Javascript-->
    <script src="{{asset('public/theme/sb-admin/vendor/jquery/jquery.min.js')}}?<?php echo time(); ?>"></script>
    <script src="{{asset('public/theme/sb-admin/vendor/bootstrap/js/bootstrap.min.js')}}?<?php echo time(); ?>"></script>
    <script src="{{asset('public/theme/sb-admin/vendor/metisMenu/metisMenu.min.js')}}?<?php echo time(); ?>"></script>
    <script src="{{asset('public/theme/sb-admin/vendor/datatables/js/jquery.dataTables.min.js')}}?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <script src="{{asset('public/theme/sb-admin/dist/js/sb-admin-2.js')}}?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="{{asset('public/js/popper.min.js')}}?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="{{asset('public/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js')}}?<?php echo time(); ?>"></script>
    <script type="text/javascript" src="{{asset('public/js/bootstrap-notify.js')}}?<?php echo time(); ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPb1wlmgGWAb8peh0CXZyMbysA9qMqlB4"></script>
    {{--<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>--}}
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css?<?php echo time(); ?>" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js?<?php echo time(); ?>"></script>

    <!-- Charts JavaScript -->
    <script src="{{asset('public/chart/js/highcharts.js')}}"></script>
    <!-- Custom Theme JavaScript -->
    <!-- Theme included stylesheets -->
    <script src="{{asset("public/js/custom.js")}}"></script>

</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('admin.home')}}">{{ strtoupper(Auth::user()->roles() ? Auth::user()->roles()->first()->name : "User") }} | SI - PERMATA</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                        {{--<i class="fa fa-envelope fa-fw"></i><i class="fa fa-caret-down"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu dropdown-messages">--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<strong>John Smith</strong>--}}
                                    {{--<span class="pull-right text-muted"><em>Yesterday</em></span>--}}
                                {{--</div>--}}
                                {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<strong>John Smith</strong>--}}
                                    {{--<span class="pull-right text-muted"><em>Yesterday</em></span>--}}
                                {{--</div>--}}
                                {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<strong>John Smith</strong>--}}
                                    {{--<span class="pull-right text-muted"><em>Yesterday</em></span>--}}
                                {{--</div>--}}
                                {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a class="text-center" href="#">--}}
                                {{--<strong>Read All Messages</strong>--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.dropdown-messages -->--}}
                {{--</li>--}}
                {{--<!-- /.dropdown -->--}}
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                        {{--<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu dropdown-alerts">--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                                    {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
                                    {{--<span class="pull-right text-muted small">12 minutes ago</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-envelope fa-fw"></i> Message Sent--}}
                                    {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-tasks fa-fw"></i> New Task--}}
                                    {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
                                    {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a class="text-center" href="#">--}}
                                {{--<strong>See All Alerts</strong>--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.dropdown-alerts -->--}}
                {{--</li>--}}
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-fw"></i> Logout, {{{ isset(Auth::user()->email) ? Auth::user()->email : "User" }}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li><a href="{{route("admin.home")}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                        <li>
                            <a href="#"><i class="fa fa-list fa-fw"></i> Pamflet<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{route("admin.carousel")}}"><i class="fa fa-list"></i> Carousel</a></li>
                            </ul>
                        </li>
                        @role(['superadmin'])
                        <li><a href="{{route("admin.user")}}"><i class="fa fa-user-secret fa-fw"></i> User</a></li>
                        @endrole
                        @role(['superadmin','useradmin'])
                        <li><a href="{{route("admin.submission")}}"><i class="fa fa-list"></i> Pengajuan</a></li>
                        @endrole
                        @role(['superadmin'])
                        <li><a href="{{route("admin.research_field")}}"><i class="fa fa-list-alt fa-fw"></i> Bidang Penelitian</a></li>
                        <li><a href="{{route("admin.office")}}"><i class="fa fa-hotel fa-fw"></i> Kantor Dinas</a></li>
                        <li><a href="{{route("admin.setting")}}"><i class="fa fa-gear fa-fw"></i> Pengaturan</a></li>
                        @endrole
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            @yield('content')
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
        $('#description').summernote();
        $(".photo").change(function(e) {
            console.log(this.files[0].size);
            if(this.files[0].size > 3000000){
                $(this).val(null);
                $('#blah').attr('src', null);
                alert("Ukuran File Terlalu Besar (Max. 3MB)")
            }
            printImage(this)
        });



    </script>

</body>
</html>
