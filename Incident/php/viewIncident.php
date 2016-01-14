<?php

/*
 * Get Event Request ready for ajax jQuery call
 */

// Save new asessment to database
function ViewIncident() {
    include 'dbConn.php';
    try {
        // PHP PDO SQL Statement
        $sql = "SELECT incident_id,submitterName,submitterTitle,reportUrgency,dateSubmitted FROM incidentreporting.incident ORDER BY dateSubmitted DESC";
        $stm = $dbh->prepare($sql);
        $stm->execute();

        // Fetch the results in a numbered array
        $getIncidents = $stm->fetchALL(PDO::FETCH_NUM);

        $tables = '<table class="table table-striped table-hover table-responsive"><thead><tr class="info lead"><th>Name</th><th>Status</th><th>Date Submitted</th><th>Urgency</th><th>Details</th></tr></thead><tbody>';

        foreach ($getIncidents as $row) {
            $tables .= "<tr><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[4] . "</td><td>";
            
            // show only Normal or Urgent
            if ($row[3] == 1) {$tables .= "Urgent</td>";}
            if ($row[3] == 0) {$tables .= "Normal</td>";}
            
            $tables .= '<td><button id="' . $row[0] . '" class="btn btn-info btn-sm detail new-boarder-btn" data-toggle="modal" data-target="#modalIncidentDetail">View Details</button></td></tr>';
        }

        $tables .= '</tbody></table>';
        echo $tables;

        // Close the dbh connection 
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

ViewIncident();
