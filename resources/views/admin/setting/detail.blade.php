@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>{{$data->name}}</h1>
                    <small><a href="{{route("admin.home")}}">Dashboard</a> > <a href="{{route("admin.setting")}}">Settings</a> > {{$data->name}}</small>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Setting
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="container-fluid text-center">
                        <?php echo print_flashdata()?>
                    </div>
                    <form action="{{route('admin.setting.update')}}" method="post">
                        <div class="form-group" hidden>
                            <label class="control-label col-sm-12" for="id">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="id" id="id" value="{{$data->id}}" placeholder="Nama Instansi" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Key (Sekali input)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" disabled id="key" value="{{$data->key}}" placeholder="Kata Kunci" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}" placeholder="Nama" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="content">Konten</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="content" id="content" placeholder="Konten" required>{{$data->content}}</textarea><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <br/><input class="form-control btn btn-primary" type="submit" value="Masukan Data"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection