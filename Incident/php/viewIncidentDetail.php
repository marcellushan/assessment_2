<?php

/*
 * Get Incident Reports ready for ajax jQuery call
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
function ViewIncidentDetail($incidentId) {
    include 'dbConn.php';
    try {
        // PHP PDO SQL Statement
        $sql = "SELECT * FROM incidentreporting.incident WHERE incident_id = :incidentId";
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':incidentId', $incidentId);
        $stm->execute();
        
        // Fetch the results in a numbered array
        $getIncidents = $stm->fetchALL(PDO::FETCH_NUM);
        
        $modal = '';
        
        foreach($getIncidents as $row) {
            
            $incidentLocationGeneric = json_decode($row[8], TRUE);
            $respondingOrganization = json_decode ($row[11], TRUE);
        
            $modal .=  '<button id="' . $row[0] . '" type="button" class="btn btn-info printView">Print</button>';  
            $modal .= "<h2>Submitter Information</h2>";
            $modal .= "<p><span class='label label-primary'>Name:</span>  " . $row[1] . "</p>";
            $modal .= "<p><span class='label label-primary'>Status:</span>  " . $row[2] . "</p>";
            $modal .= "<p><span class='label label-primary'>Phone number:</span>  " . $row[3] . "</p>";
            $modal .= "<p><span class='label label-primary'>E-mail address:</span>  " . $row[4] . "</p>";
            $modal .= "<p><span class='label label-primary'>Date submitted:</span>  " . $row[12] . "</p><hr/>";
            
            $modal .= "<h2>Incident Details</h2>";
            $modal .= "<p><span class='label label-info'>Incident description:</span>  " . $row[5] . "</p>";
            $modal .= "<p><span class='label label-info'>Priority:</span>";
            
            // show only Normal or Urgent
            if ($row[6] == 1) {$modal .= "&nbsp;Urgent</p>";}
            if ($row[6] == 0) {$modal .= "&nbsp;Normal</p>";}
            
            $modal .= "<p><span class='label label-info'>Date/Time of incident:</span>  " . $row[7] . "</p>";
            $modal .= "<p><span class='label label-info'>Location (generic):</span>  " . formatArray($incidentLocationGeneric) . "</p>";
            $modal .= "<p><span class='label label-info'>Location (specific):</span> " . $row[9] . "</p>";
            $modal .= "<p><span class='label label-info'>Public Safety response:</span>";
            
            // show only Yes or No
            if ($row[10] == 1) {$modal .= "&nbsp;Yes</p>";}
            if ($row[10] == 0) {$modal .= "&nbsp;No</p>";}
            
            $modal .= "<p><span class='label label-info'>Responding organization[s]:</span>  " . formatArray($respondingOrganization) . "</p>";
        }
        
        // PHP PDO SQL Statement
        $sql2 = "SELECT * FROM incidentreporting.involved_parties WHERE incident_id = :incidentId";
        $stmt = $dbh->prepare($sql2);
        $stmt->bindParam(':incidentId', $incidentId);
        $stmt->execute();
        
        // Fetch the results in a numbered array
        $getParties = $stmt->fetchALL(PDO::FETCH_NUM);
        
        if ($getParties != FALSE) {
            $modal .= "<hr/><h2>Involved Parties</h2>";
        }
        
        foreach($getParties as $row) {
            
            $modal .= "<p><span class='label label-default'>Name:</span>  " . $row[1] . "</p>";
            $modal .= "<p><span class='label label-default'>Role:</span>  " . $row[2] . "</p>";
            $modal .= "<p><span class='label label-default'>Gender:</span>  " . $row[3] . "</p>";
            $modal .= "<p><span class='label label-default'>E-mail address:</span>  " . $row[4] . "</p>";
            $modal .= "<p><span class='label label-default'>Phone Number:</span>  " . $row[5] . "</p>";
            $modal .= "<br />";
            
        }
        
        echo $modal;
        
        // Close the dbh connection 
        $dbh = null;

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

ViewIncidentDetail($incidentId);