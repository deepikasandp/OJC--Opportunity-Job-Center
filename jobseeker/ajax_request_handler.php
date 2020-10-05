<?php
// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);

if(isset($_GET['request'])){
    if($_GET['request'] == "showOfferMessage"){
        if(isset($_GET['offer_id']))
        {            
            $row = $user->getOfferDetailsByOfferId($_GET['offer_id']);
            if($row){
                echo "<table>";
                echo "<tr>";
                    echo "<th>Subject</th>";
                    echo "<td>" . $row['SUBJECT'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>Message</th>";
                    echo "<td><textarea rows='20' cols='100'>" . $row['MESSAGE'] . "</textarea></td>";
                echo "</tr>";                          
                echo "</table>";
            }
            else{
                echo "Something went wrong, try again!";
            }
            
        }
    }
}

// Utility function to validate the form data
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['search']))
{
    $industry = test_input($_POST['industry']);
    $jobType = test_input($_POST['jobType']);    
    $experience = test_input($_POST['experience']);    
    $jobTitle = test_input($_POST['jobTitle']);   
    $skills = test_input($_POST['skills']);

    $jobIds = $user->searchCandidateBySelection($industry,$jobType,$experience,$jobTitle,$skills);

    if($jobIds){ 
            echo "<thead>";
                echo "<th>Organisation Name</th>";
                echo "<th>Organisation Location</th>";
                echo "<th>Job Title</th>";
                echo "<th>Job Industry</th>";                   
                echo "<th>Job Location</th>";
                echo "<th>Job Type</th>";
                echo "<th>Required Skills</th>";
                echo "<th>Required Experience</th>";
                echo "<th>Posted Date</th>";
            echo "</thead>";                
            echo "<tbody>";
                foreach($jobIds as $jobId)
                {   
                    $jobRow = $user->getJobDetails($jobId['JOB_ID']);    
                    $industry = $user->getIndustryType($jobRow['JOB_INDUSTRY']);
                    $jobType = $user->getJobType($jobRow['JOB_TYPE']);
                    $experience = $user->getExperienceType($jobRow['JOB_EXPERIENCE']); 
                        echo "<tr>";
                            echo "<td>" . $jobRow['ORG_NAME'] . "</td>";
                            echo "<td>" . $jobRow['ORG_LOCATION'] . "</td>";
                            echo "<td>" . $jobRow['JOB_TITLE'] . "</td>";
                            echo "<td>" . $industry . "</td>";
                            echo "<td>" . $jobRow['JOB_LOCATION'] . "</td>";
                            echo "<td>" . $jobType . "</td>";
                            echo "<td>" . $jobRow['JOB_SKILLS'] . "</td>";
                            echo "<td>" . $experience . "</td>";
                            $datetime = $jobRow['UPDATED_DATE'];
                            $date = date_create($datetime);
                            $date = date_format($date,"d/m/Y");
                            echo "<td>" . $date . "</td>";
                        echo "</tr>";
                }            
            echo "</tbody>";
    }
    else{
        echo "<h4>Sorry, No Matches found yet<h4>";
    }
}
?>