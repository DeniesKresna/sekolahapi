@extends('layouts.guest')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 bg-white text-center" id="formBox">
                <h4 style="margin: 10%">Anda sudah mengajukan permohonan<br/>tunggu hingga batas pengajuan berakhir<br/>untuk mengajukan kembali</h4>
                <a href="{{route("submission")}}"><button type="button" class="btn btn-default btn-block"><b>Cancel</b></button></a>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        (function ($) {
            $(function () {

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
        })(jQuery);

    </script>

@endsection
