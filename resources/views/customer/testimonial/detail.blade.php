@extends('layouts.guest')

@section('content')
    <style type="text/css">
        .testimonial-desc{font-size:15px;text-transform:capitalize;text-overflow: ellipsis;word-break: break-all;overflow:hidden;white-space: nowrap;margin: 0!important;padding: 0!important;}
    </style>
    <div style="margin-bottom: 100px" >
        <div class="row" style="margin-top: 50px; margin-left: 5%; margin-right: 5%">
            <div class="col-md-9">
                <div class="container-fluid">
                    @if(!empty($testimonial))
                        <h1>{{$testimonial->title}}</h1>
                        <small><i>{{date("d M Y",strtotime($testimonial->created_at))}}</i></small>
                        <hr>
                        <img @if( $testimonial->user && @file_get_contents($testimonial->user->photo)) src="{{upload_dir().($testimonial->user?upload_dir().$testimonial->user->photo:"N/A")}}" @else src="{{upload_dir()."/default-photo.jpg"}}" @endif alt="{{$testimonial->user?$testimonial->user->photo:"N/A"}}" class="img-circle pull-left" style="height: 200px;width:200px;margin: 0 10px 10px 0 " >
                        <h3> {{$testimonial->user?$testimonial->user->name:"N/A"}}</h3>
                        {{--Email : {{$testimonial->user?$testimonial->user->email:"N/A"}}<br/>--}}
                        <p style="text-align:justify;text-justify:inter-word;">
                            <?php echo detect_newline($testimonial->description)?>
                        </p>
                    @else
                        <?php echo print_status('danger', "Data doesn't exists !!!"); ?>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
