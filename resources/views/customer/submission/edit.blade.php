@extends('layouts.guest')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 bg-white" id="formBox">
                <h1>Formulir Pengajuan Penelitian</h1>
                <div class="container-fluid text-center">
                    <?php echo print_flashdata()?>
                </div>
                <form action="{{route("submission.update",["id"=>$data->id])}}" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Judul Penelitian <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="title" value="{{$data->title}}"  placeholder="Judul Penelitian/Skripsi/Thesis" id="inputTitle" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputTitle').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bidang Penelitian <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        <div class="form-group">
                            <select name="research_field" class="form-control select2" required style="width: 100%!important;">
                                <?php $research_fields = \App\ResearchField::all(); ?>
                                @if($research_fields)
                                    @foreach($research_fields as $research_field)
                                        <option value="{{$research_field->name}}">{{$research_field->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group multiple-form-group" data-max=3>
                        <label>Tempat Survey/Riset <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        <select name="survey_sites[]" class=" select2" multiple="multiple" required style="width: 100%!important;">
                            <?php $survey_sites = \App\OfficeData::all(); ?>
                            @if($survey_sites)
                                @foreach($survey_sites as $survey_site)
                                    <option @if(in_array($survey_site->id,to_array($data->get_survey_sites()->pluck("id")->values()))) selected @endif value="{{$survey_site->id}}">{{$survey_site->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Batas Waktu Survey <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label><br>
                        <div class="input-group">
                            <input class="form-control" value="{{$data->survey_deadline}}"  name="survey_deadline" type="date" id="inputDue" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputDue').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group multiple-form-group" data-max="3">
                        <label>Peserta Penelitian <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        <?php $first_research_participant = true;?>
                        @foreach(json_decode($data->research_participants) as $research_participant)
                            <div class="form-group input-group">
                                <input class="form-control" value="{{$research_participant}}"  type="text" name="research_participants[]" placeholder="Nama peserta penelitian" required>
                                @if($first_research_participant && sizeof(json_decode($data->research_participants)) > 1)
                                    <?php $first_research_participant = false;?>
                                    <span class="input-group-btn"><button type="button" class="btn btn-danger btn-remove"><span class="fa fa-minus"></span></button></span>
                                @else
                                    <span class="input-group-btn"><button type="button" class="btn btn-default btn-add"><span class="fa fa-plus"></span></button></span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>Tujuan Penelitian <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control" value="{{$data->research_purposes}}"  name="research_purposes" type="text" placeholder="Tujuan penelitian" id="inputPurpose" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputPurpose').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Scan KTP (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        @if(!empty($data->scan_file_identity_card))<a target="_blank"  href="{{upload_dir().$data->scan_file_identity_card}}">view file</a>@endif
                        <div class="input-group">
                            <input class="form-control photo" name="scan_file_identity_card" type="file" id="inputKtp"  accept="image/*">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputKtp').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Proposal (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        @if(!empty($data->scan_file_identity_card))<a target="_blank"  href="{{upload_dir().$data->scan_proposal}}">view file</a>@endif
                        <div class="input-group">
                            <input class="form-control photo" name="scan_proposal" type="file" id="inputProposal"  accept="application/pdf" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputProposal').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Surat Pengantar Instansi (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajid diisi</sup></label>
                        @if(!empty($data->scan_file_identity_card))<a  target="_blank" href="{{upload_dir().$data->instance_cover_letter_file}}">view file</a>@endif
                        <div class="input-group">
                            <input class="form-control photo" name="instance_cover_letter_file" type="file" id="inputCover"  accept="application/pdf" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputCover').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Surat Pengantar Luar Kota/Porvinsi (Maks 3MB) </label>
                        @if(!empty($data->scan_file_identity_card))<a target="_blank"  href="{{upload_dir().$data->city_cover_letter_file}}">view file</a>@endif
                        <div class="input-group">
                            <input class="form-control photo" name="city_cover_letter_file" type="file" id="inputCoverOut"   accept="application/pdf" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputCoverOut').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Dokumen Pedukung Lain (Maks 3MB)</label>
                        @if(!empty($data->scan_file_identity_card))<a target="_blank" href="{{upload_dir().$data->other_documents}}">view file</a>@endif
                        <div class="input-group">
                            <input class="form-control" name="other_documents" type="file" id="inputOther"  accept="application/pdf" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputOther').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-green">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        (function ($) {
            $(function () {
                var add_condition = true;
                var addFormGroup = function (event) {
                    event.preventDefault();
                    if (add_condition){
                        var $formGroup = $(this).closest('.form-group');
                        var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                        var $formGroupClone = $formGroup.clone();

                        $(this)
                            .toggleClass('btn-default btn-danger btn-remove')
                            .html('<span class="fa fa-minus"></span>');

                        $formGroupClone.find('input').val('');
                        $formGroupClone.insertAfter($formGroup);

                        var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
                        if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                            $lastFormGroupLast.find('.btn-add').attr('disabled', true);
                            add_condition = false;
                        }
                    }
                };

                var removeFormGroup = function (event) {
                    event.preventDefault();

                    var $formGroup = $(this).closest('.form-group');
                    var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

                    var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
                    if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                        $lastFormGroupLast.find('.btn-add').attr('disabled', false);
                        add_condition = true;
                    }

                    $formGroup.remove();
                };

                var countFormGroup = function ($form) {
                    return $form.find('.form-group').length;
                };

                $(document).on('click', '.btn-add', addFormGroup);
                $(document).on('click', '.btn-remove', removeFormGroup);

            });
        })(jQuery);

    </script>

@endsection
