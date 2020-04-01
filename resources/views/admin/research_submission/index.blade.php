@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Pengajuan</h1>
                <small><a href="{{route("admin.home")}}">Dashboard</a> > Pengajuan @if($user)> <a href="{{route("admin.user.detail",["id"=>$user->id])}}">{{$user->name}}</a>  @endif</small>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Pengajuan
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="table-data" width="100%">
                        <thead>
                        <tr class="text-center">
                            <th class="text-center" style="width: 80px">Status</th>
                            <th style="max-width: 300px">Judul</th>
                            <th>Tujuan</th>
                            <th>Catatan</th>
                            <th>Tanggal Pengajuan</th>
                            <th style="min-width: 100px">Menu</th>
                        </tr>
                        </thead>
                        <tbody id="content">
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    EXPORT
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="export-container">
                    <form class="form-inline" id="export-form" style="margin-bottom: 20px">
                        <div class="form-group">
                            from
                            <input class="form-control" id="dt_start" type="date" value="{{date("Y-m-")."01"}}"/>
                        </div>
                        <div class="form-group">
                            to
                            <input class="form-control" id="dt_end" type="date" value="{{date("Y-m-d")}}"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <div class="pull-right" id="export-buttons">
                    </div>
                    <table class="table table-bordered table-hover" id="table-export" width="100%">
                        <thead>
                        <tr class="text-center">
                            <th>NAMA/LEMBAGA</th>
                            <th>THEMA/JUDUL</th>
                            <th>WAKTU PENELITIAN</th>
                            <th>LOKASI SASARAN</th>
                            <th >TUJUAN PENELITIAN/SURVEY/KEGIATAN</th>
                        </tr>
                        </thead>
                        <tbody id="content">
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <div class="modal fade modal-main" id="edit-detail-modal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center"  >
                    <i class="fa fa-book"></i> INFO PENGAJUAN
                </div>
                <div class="modal-body">
                    <div class="table-user">
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <style>
        .modal-main .modal-header {padding: 5px;background: #0d6aad; font-weight: bold;color: #fff;}
        .borderless>tbody>tr>td, .borderless>tbody>tr>th {border-top: none;}
        .file-download .box {height: 200px;min-width: 100px;background-color: #0d6aad;transition: background-color 0.1s;cursor: pointer;color: #0d6aad;font-size: 18px;text-align: center; border-radius: 5px;padding-top: 50px}
        .file-download .box .icon {font-size: 30pt}
        .file-download .box:hover {background-color: #0b5286;color: lightgray;font-size: 18px;text-align: center}
        .btn-export {margin-left: 10px}
    </style>
    <script>
        $(document).ready(function() {

            $(document).on("click",".agreement-submission", function () {
                $(".loading").modal("show");
                $.ajax({
                    url: '{{route("admin.submission.ajax",["action"=>"download_agreement_pdf"])}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        status: 0,
                        id: $(this).data("id"),
                    },
                    success: function( data, textStatus, jQxhr ){
                        $(".loading").modal("hide")
                        $.notify({
                            title: '<strong>Berhasil!</strong>',
                            message: 'Downloaded',
                            animate: {
                                enter: 'animated bounceInDown',
                                exit: 'animated bounceOutUp'
                            }
                        },{
                            type: 'warning',
                            z_index: 1200
                        });
                    },
                    error:function () {
                        $(".loading").modal("hide")
                    }
                });
            });

            var table_export = $('#table-export').DataTable({
                dom: "Bfrtip",
                paging: true,
                pageLength: 5,
                ajax: function ( data, callback, settings ) {
                    try {
                        $.ajax({
                            url: '{{route("admin.submission.ajax",["action"=>"list_export"])}}',
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: "{{csrf_token()}}",
                                dt_start: $("#dt_start").val(),
                                dt_end: $("#dt_end").val(),
                                @if($user) user_id: '{{$user->id}}',  @endif
                            },
                            success: function( data, textStatus, jQxhr ){
                                callback({
                                    data: data.data
                                });
                            }, error:function () {
                                table_export.ajax.reload()
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
                columns: [
                    { data: "title",render: function (data, type, row ) {
                        return row.user.name
                    }},
                    { data: "title"},
                    { data: "survey_deadline", render:function (data, index, row) {
                        var diff = "";
                        var in_months = DateDiff.inMonths(new Date(row.created_at), new Date(data));
                        var in_days = DateDiff.inDays(new Date(row.created_at), new Date(data));
                        if (in_months > 0) diff = in_months+" bulan";
                        else diff = in_days+" hari";
                        return diff+"<br/>"+data;
                    }},
                    { data: "survey_sites",render:function (data, index, row) {
                        var locations = "";
                        try {
                            $.each(JSON.parse(row.locations),function (index, val) {
                                locations += val+"<br/>";
                            });
                        } catch (e){

                        }
                        return locations;
                    }},
                    { data: "research_purposes"},
                ],

                sScrollX: "100%",
                ordering:false,
                bScrollCollapse: true
            });

            $("#export-form").on("submit",function (e) {
                table_export.ajax.reload();
                e.preventDefault();
            })

            var table = $('#table-data').DataTable({
                dom: "frtip",
                paging: true,
                pageLength: 5,
                ajax: function ( data, callback, settings ) {
                    try {
                        $.ajax({
                            url: '{{route("admin.submission.ajax")}}',
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: "{{csrf_token()}}",
                                records_start: data.start,
                                search: data.search.value,
                                page_size: data.length,
                                @if($user) user_id: '{{$user->id}}',  @endif
                            },
                            success: function( data, textStatus, jQxhr ){
                                callback({
                                    data: data.data,
                                    recordsTotal:  data.recordsTotal,
                                    recordsFiltered:  data.recordsFiltered
                                });
                            }, error:function () {
                                table.ajax.reload()
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
                    { data: "status",render:function (data) {
                        if (data == "finish") return "<div class='alert alert-warning text-center' style='padding: 2px;margin:0px;width: 100%'><b>SELESAI</b></div>"
                        else if (data == "accept") return "<div class='alert alert-success text-center' style='padding: 2px;margin:0px;width: 100%'><b>DITERIMA</b></div>"
                        else if (data == "reject") return "<div class='alert alert-danger text-center' style='padding: 2px;margin:0px;width: 100%'><b>DITOLAK</b></div>"
                        else return "<div class='alert alert-info text-center' style='padding: 2px;margin:0px;width: 100%'><b>BARU</b></div>"
                    }},
                    { data: "title"},
                    { data: "research_purposes"},
                    { data: "notes"},
                    { data: "created_at"},
                    { data: "id", render : function (data, type, row ) {
                        return "" +
                            "<div class='input-group' >" +
                            "<a class='edit-detail' data-id='"+data+"' data-json='"+JSON.stringify(row)+"' style='color: white; text-decoration: none;width: 100px;' ><button type='button' style='width: 100px;font-size: 10px' class='btn btn-success btn-xs'><i class='fa fa-eye'></i> DETAIL</button></a>"+
                            "<a target='_blank' href='{{route("admin.submission.download",["action"=>"form_full"])}}?id="+data+"' data-id='"+data+"' data-json='"+JSON.stringify(row)+"' style='color: white; text-decoration: none;width: 100px' ><button  style='width: 100px;font-size: 10px' type='button' class='btn btn-primary btn-xs'><i class='fa fa-download'></i> DATA</button></a>"+
                            "<a target='_blank' href='{{route("admin.submission.download",["action"=>"statement_submission"])}}?id="+data+"' data-id='"+data+"' data-json='"+JSON.stringify(row)+"' style='color: white; text-decoration: none;width: 100px' ><button  style='width: 100px;font-size: 10px' type='button' class='btn btn-warning btn-xs'><i class='fa fa-download'></i> PERSETUJUAN</button></a>"+
                            "</div>";
                    }}
                ],
                sScrollX: "100%",
                ordering:false,
                bScrollCollapse: true
            });

            // update modal
            let footer_finish = "<div class='alert alert-success text-center'>PENGAJUAN TELAH SELESAI</div>";
            let footer_accept = "<div class='alert alert-info text-center'>PENGAJUAN TELAH DISETUJUI<br/><button type='button' class='btn btn-primary finish-submission'><i class='fa fa-check'></i> selesai</button></div>";
            let footer_reject = "<div class='alert  alert-warning text-center'>PENGAJUAN TELAH DITOLAK</div>";
            let footer_default = '<form class="form-inline"><div class="form-group"><input class="form-control" placeholder="catatan" id="reject-note" name="notes"></div><div class="form-group"><button type="button"  class="btn btn-warning reject-submission"><i class="fa fa-times"></i> tolak</button></div><div style="margin-left: 20px" class="form-group"><button type="button" class="btn btn-success accept-submission"><i class="fa fa-check"></i> setuju</button></div>';
            let footer = $('#edit-detail-modal .modal-footer');
            let cur_datas = {};
            $(document).on("click",".edit-detail",function () {
                let datas = $(this).data("json");
                cur_datas = datas;
                if (datas.status == 'finish') {
                    footer.html(footer_finish)
                }else if (datas.status == 'accept') {
                    footer.html(footer_accept)
                } else if (datas.status == 'reject'){
                    footer.html(footer_reject)
                } else  {
                    footer.html(footer_default)

                }
                let view_user = "<div class='row'>";
                view_user += "<div class='col-sm-4 text-center'><img src='{{upload_dir()}}"+datas.scan_file_identity_card+"' class='img-tumbnail' style='height:150px'/></div>"
                view_user += "<div class='col-sm-8'>" +
                    "<a href='{{route("admin.user.detail")}}/"+datas.user.id+"'><b style='font-size: 16pt'>"+datas.user.name+"</b></a><br/>" +
                    "<b>"+datas.title+"</b><br/>" +
                    "<span>"+datas.user.address+" (Alamat)</span><br/>" +
                    "<span>"+datas.user.phone+" {Telp}</span><br/>" +
                    "<span>"+datas.user.identity_card_number+" (NIK)</span>" +
                    "</div>";
                view_user += "</div>";
                view_user += "<hr style='border: solid 1px lightgray'>";
                view_user += "<div class='row file-download'>";
                if (datas.scan_proposal != "" && datas.scan_proposal != null) view_user += "<div style='margin-top:20px' class='col-sm-3'><a target='_blank' href='{{upload_dir()}}"+datas.scan_proposal+"'><div class='box'><div class='icon'><i class='fa fa-download '></i></div>Proposal</div></a></div>";
                if (datas.scan_file_identity_card != "" && datas.scan_file_identity_card != null) view_user += "<div style='margin-top:20px' class='col-sm-3'><a target='_blank' href='{{upload_dir()}}"+datas.scan_file_identity_card+"'><div class='box'><div class='icon'><i class='fa fa-download '></i></div>KTP</div></a></div>"
                if (datas.instance_cover_letter_file != "" && datas.instance_cover_letter_file != null) view_user += "<div style='margin-top:20px' class='col-sm-3'><a target='_blank' href='{{upload_dir()}}"+datas.instance_cover_letter_file+"'><div class='box'><div class='icon'><i class='fa fa-download '></i></div>Surat Pengantar Instansi</div></a></div>"
                if (datas.city_cover_letter_file != "" && datas.city_cover_letter_file != null) view_user += "<div style='margin-top:20px' class='col-sm-3'><a target='_blank' href='{{upload_dir()}}"+datas.city_cover_letter_file+"'><div class='box'><div class='icon'><i class='fa fa-download '></i></div>Surat Pengantar Luar Kota</div></a></div>"
                if (datas.other_documents != "" && datas.other_documents != null) view_user += "<div style='margin-top:20px' class='col-sm-3'><a target='_blank' href='{{upload_dir()}}"+datas.other_documents+"'><div class='box'><div class='icon'><i class='fa fa-download '></i></div>Dokumen lain</div></a></div>"
                view_user += "</div>";
                let avail_user = {
                    name:"nama",
                    email:"email",
                    address:"alamat",
                    phone:"telepon",
                    identity_card_number:"No. KTP",
                    student_id_number:"NIM",
                };
                let table_user = $("#edit-detail-modal .modal-body .table-user");
                table_user.html("");
                table_user.append(view_user);
                $("#edit-detail-modal").modal("show")
            });
            $("#edit-detail-modal").on("click",".finish-submission", function () {
                $("#edit-detail-modal button").attr("disabled","");
                $.ajax({
                    url: '{{route("admin.submission.ajax",["action"=>"update"])}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        status: "finish",
                        id: cur_datas.id,
                    },
                    success: function( data, textStatus, jQxhr ){
                        $("#edit-detail-modal button").removeAttr("disabled");
                        if (data){
                            table.ajax.reload();
                            footer.html(footer_finish)
                            notify("success","Berhasil!",'Pengajuan telah diselesaikan');
                        }else{
                            notify("danger","Gagal!",'Gagal melakukan proses')
                        }
                    },
                    error: function () {
                        notify("danger","Gagal!",'Gagal melakukan proses')
                        $("#edit-detail-modal button").removeAttr("disabled");
                    }
                });
            });
            $("#edit-detail-modal").on("click",".accept-submission", function () {
                $("#edit-detail-modal button").attr("disabled","");
                $.ajax({
                    url: '{{route("admin.submission.ajax",["action"=>"update"])}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        status: "accept",
                        id: cur_datas.id,
                    },
                    success: function( data, textStatus, jQxhr ){
                        $("#edit-detail-modal button").removeAttr("disabled");
                        if (data.status) {
                            table.ajax.reload();
                            footer.html(footer_accept)
                            notify("success","Berhasil!",'Pengajuan telah disetujui');
                        } else {
                            notify("danger","Gagal!",'Gagal melakukan proses')
                        }
                    },
                    error: function () {
                        $("#edit-detail-modal button").removeAttr("disabled");
                        notify("danger","Gagal!",'Gagal melakukan proses')
                    }

                });
            });
            $("#edit-detail-modal").on("click",".reject-submission", function () {
                $("#edit-detail-modal button").attr("disabled","");
                $.ajax({
                    url: '{{route("admin.submission.ajax",["action"=>"update"])}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        status: "reject",
                        note:$("#reject-note").val(),
                        id: cur_datas.id,
                    },
                    success: function( data, textStatus, jQxhr ){
                        $("#edit-detail-modal button").removeAttr("disabled");
                        if (data.status) {
                            table.ajax.reload();
                            footer.html(footer_reject)
                            notify("success","Berhasil!",'Pengajuan telah ditolak');
                        } else {
                            notify("danger","Gagal!",'Gagal melakukan proses')
                        }
                    },
                    error: function () {
                        notify("danger","Gagal!",'Gagal melakukan proses')
                        $("#edit-detail-modal button").removeAttr("disabled");
                    }
                });
            });

            $(document).on("click",".download-submission", function () {
                $(".loading").modal("show");
                $.ajax({
                    url: '{{route("admin.submission.ajax",["action"=>"download_pdf"])}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        status: 0,
                        id: $(this).data("id"),
                    },
                    success: function( data, textStatus, jQxhr ){
                        $(".loading").modal("hide")
                        if (data.status) {
                            notify("success","Berhasil!",'File telah di download');
                        } else {
                            notify("danger","Gagal!",'Gagal melakukan proses')
                        }
                    },
                    error:function () {
                        notify("danger","Gagal!",'Gagal melakukan proses')
                        $(".loading").modal("hide")
                    }
                });
            });


        });
    </script>

@endsection
