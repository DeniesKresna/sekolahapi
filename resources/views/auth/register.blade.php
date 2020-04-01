@extends('layouts.auth')

@section('content')
    <div  class="bg-darkgrey">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 text-center" id="register">
                    <img src="{{asset("public/gallery/material/web-branding-400.png")}}" width="40%">
                    <div class="bg-white" id="registerBox">
                        <h1>SI-PERMATA</h1>
                        <h3>Registrasi Akun Baru</h3><br>
                        <form class="form-horizontal" action="{{route("register")}}" id="form-register" method="post">
                            {{ csrf_field() }}
                            <div class="form-group"  {{ $errors->has('name') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Nama Lengkap:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" placeholder="Nama Lengkap" name="name" id="name" required>
                                    <span class="error-message"></span>
                                    @if ($errors->has('name'))
                                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  >
                                <label class="control-label col-sm-3 col-xs-12">Tempat & Tanggal Lahir:</label>
                                <div class="col-sm-5 col-xs-6 {{ $errors->has('birth_place') ? ' has-error' : '' }}">
                                    <input class="form-control" type="text" placeholder="Kota Lahir" name="birth_place" id="birth_place"  required>
                                    @if ($errors->has('birth_place'))
                                        <span class="help-block"><strong>{{ $errors->first('birth_place') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-sm-4 col-xs-6 {{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                    <input class="form-control" type="date" name="birth_date" required id="birth_date" >
                                    @if ($errors->has('birth_date'))
                                        <span class="help-block"><strong>{{ $errors->first('birth_date') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('address') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Alamat:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="2" placeholder="Alamat" name="address" required id="address" ></textarea>
                                    @if ($errors->has('address'))
                                        <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('phone') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">No. Telepon:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" placeholder="No. Telepon" name="phone" required id="phone" >
                                    @if ($errors->has('phone'))
                                        <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('current_job') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Pekerjaan:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" placeholder="Pekerjaan" name="current_job" required id="current_job" >
                                    @if ($errors->has('current_job'))
                                        <span class="help-block"><strong>{{ $errors->first('current_job') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('student_id_number') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">NIM / NPM:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" placeholder="NIM / NPM" name="student_id_number" id="student_id_number" >
                                    @if ($errors->has('student_id_number'))
                                        <span class="help-block"><strong>{{ $errors->first('student_id_number') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('religion') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Agama:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="religion" required id="religion" >
                                        <option>-- Pilih Agama Kepercayaan --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Khong Hu Chu">Khong Hu Chu</option>
                                    </select>
                                    @if ($errors->has('religion'))
                                        <span class="help-block"><strong>{{ $errors->first('religion') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('gender') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Jenis Kelamin:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input  checked type="radio" value="laki laki" name="gender" >Laki-laki</label>
                                    <label class="radio-inline"><input type="radio" value="perempuan"  name="gender">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('marriage_status') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Status Pernikahan:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="marriage_status" required id="marriage_status" >
                                        <option>-- Pilih Status Pernikahan --</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                    @if ($errors->has('marriage_status'))
                                        <span class="help-block"><strong>{{ $errors->first('marriage_status') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('identity_card_number') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Nomor KTP:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" placeholder="Nomor KTP" name="identity_card_number" required id="identity_card_number" >
                                    @if ($errors->has('identity_card_number'))
                                        <span class="help-block"><strong>{{ $errors->first('identity_card_number') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('education') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Pendidikan / Jurusan:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" placeholder="Pendidikan / Jurusan" name="education" required id="education" >
                                    @if ($errors->has('education'))
                                        <span class="help-block"><strong>{{ $errors->first('education') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"  {{ $errors->has('email') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Email:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="email" placeholder="Email" name="email" required id="email" >
                                    <span id="error-email" style="color: red"></span>
                                    @if ($errors->has('email'))
                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                                <script>
                                    var email_error = false;
                                    var password_error = false;
                                    $(document).on("change","#email",function () {
                                        $.ajax({
                                            url: '{{route("user.account.ajax",["action"=>"check_email"])}}',
                                            type: 'post',
                                            dataType: "json",
                                            data: {
                                                _token: "{{csrf_token()}}",
                                                email:$(this).val()
                                            },
                                            success: function( data, textStatus, jQxhr ){
                                                if (data.status){
                                                    $("#error-email").html("");
                                                    email_error = true;
                                                } else {
                                                    email_error = false;
                                                    $("#error-email").html("Email Sudah digunakan ")
                                                }
                                            }, error:function () {
                                                table.ajax.reload()
                                            }
                                        });

                                    })
                                </script>
                            </div>
                            <div class="form-group"  {{ $errors->has('password') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Password:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" placeholder="Password" name="password" required id="password" >
                                    <span id="error-password" style="color: red"></span>
                                    @if ($errors->has('password'))
                                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <script>
                                $(document).on("change","#password",function () {
                                    var pass = $(this).val()+"";
                                    if (pass.length >= 6){
                                        $("#error-password").html("");
                                        password_error = true;
                                    } else {
                                        password_error = false;
                                        $("#error-password").html("Password min 6 karakter")
                                    }
                                })

                            </script>
                            <div class="form-group"  {{ $errors->has('email') ? ' has-error' : '' }}>
                                <label class="control-label col-sm-3">Re-Enter Password:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" placeholder="Re-Enter Password" name="password_confirmation" required id="password_confirmation" >
                                    <span id="error-password-con" style="color: red"></span>
                                </div>
                            </div>
                            <script>
                                $(document).on("change","#password_confirmation",function () {
                                    var pass_con = $(this).val();
                                    var pass = $("#password").val();
                                    if (pass === pass_con){
                                        password_con_error = true;
                                        $("#error-password-con").html("");
                                    } else {
                                        password_con_error = false;
                                        $("#error-password-con").html("Password tidak sama")
                                    }
                                })

                            </script>

                            <div class="form-group"  {{ $errors->has('email') ? ' has-error' : '' }}>
                                <div class="col-sm-offset-3 col-sm-9">
                                    <a href="{{route("welcome")}}"><button type="button" class="btn btn-md btn-white">Batal</button></a>
                                    <button type="button" id="pra-submit" class="btn btn-success">Selanjutnya</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-white" id="regAgreementBox" hidden>
                        <h1>Standard Operational Procedure</h1>
                        <form>
                            <div style="width: 100%;height: 550px; overflow-y: auto;alignment: left">
                                <?php $setting = \App\Setting::all()->where("key","agreement")->first(); echo ($setting)? $setting->content:"TIDAK ADA"?>
                                <div class="form-group" style="margin-top: 100px">
                                    <label class="control-label"><input type="checkbox" id="agreement-check" >Saya sudah membaca secara keseluruhan</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 20px">
                                <input type="submit" id="submit-form" disabled class="btn btn-green" form="form-register" value="Ya, Saya setuju">
                            </div>
                        </form>
                        <div class="form-group" style="margin-top: 20px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
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
        let form = $( "#form-register" );
        form.validate();
        $("#pra-submit").on("click",function (e) {
            if (form.valid() && email_error) {
                $("#registerBox").attr("hidden","");
                $("#regAgreementBox").removeAttr("hidden");
            }
        });
        $("#agreement-check").on("change",function () {
            if (!$(this).is(":checked")) $("#submit-form").attr("disabled","")
            else $("#submit-form").removeAttr("disabled");
        });
        $("#submit-form").on("click", function (e) {
            console.log("hallo")
            form.submit()
        });
        // $(window).bind('beforeunload',function(){
        //     return 'are you sure you want to leave?';
        // });
    </script>
@endsection
