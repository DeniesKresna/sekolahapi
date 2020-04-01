@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>User</h1>
                <small><a href="{{route("admin.home")}}">Dashboard</a> > User</small>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data User
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="mytable">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="table-data">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Info Kontak</th>
                                <th>Alamat</th>
                                <th>Aktif Sejak</th>
                                <th>Token Login</th>
                                <th width="100">Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tambah User
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form action="{{route('admin.user.add')}}" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="email">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Telepon" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="phone">Telepon</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Telepon" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="address">Alamat</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="address" id="address" placeholder="Alamat" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="role_id">Role</label>
                            <div class="col-sm-12">
                                <select name="role_id" id="role_id" class="form-control" required>
                                    <option value="">-- Pilih Role --</option>
                                    @if(!empty($roles))
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->description}}</option>
                                        @endforeach
                                    @endif
                                </select><br/>
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
    <script>

        var table = $('#table-data').DataTable({
            dom: "Bfrtip",
            paging: true,
            pageLength: 5,
            ajax: function ( data, callback, settings ) {
                try{
                    $.ajax({
                        url: '{{route("admin.user.ajax")}}',
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: "{{csrf_token()}}",
                            records_start: data.start,
                            search: data.search.value,
                            page_size: data.length,
                        },
                        success: function( data, textStatus, jQxhr ){
                            callback({
                                data: data.data,
                                recordsTotal:  data.recordsTotal,
                                recordsFiltered:  data.recordsFiltered
                            });
                        }
                    });
                } catch (e){
                    table_export.ajax.reload()
                }

            },
            processing: true,
            language: {
                loadingRecords: '&nbsp;',
                processing: 'Loading...'
            },
            serverSide: true,
            columns: [
                { data: "name"},
                { data: "phone", render:function (data,type, row) {
                    return row.email+"<br>("+((row.phone != "" && row.phone != null)?row.phone:"Telp tidak ada")+")"
                }},
                { data: "address"},
                { data: "created_at"},
                { data: "token_login"},
                { data: "id", render : function (data, type, row ) {
                        return "" +
                            "<div class='input-group' >" +
                            "<a class='edit-detail' href='{{route("admin.user.detail")}}/"+data+"' style='color: white; text-decoration: none' ><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>"+
                            "</div>";
                    }}
            ],
            sScrollX: "100%",
            ordering:false,
            bScrollCollapse: true
        });
    </script>

@endsection
