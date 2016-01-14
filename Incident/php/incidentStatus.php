<?php

/*
 * Get Event Status ready for ajax jQuery call
 */

$eventId = intval($_POST['id']);
$status = intval($_POST['value']);
$archived = 0;

// Save new asessment to database
function setEventStatus($eventId, $status, $archived) {
    include 'dbConn.php';
    include 'PHPMailer/PHPMailerAutoload.php';

    /* Prepare the sql statements */
    $sqlUpdate = "UPDATE studentlife.eventRequest SET eStatus = :status, archived = :archived WHERE id = :id";
    $sthUpdate = $dbh->prepare($sqlUpdate);
    $sthUpdate->bindParam(":status", $status);
    $sthUpdate->bindParam(":archived", $archived);
    $sthUpdate->bindParam(":id", $eventId);
    $sthUpdate->execute();

    $sqlSelect = "SELECT * FROM studentlife.eventRequest WHERE id = :eventId";
    $sthSelect = $dbh->prepare($sqlSelect);
    $sthSelect->bindParam(":eventId", $eventId);
    $sthSelect->execute();

    // Fetch the results in a numbered array
    $results = $sthSelect->fetchALL(PDO::FETCH_NUM);
    
    $campuses = json_decode($results[0][1], TRUE);
    $pcampus = '';
    foreach ($campuses as $campus) {
        $pcampus .= "$campus, ";
    }

    $clubs = json_decode($results[0][4], TRUE);
    $pclubs = '';
    foreach ($clubs as $club) {
        $pclubs .= "$club, ";
    }
    
    $setups = json_decode($results[0][8], TRUE);
    $psetup = '';
    foreach ($setups as $setup) {
        $psetup .= "$setup, ";
    }

    if ($results[0][29] == 1) {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = "mail.highlands.edu";
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 25;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = false;
        //Set who the message is to be sent from
        $mail->setFrom('studlife@highlands.edu', 'Student Life');
        //Set an alternative reply-to address
        $mail->addReplyTo('studlife@highlands.edu', 'Student Life');

        //Set who the message is to be sent to
        $mail->addAddress('tporrett@highlands.edu', 'Webmaster TLP');
        $mail->addAddress($results[0][25], $results[0][24]);

        //Set the subject line
        $mail->Subject = "Event " . $results[0][2] . " is Approved! Details Inside.";

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('emailContent/emailContent.html'), dirname(__FILE__));
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = 'Thank you for your online event submission.'
                . '<br/>Your event <strong>' . $results[0][2] . '</strong> is Approved. Please keep this email for your records.<br/><hr/>'
                . '<strong>Event Details:</strong><br/>'
                . 'Event Name: ' . $results[0][2] . '<br/>'
                . 'Start Date: ' . $results[0][5] . '<br/>'
                . 'End Date: ' . $results[0][6] . '<br/>'
                . 'For Campus: ' . $pcampus . '<hr/>'
                . 'For Clubs: ' . $pclubs . '<hr/>'
                . '<strong>Set Up Request:</strong><br/>'
                . 'Set Up: ' . $psetup . '<br/>'
                . 'Chairs: ' . $results[0][10] . '<br/>'
                . 'Tables: ' . $results[0][12] . '<br/>'
                . 'Other: ' . $results[0][14] . '<br/>'
                . 'Room: ' . $results[0][7] . '<br/>'
                . 'Comments: ' . $results[0][27] . '<hr/>'
                . '<strong>Food Request:</strong><br/>'
                . 'Food Type: ' . $results[0][15] . '<br/>'
                . 'Food Source: ' . $results[0][16] . '<br/>'
                . 'Food Cost: ' . $results[0][17] . '<br/>'
                . 'Food Reason: ' . $results[0][21] . '<br/>'
                . 'Future Food Events: ' . $results[0][22] . '<br/>'
                . 'Attendance: ' . $results[0][18] . '<br/>'
                . 'Per Diem: ' . $results[0][19] . '<br/>'
                . 'Payment: ' . $results[0][20] . '<br/><hr/>'
                . 'If you have any questions or concerns, please contact your student life coordinator.'
                . '<br/><br/>Thank You, <br/>Student Life';

        //Replace the plain text body with one created manually
        $mail->AltBody = "Thank you for your online event submission.\r\n"
                . "Your event submission has been Approved. Please keep this email for your records.\r\n"
                . "If you have any questions or concerns, please contact your student life coordinator.\r\n\r\n"
                . "Thank You, \nStudent Life";

        //Attach an image file
        // $mail->addAttachment('someFile.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent to " . $results[0][25];
        }
    }

    if ($results[0][29] == 0) {
        //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = "mail.highlands.edu";
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 25;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = false;
        //Set who the message is to be sent from
        $mail->setFrom('studlife@highlands.edu', 'Student Life');
        //Set an alternative reply-to address
        $mail->addReplyTo('studlife@highlands.edu', 'Student Life');

        //Set who the message is to be sent to
        $mail->addAddress('webmaster@highlands.edu', 'Webmaster TLP');
        $mail->addAddress($results[0][25], $results[0][24]);

        //Set the subject line
        $mail->Subject = "Event " . $results[0][2] . " is Denied! Details Inside.";

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('emailContent/emailContent.html'), dirname(__FILE__));
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = 'Thank you for your online event submission.'
                . '<br/>Your event ' . $results[0][2] . ' has been Denied. Please keep this email for your records.<br/><br/>'
                . 'A student life coordinator will be contacting you about this event and details on how you can improve your submission to have your event approved.'
                . '<br/><br/>Contact your student life coordinator with any questions you may have.'
                . '<br/><br/>Thank You, <br/>Student Life';

        //Replace the plain text body with one created manually
        $mail->AltBody = "Thank you for your online event submission.\r\n"
                . "Your event has been Denied. \r\n"
                . "A student life coordinator will be contacting you about this event and details on how you can improve your submission to have your event approved.\r\n"
                . "Contact your student life coordinator with any questions you may have.\r\n\r\n"
                . "Thank You, \r\nStudent Life";

        //Attach an image file
        // $mail->addAttachment('someFile.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent " . $results[0][25];
        }
    }
    // Close the dbh connection 
    $dbh = null;
}

setEventStatus($eventId, $status, $archived);
