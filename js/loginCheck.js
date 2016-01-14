// View events functions
$(function() {
    $.ajax({
        url: "ldapLib/loginCheck.php",
        success: function(data) {
            console.log(data);
            if (data == "not_logged_in"){
            window.location.replace("https://forms.highlands.edu/incidentreporting/login.php");
            } else {
            $("#chk").html(data); // echo out whatever is returned
        }
            return false;
        }
    });
});
