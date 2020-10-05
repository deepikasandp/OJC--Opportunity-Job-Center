<?php
// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);

if(isset($_GET['request'])){
    if($_GET['request'] == "getAllJobData"){
        if(isset($_GET['job_id'])){
            $userRow = $user->getJobDetails($_GET['job_id']);
            $industry = $user->getIndustryType($userRow['JOB_INDUSTRY']);
            $jobType = $user->getJobType($userRow['JOB_TYPE']);
            $experience = $user->getExperienceType($userRow['JOB_EXPERIENCE']);
            
            echo "<h4>". $userRow['JOB_TITLE'] ."</h4>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Organisation Name</th>";
            echo "<td>" . $userRow['ORG_NAME'] . "</td>";
            echo "</tr>";
            echo "<th>Organisation Location</th>";
            echo "<td>" . $userRow['ORG_LOCATION'] . "</td>";
            echo "</tr>";
            echo "<th>Job Title</th>";
            echo "<td>" . $userRow['JOB_TITLE'] . "</td>";
            echo "</tr>";
            echo "<th>Job Industry</th>";
            echo "<td>" . $industry . "</td>";
            echo "</tr>";
            echo "<th>Job Location</th>";
            echo "<td>" . $userRow['JOB_LOCATION'] . "</td>";
            echo "</tr>";
            echo "<th>Job Type</th>";
            echo "<td>" . $jobType . "</td>";
            echo "</tr>";
            echo "<th>Required Skills</th>";
            echo "<td>" . $userRow['JOB_SKILLS'] . "</td>";
            echo "</tr>";
            echo "<th>Required Experience</th>";
            echo "<td>" . $experience . "</td>";
            echo "</tr>";
            echo "<th>Posted Date</th>";
            echo "<td>" . $userRow['UPDATED_DATE'] . "</td>";
            echo "</tr>";
            echo "</table>";
        }
    }
}
?>