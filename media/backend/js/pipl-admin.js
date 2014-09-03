
$(document).ready(function() {
    $('.leb_active').click();
    /*Start updating order status*/
    $("#order_status").change(function() {
        $.ajax({
            url: base_url + "order_manager/ajax_request.php",
            type: "post",
            data: {
                action: "statusUpdate",
                order_id: $("#order_id").val(),
                status: $("#order_status").val()
            },
            success: function(data) {
                alert(data)
            }

        });
    });
/*END updating order status*/
});

function activeBlock(id) {
    $('.dispshow').attr('class', 'dispNone');
    $('.leb_active').attr('class', 'leb');
    $('#active-' + id).attr('class', 'dispshow');
    $('#label-' + id).attr('class', 'leb_active');
}
/*Start Function for updating order status*/
function funChangeStatus(order_id, status) {
    $.ajax({
        url: base_url + "order_manager/ajax_request.php",
        type: "post",
        data: {
            action: "statusUpdate",
            order_id: order_id,
            status: status
        },
        success: function(data) {
            alert(data)
        }

    });
}
/*End Function for updating order status*/


/*Start Reporting related jquery*/
$("#timePeriod").change(function() {
    var timePeriod = $("#timePeriod").val();
    if (timePeriod == "range") {
        $("#dateDiv").show();
    } else {
        $("#dateDiv").hide();
        $("#dateStart").val('');
        $("#dateEnd").val('');
    }
});

$("#dateStart").change(function() {
    var startDate = $("#dateStart").val();
    var endDate = $("#dateEnd").val();
    if (startDate > endDate) {
        if (endDate != "") {
            alert("Start Date must be less than end date.")
        }
    }
});

$("#dateEnd").change(function() {
    var startDate = $("#dateStart").val();
    var endDate = $("#dateEnd").val();
    if (startDate > endDate) {
        if (endDate != "") {
            alert("End Date must be greter than start date.")
        }
    }
});

$("#selectType").change(function() {
    var selectType = $("#selectType").val();
    if (selectType == "greter" || selectType == "less") {
        $("#amountStart").show();
        $("#and").hide().val('');
        $("#amountEnd").hide().val('');
    } else if (selectType == "between") {
        $("#amountStart").show();
        $("#and").show();
        $("#amountEnd").show();
    } else {
        $("#amountStart").hide().val('');
        $("#and").hide();
        $("#amountEnd").hide().val('');
    }

});