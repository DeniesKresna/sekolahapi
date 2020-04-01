@extends('layouts.guest')

@section('content')
    <style type="text/css">
        .bg-grey{
            background-color: #f5f5f5;
        }
        .bg-white{
            background-color: #fff;
        }
        .career-detail{
            margin-top: 20px;
        }
        .job-desc{
            padding: 20px 60px;
            text-align: justify;
            border-right: 1px solid #f5f5f5;
        }
        .job-app{
            padding: 20px 35px 20px 20px;
        }
        .job-app h2{
            text-align: center;
            color: orange;
        }
        .fa-money{
            color: green;
            font-size: 20px;
        }
        .fa-clock-o{
            color: magenta;
            font-size: 20px;
        }
        .fa-medkit{
            color: red;
            font-size: 20px;
        }
        .btn-apply{
            background-color: orange;
            color: white;
            border-color: orange;
        }
        .btn-apply:hover{
            opacity: 0.7;
            color: white;
        }
        .btn-other{
            text-decoration: none;
            color: orange;
            border-color: white;
        }
        .btn-other:hover{
            color: orange;
            border-color: lightgrey;
        }
    </style>
    <div class="container">
        <div class="career-detail bg-white">
            <div class="row">
                <div class="col-sm-9 job-desc">
                    <h2><b>{{$job_vacancy->title}}</b></h2>
                    <?php echo detect_newline($job_vacancy->description)?>
                </div>
                <div class="col-sm-3 job-app">
                    <h2>Job Title</h2>
                    <p><i class="fa fa-money"></i>&emsp;{{$job_vacancy->salaries}}</p>
                    <p><i class="fa fa-clock-o"></i>&emsp;{{$job_vacancy->working_time}}</p>
                    <p><i class="fa fa-medkit"></i>&emsp; Jaminan Kesehatan</p>
                    <br>
                    <p><a href="#" class="btn btn-block btn-apply btn-md">Lamar Sekarang</a></p>
                    <p><a href="{{route("user.job_vacancy")}}" class="btn btn-block btn-other btn-md btn-default">Lowongan Posisi Lain</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection
