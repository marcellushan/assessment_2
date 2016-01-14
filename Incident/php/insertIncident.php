<?php

/*
 * Get Event Request ready for ajax jQuery call
 */

// Filter out post variables for security
$submitterName = htmlentities($_POST['submitterName'], ENT_QUOTES, 'UTF-8');
$submitterTitle = htmlentities($_POST['submitterTitle'], ENT_QUOTES, 'UTF-8');
$submitterPhone = htmlentities($_POST['submitterPhone'], ENT_QUOTES, 'UTF-8');
$submitterEmail = htmlentities($_POST['submitterEmail'], ENT_QUOTES, 'UTF-8');
$incidentDescription = htmlentities($_POST['incidentDescription'], ENT_QUOTES, 'UTF-8');
$reportUrgency = htmlentities($_POST['reportUrgency'], ENT_QUOTES, 'UTF-8');
$incidentDate = htmlentities($_POST['incidentDate'], ENT_QUOTES, 'UTF-8');
$incidentTime = htmlentities($_POST['incidentTime'], ENT_QUOTES, 'UTF-8');
$incidentDateTime = date('Y-m-d H:i:s', strtotime("$incidentDate $incidentTime"));
$incidentLocationSpecific = htmlentities($_POST['incidentLocationSpecific'], ENT_QUOTES, 'UTF-8');
$publicSafetyResponse = htmlentities($_POST['publicSafetyResponse'], ENT_QUOTES, 'UTF-8');

// Start the arrays
$incidentLocationGeneric = $_POST['incidentLocationGeneric']; //grab $_POST ok from Incident Location list
$respondingOrganization = $_POST['respondingOrganization']; //grab $_POST ok from Responding Organization list
// JSON encode
$incidentLocationGeneric = json_encode((object) $incidentLocationGeneric);
$respondingOrganization = json_encode((object) $respondingOrganization);

// Save new incident to database
function InsertIncident($submitterName, $submitterTitle, $submitterPhone, $submitterEmail, $incidentDescription, $reportUrgency, $incidentDateTime, $incidentLocationGeneric, $incidentLocationSpecific, $publicSafetyResponse, $respondingOrganization) {
    include 'dbConn.php';
    try {
        // Time and Date of actual insert
        $dateSubmitted = date("Y-m-d H:i:s");
        // PHP PDO SQL Statement
        $sql = "INSERT INTO incidentreporting.incident "
                . "(submitterName, "
                . "submitterTitle, "
                . "submitterPhone, "
                . "submitterEmail, "
                . "incidentDescription, "
                . "reportUrgency, "
                . "incidentDateTime, "
                . "incidentLocationGeneric, "
                . "incidentLocationSpecific, "
                . "publicSafetyResponse, "
                . "respondingOrganization, "
                . "dateSubmitted) "
                . "VALUES "
                . "(:submitterName, "
                . ":submitterTitle, "
                . ":submitterPhone, "
                . ":submitterEmail, "
                . ":incidentDescription, "
                . ":reportUrgency, "
                . ":incidentDateTime, "
                . ":incidentLocationGeneric, "
                . ":incidentLocationSpecific, "
                . ":publicSafetyResponse, "
                . ":respondingOrganization, "
                . ":dateSubmitted) ";
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':submitterName', $submitterName);
        $stm->bindParam(':submitterTitle', $submitterTitle);
        $stm->bindParam(':submitterPhone', $submitterPhone);
        $stm->bindParam(':submitterEmail', $submitterEmail);
        $stm->bindParam(':incidentDescription', $incidentDescription);
        $stm->bindParam(':reportUrgency', $reportUrgency);
        $stm->bindParam(':incidentDateTime', $incidentDateTime);
        $stm->bindParam(':incidentLocationGeneric', $incidentLocationGeneric);
        $stm->bindParam(':incidentLocationSpecific', $incidentLocationSpecific);
        $stm->bindParam(':publicSafetyResponse', $publicSafetyResponse);
        $stm->bindParam(':respondingOrganization', $respondingOrganization);
        $stm->bindParam(':dateSubmitted', $dateSubmitted);
        $stm->execute();
        $incidentRowID = $dbh->lastInsertId();

        // Create blank temp arrays for translating Involved Party data
        $insertquery = array();
        $insertdata = array();
        // Sequentially translate each Involved Party array (Name, Role, Gender, Email, Phone) into the blank temp arrays
        foreach ($_POST['partyName'] as $key => $PartyName) {
            if ($PartyName) { // skip the empty parties
                $insertquery[] = '( ?,?,?,?,?,? )';
                $insertdata[] = $PartyName;
                $insertdata[] = $_POST['partyRole'][$key];
                $insertdata[] = $_POST['partyGender'][$key];
                $insertdata[] = $_POST['partyEmail'][$key];
                $insertdata[] = $_POST['partyPhone'][$key];
                $insertdata[] = $incidentRowID;
            }
        }
        // Start of PDO SQL statement
        $sql2 = " INSERT INTO involved_parties
            (
                partyName,
                partyRole,
                partyGender,
                partyEmail,
                partyPhone,
                incident_id
            )
            VALUES ";
        // Break apart incident data to its respective rows, and insert them
        if (!empty($insertquery)) {
            $sql2 .= implode(', ', $insertquery);
            $stmt = $dbh->prepare($sql2);
            $stmt->execute($insertdata);
        }

        // Close the dbh connection 
        $dbh = null;

        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');

        require_once 'PHPMailer/PHPMailerAutoload.php';

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
        $mail->setFrom('hr@highlands.edu', 'HR');
        //Set an alternative reply-to address
        $mail->addReplyTo('hr@highlands.edu', 'HR');

        //Set Campus array for mailTo
        //$remove = array("{", "}", ":", "\"", "0", "1", "2", "3", "4");

        //Set who the message is to be sent to
        $mail->addAddress('hr@highlands.edu', 'HR');

        //Set the subject line
        $mail->Subject = "New Incident Report Submitted";

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('emailContent/emailContent.html'), dirname(__FILE__));
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = 'An incident report was submitted. <br/>Please review it at your earliest convenience. <br/>To view current incidents, <a href="http://forms.highlands.edu/incidentreporting/admin.html">Click Here &raquo;</a>';

        //Replace the plain text body with one created manually
        $mail->AltBody = 'An incident report was submitted. '
                . 'Please review it at your earliest convenience. To view current incidents, go to http://forms.highlands.edu/incidentreporting/admin.html';

        //Attach an image file
        // $mail->addAttachment('someFile.png');
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

if (isset($_POST)) {
    InsertIncident($submitterName, $submitterTitle, $submitterPhone, $submitterEmail, $incidentDescription, $reportUrgency, $incidentDateTime, $incidentLocationGeneric, $incidentLocationSpecific, $publicSafetyResponse, $respondingOrganization);
}
