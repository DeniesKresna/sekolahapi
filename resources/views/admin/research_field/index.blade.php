@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Bidang Penelitian</h1>
                <small><a href="{{route("admin.home")}}">Dashboard</a> > Bidang Penelitian</small>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Bidang Penelitian
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="mytable">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="table-office">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
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
                    Tambah Setting
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="container-fluid text-center">
                        <?php echo print_flashdata()?>
                    </div>
                    <form action="{{route('admin.research_field.add')}}" method="post">
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="description">Deskripsi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="description" placeholder="Deskripsi" required><br>
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
        var table = $('#table-office').DataTable({
            dom: "Bfrtip",
            paging: true,
            pageLength: 5,
            ajax: function ( data, callback, settings ) {
                try{
                    $.ajax({
                        url: '{{route("admin.research_field.ajax")}}',
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
                    table.ajax.reload()
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
                { data: "description"},
                { data: "id", render : function (data, type, row ) {
                    return "" +
                        "<div class='input-group' >" +
                        "<a class='edit-detail' href='{{route("admin.research_field.detail")}}/"+data+"' style='color: white; text-decoration: none' ><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>"+
                        "<a class='confirm-delete' href='{{route("admin.research_field.delete")}}/"+data+"' style='color: white; text-decoration: none' ><button type='button' class='btn btn-danger btn-sm' class='confirm-delete' ><i class='fa fa-trash'></i></button></a>"+
                        "</div>";
                }}

            ],
            sScrollX: "100%",
            ordering:false,
            bScrollCollapse: true
        });

    </script>

@endsection
