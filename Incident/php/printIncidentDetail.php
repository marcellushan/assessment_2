<?php

/*
 * Get Event Request ready for ajax jQuery call
 */

$incidentId = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');

//Adds commas only if another item follows in the list
function formatArray($incomingArray) {

	$incomingArrayLength = count($incomingArray);
	$incomingArrayOutput = "";
	
	foreach ($incomingArray as $key=>$arrayItem) {
		$incomingArrayOutput .= $arrayItem;
		if (($incomingArrayLength - 1) > $key) {
			$incomingArrayOutput .= ", ";
		}
	}
	
	return $incomingArrayOutput;
}

// Save new asessment to database
function PrintIncidentDetail($incidentId) {
    include 'dbConn.php';
    try {
        // PHP PDO SQL Statement
        $sql = "SELECT * FROM incidentreporting.incident WHERE incident_id = :incidentId";
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':incidentId', $incidentId);
        $stm->execute();
        
        // Fetch the results in a numbered array
        $getIncidents = $stm->fetchALL(PDO::FETCH_NUM);
        
        $print = '';
        
        foreach($getIncidents as $row) {
            
            $incidentLocationGeneric = json_decode($row[8], TRUE);
            $respondingOrganization = json_decode ($row[11], TRUE);
        
            $print .= '<button type="button" class="btn btn-info printClose" style="margin:0px auto; position:relative; width:200px;">Close</button>';
	    $print .= "<div class='row' style='border:solid 1px #ccc;'>";
            $print .= "<div class='col-sm-6'>";
            $print .= "<h2>Submitter Information</h2>";
            $print .= "<p>Name: " . $row[1] . "</p>";
            $print .= "<p>Status: " . $row[2] . "</p>";
            $print .= "<p>Phone number: " . $row[3] . "</p>";
            $print .= "<p>E-mail address: " . $row[4] . "</p>";
            $print .= "<p>Date submitted: " . $row[12] . "</p></div>";
            
            $print .= "<div class='col-sm-6'>";
            $print .= "<h2>Incident Details</h2>";
            $print .= "<p>Priority:";
            
            // show only Normal or Urgent
            if ($row[6] == 1) {$print .= "&nbsp;Urgent</p>";}
            if ($row[6] == 0) {$print .= "&nbsp;Normal</p>";}
            
            $print .= "<p>Date/Time of incident: " . $row[7] . "</p>";
            $print .= "<p>Location (generic): " . formatArray($incidentLocationGeneric) . "</p>";
            $print .= "<p>Location (specific): " . $row[9] . "</p>";
            $print .= "<p>Public Safety response: ";
            
            // show only Yes or No
            if ($row[10] == 1) {$print .= "&nbsp;Yes</p>";}
            if ($row[10] == 0) {$print .= "&nbsp;No</p>";}
            
            $print .= "<p>Responding organization[s]: " . formatArray($respondingOrganization) . "</p></div>";
            
            $print .= "<div class='col-sm-12'>";
            $print .= "<h2>Incident description</h2>";
            $print .= "<p>" . $row[5] . "</p></div></div>";
        }
        
        // PHP PDO SQL Statement
        $sql2 = "SELECT * FROM incidentreporting.involved_parties WHERE incident_id = :incidentId";
        $stmt = $dbh->prepare($sql2);
        $stmt->bindParam(':incidentId', $incidentId);
        $stmt->execute();
        
        // Fetch the results in a numbered array
        $getParties = $stmt->fetchALL(PDO::FETCH_NUM);
        
        if ($getParties != FALSE) {
            $print .= "<div class='row'  style='border:solid 1px #ccc;'>";
            $print .= "<div class='col-sm-12'><h2>Involved Parties</h2></div>";
        
            foreach($getParties as $row) {
                $print .= "<div class='col-sm-6'>";
                $print .= "<p>Name: " . $row[1] . "</p>";
                $print .= "<p>Role: " . $row[2] . "</p>";
                $print .= "<p>Gender: " . $row[3] . "</p>";
                $print .= "<p>E-mail address: " . $row[4] . "</p>";
                $print .= "<p>Phone Number: " . $row[5] . "</p>";
                $print .= "<br /></div>";
            }
            
            $print .= "</div>";
        }
        
        echo $print;
        
        // Close the dbh connection 
        $dbh = null;

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}


PrintIncidentDetail($incidentId);
