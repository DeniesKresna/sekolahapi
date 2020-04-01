@extends('layouts.guest')

@section('content')
    <div class="bg-grey">
        <div class="container-fluid" id="submissions">
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8 bg-white">
                    <h1>Riwayat Pengajuan Riset <a href="{{route("submission.form")}}" class="pull-right"><button class="btn btn-success"><i class="fa fa-plus"></i> Ajukan Ijin Riset</button></a></h1>
                    <div class="panel-group" id="submissionsAccordion">
                        @foreach($datas as $data)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a role="button" href="#submission-{{$data->id}}" data-toggle="collapse" data-parent="submissionsAccordion">
                                        <div>
                                            <h3 class="panel-title acc">
                                                {{$data->title}}
                                            </h3>
                                        </div>
                                    </a>
                                    <p>{{date("d/m/Y", strtotime($data->created_at))}} &ensp; <span class="status text-yellow">{{strtoupper(!empty($data->status)?(($data->status == "finish")?"SELESAI":(($data->status == "accept")?"DITERIMA":(($data->status == "reject")?"DITOLAK":"BARU"))):"BARU")}}</span></p>
                                </div>

                                <div class="panel-collapse collapse" id="submission-{{$data->id}}">

                                    <div class="panel-body">
                                        <p>Tempat penelitian: <br></p>
                                        <ol type="1">
                                            @foreach($data->get_survey_sites() as $survey_site)
                                                <li>{{$survey_site->name}}</li>
                                            @endforeach
                                        </ol>
                                        <p>Batas Penelitian: {{$data->survey_deadline}}</p>
                                        <p>Peserta penelitian: <br></p>
                                        <ol type="1">
                                            @foreach(json_decode($data->research_participants) as $research_participant)
                                                <li>{{$research_participant}}</li>
                                            @endforeach
                                        </ol>
                                        <p>Tujuan: {{$data->research_purposes}}</p>
                                        <p>Berkas: </p>
                                        @if(!empty($data->scan_file_identity_card)) <a target="_blank"  href="{{(upload_dir().$data->scan_file_identity_card)}}">Scan KTP</a> @else Scan KTP @endif |
                                        @if(!empty($data->instance_cover_letter_file)) <a target="_blank"  href="{{(upload_dir().$data->instance_cover_letter_file)}}">Surat pengantar intitusi</a>  @else Surat pengantar intitusi @endif |
                                        @if(!empty($data->city_cover_letter_file)) <a target="_blank"  href="{{(upload_dir().$data->city_cover_letter_file)}}">Surat pengantar luar provinsi</a>  @else Surat pengantar luar provinsi @endif |
                                        @if(!empty($data->scan_proposal)) <a target="_blank"  href="{{(upload_dir().$data->scan_proposal)}}">Proposal</a>  @else Proposal @endif |
                                        @if(!empty($data->other_documents)) <a target="_blank" href="{{(upload_dir().$data->other_documents)}}">Dokumen pendukung lain</a> @else Dokumen pendukung lain @endif
                                        <hr style="border: 0.5px solid lightgrey"/>
                                        @if (empty($data->status) || strtoupper($data->status) == "NEW")
                                            <div class="alert alert-warning text-center">Permohonan telah diajukan</div>
                                        @elseif (strtoupper($data->status) == "FINISH")
                                            <div class="alert alert-success text-center">Permohonan anda telah selesai</div>
                                        @elseif (strtoupper($data->status) == "ACCEPT")
                                            <div class="alert alert-info text-center">Permohonan anda telah disetujui</div>
                                        @elseif (strtoupper($data->status) == "REJECT")
                                            <div class="alert alert-danger text-center">Permohonan anda telah ditolak<br/><a href="{{route("submission.edit",["id"=>$data->id])}}"><button class="btn btn-danger">Edit Pengajuan</button></a><br/><b>Catatan</b><br/>{{$data->notes}}</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var acc = document.getElementsByClassName("acc");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");
            });
        }
    </script>
@endsection
