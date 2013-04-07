/*$("body").load(function() {
    //$("#loadjs").alert('close');
});*/

$("#color").change(function() {
    $("#progbar").removeClass("progress-info progress-success progress-warning progress-danger").addClass("progress-" + $("#color").val());
});

$("#value").change(function() {
    val = parseFloat($("#value").val());
    if (isNaN(val)) {
        $("#value-help").html("Invalid number");
        $("#value-group").removeClass("success").addClass("error");
    } else {
        
        if(val < 0) {
            $("#value-help").html("Value too small");
            $("#value-group").removeClass("success").addClass("error");
        } else if (val > 100) {
            $("#value-help").html("Value too big");
            $("#value-group").removeClass("success").addClass("error");
        } else {
            $("#value-help").html("");
            $("#value-group").removeClass("error").addClass("success");
            $("#progbar-bar").width(val + "%");
        }
    }
})

$("#striped").change(function() {
    //alert($(self).val().toString())
    if ($(this).prop("checked")) {
        $("#animated").prop('disabled', false);
        $("#progbar").addClass("progress-striped");
    } else {
        $("#animated").prop('disabled', true).prop('checked', false).change();
        $("#progbar").removeClass("progress-striped");
    }
})

$("#animated").change(function() {
    if ($("#animated").prop("checked")) {
        $("#progbar").addClass("active");
    } else {
        $("#progbar").removeClass("active");
    }
})