@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Setting</h1>
                <small><a href="{{route("admin.home")}}">Dashboard</a> > Setting</small>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Setting
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="mytable">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="table-setting">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>Nama</th>
                                <th>lihat content</th>
                                <th>Menu</th>
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
                    <form action="{{route('admin.setting.add')}}" method="post">
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Key (Sekali input)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="key" id="key" placeholder="Kata Kunci" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="name">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="content">Konten</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="content" id="content" placeholder="Konten" required></textarea><br>
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
    <div class="modal fade modal-main" id="view-content-modal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center"  >
                    <i class="fa fa-book"></i> KONTEN
                </div>
                <div class="modal-body">
                    <div class="content">
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).on("click",".view-content",function () {
            let modal_body = $("#view-content-modal .modal-body .content");
            let modal = $("#view-content-modal")
            $.ajax({
                url: '{{route("admin.setting.ajax",["action"=>"content"])}}',
                type: 'get',
                dataType: "json",
                data: {
                    id: $(this).data("id"),
                },
                success: function( data, textStatus, jQxhr ){
                    if (data.status) {
                        modal_body.html(data.data.content);
                        modal.modal("show")
                    } else {
                        $.notify({
                            title: '<strong>Gagal!</strong>',
                            message: 'Tidak ada data konten untuk setting ini',
                            animate: {
                                enter: 'animated bounceInDown',
                                exit: 'animated bounceOutUp'
                            }
                        },{
                            type: 'success',
                            z_index: 1200
                        });

                    }
                }
            });
        });
        var table = $('#table-setting').DataTable({
            dom: "Bfrtip",
            paging: true,
            pageLength: 10,
            ajax: function ( data, callback, settings ) {
                try{
                    $.ajax({
                        url: '{{route("admin.setting.ajax")}}',
                        type: 'post',
                        dataType: "json",

                        data: {
                            _token: "{{csrf_token()}}",
                            records_start: data.start,
                            search: data.search.value,
                            page_size: data.length,
                        },
                        success: function( data, textStatus, jQxhr ){
                            console.log(data);
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
                { data: "key"},
                { data: "name"},
                { data: "content",render:function (data,type, row) {return '<a style="cursor: pointer" class="view-content" data-id="'+row.id+'">lihat</a>'}},
                { data: "id", render : function (data, type, row ) {
                    return "" +
                        "<div class='input-group' >" +
                        "<a class='edit-detail' href='{{route("admin.setting.detail")}}/"+data+"' style='color: white; text-decoration: none' ><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>"+
                        "</div>";
                }}
            ],
            sScrollX: "100%",
            ordering:false,
            bScrollCollapse: true
        });
    </script>

@endsection

