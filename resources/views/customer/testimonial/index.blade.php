@extends('layouts.guest')

@section('content')
    <ol class="breadcrumb" style="margin: 0 0 0 0">
        <li><a href="{{route("welcome")}}">Home</a></li>
        <li class="active">Testimoni</li>
    </ol>
    <hr style="margin: 0 0 20px 0;border: solid 0.5px;color: lightgrey"/>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(sizeof($testimonials) > 0)
                    <div class="row" id="grid">
                        @foreach($testimonials as $testimonial)
                            <div class="col-md-6" style="margin-bottom: 20px">
                                <img src="{{upload_dir().$testimonial->title}}" title="{{$testimonial->title}}" alt="post img" class="pull-left img-responsive " style="height: 80px;width: 80px;margin-right: 20px;border-radius: 10px">
                                <p style="font-size: 10pt"  class="text-wrap-title"><b>{{$testimonial->title}}</b></p>
                                <div class="text-wrap-content"><?php echo $testimonial->description?></div>
                                <a href="{{route("user.testimonial.detail",["id"=>$testimonial->id])}}" class="badge" style="background: orangered;border-radius: 5px !important;">Selengkapnya ></a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel panel-default"  style="padding: 100px 0 100px 0">
                        <div class="panel-body text-center" style="color:lightgrey;">
                            <i class="fa fa-trash" style="font-size: 40pt"></i>
                            <p>Tidak ada testimoni yang ditampilkan.. </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(sizeof($testimonials) >= 8)
            <center style="margin-top: 20px">
                <button class="btn btn-default" onclick="loadMoreData()" id="next"> Lebih Banyak</button>
            </center>
        @endif
    </div>
    <script>
        $('.clicked').on('click', function() {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });

        $(".grid").on("click",".product-grid",function () {
            location.href = $(this).data("product")
        });
        $(".grid").on("click",".product-grid",function () {
            location.href = $(this).data("product")
        });
        var pageNumber = 2;
        function loadMoreData(){
            $.ajax({
                type : 'GET',
                url: "{{url()->full()."?"}}" +"&page="+pageNumber,
                success : function(data){
                    pageNumber +=1;
                    if(data.length == 0){

                    }else{
                        $('#grid').append(data.html);
                    }
                    if (pageNumber > data.last){
                        $('#next').hide();
                    }
                },error: function(data){

                },
            })
        }
        $('[data-toggle="popover"]').popover();

    </script>
@endsection
