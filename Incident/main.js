/* 
 * copyrights 2014 GHC
 */

// submit form for validation clientside first

$(function() {
    $('#incidentReport').validate({// initialize the plugin
        // your rules and options,
        submitHandler: function(form) {
            $.ajax({
                type: 'post',
                url: 'php/insertIncident.php',
                data: $(form).serialize(),
                success: function(responseData) {
                    console.log(responseData);
                    $(".messageSaved").html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">x</button>'+responseData+'<strong>Your incident report has been submitted.</strong><br />The incident will be investigated and resolved with all due haste. <br/><a href="http://www.highlands.edu/site/human-resources-title-ix" class="btn btn-lg btn-success btn-block"> - Click Here to Finish - </a></div>').fadeIn();
                    $(".well").fadeOut();
                    $('html, body').animate({scrollTop: $('.container').offset().top}, 'slow');
                },
                error: function(responseData) {
                    console.log('Ajax request not recieved!');
                }
            });
            // resets fields
            $("#incidentReport").each(function() {
                this.reset();
            });

            return false; // blocks redirect after submission via ajax
        }
    });
});

// Clone Input Row
var regex = /^(.*)(\d)+$/i;
var cloneIndex = $("#partyContainer").length;

$("button.addParty").on("click", function() {
    if (cloneIndex < 10) {
        $( "#party1" ).clone()
            .appendTo( "#partyContainer" )
            .attr("id", "party" + cloneIndex)
            //.find("*").each(function() {
            //    var id = this.id || "";
            //    var match = id.match(regex) || [];
            //    if (match.length == 3) {
            //        this.id = match[1] + (cloneIndex);
            //    }
            //})
            .hide()
            .fadeIn();
            cloneIndex++;
    } else {
        alert("You have reached the limit.");
    }
    return false;
});
