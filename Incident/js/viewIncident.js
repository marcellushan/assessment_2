// View events functions
$(function() {
    $.ajax({
        url: "php/viewIncident.php",
        success: function(data) {
            console.log(data);
            $("#results").html(data); // echo out whatever is returned
            return false;
        }
    });
});

// attach a delegated event with a more refined selector
$("#results").on("click", "button.detail", function(event) {
    var data = $(this).attr('id');
    $.ajax({
        type: "POST",
        url: "php/viewIncidentDetail.php",
        data: {'id': data},
        success: function(data) {
            console.log(data);
            $("#modalDiv").html(data); // echo out whatever is returned
            $('#modalIncidentDetail').modal('show'); // display the modal window
            return false;
        }
    });
    return false;
});

// Trigger print view 
$(".modal-body").on("click", "button.printView", function(event) {
    var data = $(this).attr('id');
    $.ajax({
        type: "POST",
        url: "php/printIncidentDetail.php",
        data: {'id': data},
        success: function(data) {
            console.log(data);
            $("#print").html(data); // echo out whatever is returned
            $('#modalIncidentDetail').modal('hide');            
            $('#mainBody').hide();
            $('#print').show(); // display the modal window
            return false;
        }
    });
    return false;
});

$("#print").on("click", "button.printClose", function() {
            $('#print').hide();
            $('#mainBody').show();
            return false;
});

