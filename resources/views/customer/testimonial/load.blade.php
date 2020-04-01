@if(sizeof($testimonials) > 0)
    <div class="row" id="next-most-view">
        @foreach($testimonials as $testimonial)
            <div class="col-md-6" style="margin-bottom: 20px">
                <img src="{{upload_dir().$testimonial->photo}}" title="{{$testimonial->title}}" alt="post img" class="pull-left img-responsive " style="height: 80px;width: 80px;margin-right: 20px;border-radius: 10px">
                <p style="font-size: 10pt"  class="text-wrap-title"><b>{{$testimonial->title}}</b></p>
                <div class="text-wrap-content"><?php echo $testimonial->description?></div>
                <a href="{{route("user.testimonial.detail",["id"=>$testimonial->id])}}" class="badge" style="background: orangered;border-radius: 5px !important;">Selengkapnya ></a>
            </div>
        @endforeach
    </div>
@endif
