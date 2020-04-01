var notify = function (type, title, message) {
    $.notify({
        title: '<strong>'+title+'</strong>',
        message: message,
        animate: {
            enter: 'animated bounceInDown',
            exit: 'animated bounceOutUp'
        }
    },{
        type: type,
        z_index: 1200
    });
}

$(document).on("click",".confirm-delete",function (e) {
    if(!confirm("Apakah anda yakin menjalankan perintah ini?")){
        e.preventDefault();
    }
});

$(".one-input").keypress(function (e) {
    var s = String.fromCharCode(e.which);
    if (s.match(/[a-zA-Z\.]/)){
        $(this).val(s).trigger('change');
        e.preventDefault();
    }else{
        e.preventDefault();
    }

});
$(".four-input").keypress(function (e) {
    var s = String.fromCharCode(e.which);
    if (s.match(/[0-9\.]/)){
        if( $(this).val().length > 3){
            $(this).val(s).trigger('change');
            e.preventDefault();
        }
    }else{
        e.preventDefault();
    }


});
$(".phone-input").keypress(function (e) {
    var s = String.fromCharCode(e.which);
    if (s.match(/[0-9\.]/)){
        if( $(this).val().length > 12){
            e.preventDefault();
        }
    }else{
        e.preventDefault();
    }
});

$(".input-discount").keyup(function (e) {
    console.log("masuk "+ $(this).val());
    if ($(this).val() > 100){
        $(this).val(100).trigger('change');
        e.preventDefault();
    }
});

$(".loading").on("click", function(e) {
    e.preventDefault();
    $("#loadMe").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
    });
    setTimeout(function() {
        $("#loadMe").modal("hide");
    }, 3500);
});
function printImage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function printImages(input,id){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

var DateDiff = {
    inSeconds: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();
        return parseInt((t2-t1)/(1000));
    },

    inMinutes: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();
        return parseInt((t2-t1)/(60*1000));
    },

    inHours: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(3600*1000));
    },

    inDays: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000));
    },

    inWeeks: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000*7));
    },

    inMonths: function(d1, d2) {
        var d1Y = d1.getFullYear();
        var d2Y = d2.getFullYear();
        var d1M = d1.getMonth();
        var d2M = d2.getMonth();

        return (d2M+12*d2Y)-(d1M+12*d1Y);
    },

    inYears: function(d1, d2) {
        return d2.getFullYear()-d1.getFullYear();
    }
}
