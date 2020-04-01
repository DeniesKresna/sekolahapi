@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Carousel</h1>
                <small><a href="{{route("admin.home")}}">Dashboard</a> > Carousel</small>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Carousel
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        @if(!empty(sizeof($carousels)))
                            @foreach($carousels as $carousel)
                                <div class="col-sm-4">
                                    <div class="thumbnail">
                                        <img src="{{upload_dir().$carousel->photo}}" alt="{{upload_dir().$carousel->photo}}" title="{{upload_dir().$carousel->photo}}" style="width:100%;height: 120px">
                                        <div class="caption text-center">
                                            <div class="btn-group">
                                                @if($carousel->display)
                                                    <a href="{{route("admin.carousel.status",["id"=>$carousel->id,"active"=>0])}}"><button class="btn btn-default"><i class="fa fa-eye-slash"></i> Sembunyi</button></a>
                                                @else
                                                    <a href="{{route("admin.carousel.status",["id"=>$carousel->id,"active"=>1])}}"><button class="btn btn-info"><i class="fa fa-eye"></i> Publish</button></a>
                                                @endif
                                                <a class="confirm-delete" href="{{route("admin.carousel.delete",["id"=>$carousel->id])}}"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="container-fluid">
                                <?php echo print_status("warning","Tidak ada carousel yang ditampilkan") ?>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tambah
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form action="{{route('admin.carousel.add')}}" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="title">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" id="title" placeholder="Judul" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="title">Deskripsi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="description" placeholder="Deskripsi"><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="photo">Foto (Max 3 MB)</label>
                            <div class="col-sm-12">
                                <img id="blah" src="https://assets.estately.net/assets/no_photos/no_photo_lg-55d31feabc996426f1f520cd658be499c4abebbc7a34b17d1b4d7d370bc4f202.png" class="img-responsive" />
                                <input type="file" class="form-control" name="photo" accept="image/*" id="photo" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="form-control btn btn-primary">Masukan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                ordering:false,
                sScrollX: "100%",
                bScrollCollapse: true
            });
            $("#photo").change(function(e) {
                console.log(this.files[0].size);
                if(this.files[0].size > 3000000){
                    $(this).val(null);
                    $('#blah').attr('src', null);
                    alert("Ukuran File Terlalu Besar (Max. 3MB)")
                }
                printImage(this)
            });

        });
    </script>

@endsection
