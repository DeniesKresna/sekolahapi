@extends('layouts.guest')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 bg-white" id="formBox">
                <h1>Formulir Pengajuan Penelitian</h1>
                <div class="container-fluid text-center">
                    <?php echo print_flashdata()?>
                </div>
                <form action="{{route("submission.add")}}" method="post"  enctype="multipart/form-data" id="form-submission">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Judul Penelitian <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="title" placeholder="Judul Penelitian/Skripsi/Thesis" id="inputTitle" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputTitle').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bidang Penelitian <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="form-group">
                            <select name="research_field" class="form-control select2" id="research_field" required style="width: 100%!important;">
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
                        <label>Tempat Survey/Riset <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <select name="survey_sites[]" class=" select2" multiple="multiple" required style="width: 100%!important;">
                            <?php $survey_sites = \App\OfficeData::all(); ?>
                            @if($survey_sites)
                                @foreach($survey_sites as $survey_site)
                                    <option value="{{$survey_site->id}}">{{$survey_site->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Batas Waktu Survey <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label><br>
                        <div class="input-group">
                            <select class="form-control" name="survey_deadline"  id="inputDue" required>
                                <option value="{{date("Y-m-d",strtotime("+1 month"))}}">1 Bulan</option>
                                <option value="{{date("Y-m-d",strtotime("+2 month"))}}">2 Bulan</option>
                                <option value="{{date("Y-m-d",strtotime("+3 month"))}}">3 Bulan</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputDue').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group multiple-form-group" data-max="3">
                        <label>Peserta Penelitian <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="form-group input-group">
                            <input class="form-control" type="text" name="research_participants[]" placeholder="Nama peserta penelitian" required>
                            <span class="input-group-btn"><button type="button" class="btn btn-default btn-add"><span class="fa fa-plus"></span></button></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tujuan Penelitian <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control" name="research_purposes" type="text" placeholder="Tujuan penelitian" id="inputPurpose" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputPurpose').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Scan KTP (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control photo" name="scan_file_identity_card" type="file" id="inputKtp" required  accept="image/*" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputKtp').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Proposal (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control photo" name="scan_proposal" type="file" id="inputProposal" accept="application/pdf"  required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputProposal').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Surat Pengantar Instansi (Maks 3MB) <sup style="font-size: 8pt;color: red;">*wajib diisi</sup></label>
                        <div class="input-group">
                            <input class="form-control photo" name="instance_cover_letter_file" type="file" id="inputCover"  accept="application/pdf"  required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default"  onclick="document.getElementById('inputCover').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Surat Pengantar Luar Kota/Porvinsi (Maks 3MB)</label>
                        <div class="input-group">
                            <input class="form-control photo" name="city_cover_letter_file" type="file"  accept="application/pdf"  id="inputCoverOut">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputCoverOut').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Berkas Dokumen Pedukung Lain (Maks 3MB)</label>
                        <div class="input-group">
                            <input class="form-control" name="other_documents" type="file" id="inputOther"  accept="application/pdf">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="document.getElementById('inputOther').value=''"><span class="fa fa-times"></span></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" id="pra-submit" class="btn btn-success">Selanjutnya</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-offset-2 col-sm-8 bg-white" id="subAgreementBox"  hidden>
                <div >
                    <h1>Standard Operational Procedure</h1>
                    <form>
                        <div style="width: 100%;height: 550px; overflow-y: auto;alignment: left">
                            <div id="statement">
                                <h1><u><strong>SURAT PERNYATAAN</strong></u></h1>
                                <p>Yang bertanda tangan di bawah ini:</p>
                                <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><?php echo (isset($user->name))?$user->name:"Tidak ada nama"?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo (isset($user->address))?$user->address:"Tidak ada alamat"?></td>
                                    </tr>
                                    <tr>
                                        <td>Bidang</td>
                                        <td>:</td>
                                        <td class="research_field_fill"></td>
                                    </tr>
                                </table>
                                <p class="text-justify">   Dengan ini menyatakan bahwa saya bersedia untuk mentaati dan tidak melanggar ketentuan peraturan perundang-undangan yang berlaku selama melakukan kegiatan penelitian.</p>
                                <p class="text-justify">   Demikian surat pernyataan ini saya buat tanpa ada unsur paksaan dan penuh rasa tanggung jawab.</p>
                                <br><br>
                                <div id="statementSign">
                                    <p>Madiun, {{date("d M Y")}}</p>
                                    <p>Yang menyatakan</p>
                                    <br><br><br>
                                    <p><?php echo (isset($user->name))?$user->name:"Tidak ada nama"?></p>
                                </div>
                            </div>
                            <style>
                                #statement{font-family: 'Roboto', sans-serif;margin: 15px 30px;}
                                #statement h1{text-align: center;font-size: 30px;}
                                #statement table{width: 100%;}
                                #statementSign{float: right;margin-right: 20px;}

                            </style>
                            <div class="form-group" style="margin-top: 100px">
                                <label class="control-label"><input type="checkbox" id="agreement-check" >Saya sudah membaca secara keseluruhan</label>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px">
                            <input type="submit" id="submit-form" disabled class="btn btn-green" form="form-submission" value="Ya, Saya setuju">
                        </div>
                    </form>
                    <div class="form-group" style="margin-top: 20px">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-first-agreement" >
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h2>Ketentuan Khusus (Disclaimer)</h2>
                    <div style="width: 100%;height: 400px; overflow-y: auto;alignment: left" class="text-left">
                        <?php $setting = \App\Setting::all()->where("key","disclaimer")->first();echo ($setting)?$setting->content:"Tidak Ada"?>
                    </div>
                    <div class="form-group" style="margin-top: 20px">
                        <button class="btn btn-success" data-dismiss="modal">Saya setuju</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(window).on("load",function(){
            $('#modal-first-agreement').modal({backdrop:"static",keyboard: false});
        });
        jQuery.validator.setDefaults({
            "rules": {
                "name": {
                    "required": true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        let form = $( "#form-submission" );
        form.validate();
        $("#pra-submit").on("click",function (e) {
            if (form.valid()) {
                $("#formBox").attr("hidden","");
                $("#subAgreementBox").removeAttr("hidden");
                $(".research_field_fill").html($("#research_field").val());
                scrollToTop();
            }
        });
        $("#agreement-check").on("change",function () {
            if (!$(this).is(":checked")) $("#submit-form").attr("disabled","")
            else $("#submit-form").removeAttr("disabled");
        });


        $(document).ready(function() {
            $('.select2').select2();
            var addFormGroup = function (event) {
                event.preventDefault();

                var $formGroup = $(this).closest('.form-group');
                var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
                var $formGroupClone = $formGroup.clone();

                $(this)
                    .toggleClass('btn-default btn-add btn-danger btn-remove')
                    .html('<span class="fa fa-minus"></span>');

                $formGroupClone.find('input').val('');
                $formGroupClone.insertAfter($formGroup);

                var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
                if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                    $lastFormGroupLast.find('.btn-add').attr('disabled', true);
                }
            };

            var removeFormGroup = function (event) {
                event.preventDefault();

                var $formGroup = $(this).closest('.form-group');
                var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

                var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
                if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                    $lastFormGroupLast.find('.btn-add').attr('disabled', false);
                }

                $formGroup.remove();
            };

            var countFormGroup = function ($form) {
                return $form.find('.form-group').length;
            };

            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);
        });
        function scrollToTop() {
            window.scrollTo(0, 0);
        }
    </script>

@endsection
