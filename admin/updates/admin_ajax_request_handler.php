<?php
// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);

// Utility function to validate the form data
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Handle get requests */

if(isset($_GET['request']))
{
    if($_GET['request'] == "getJob"){
        $row = $user->getJobDetails($_GET['id']);
        $industry = $user->getIndustryType($row['JOB_INDUSTRY']);
        $jobType = $user->getJobType($row['JOB_TYPE']);
        $experience = $user->getExperienceType($row['JOB_EXPERIENCE']);
        echo "<thead>";
        echo "<th>USER_ID</th>";
        echo "<th>JOB_TITLE</th>";
        echo "<th>JOB_INDUSTRY</th>";
        echo "<th>JOB_TYPE</th>";
        echo "<th>JOB_SKILLS</th>";
        echo "<th>JOB_EXPERIENCE</th>";
        echo "<th>UPDATED_DATE</th>";
        echo "</thead>";
        echo "<tbody>";        
        echo "<tr>";
        echo "<td>" . $row['USER_ID'] . "</td>";
        echo "<td>" . $row['JOB_TITLE']. "</td>";
        echo "<td>" . $industry. "</td>";
        echo "<td>" . $jobType. "</td>";
        echo "<td>" . $row['JOB_SKILLS']. "</td>";
        echo "<td>" . $experience. "</td>";
        echo "<td>" . $row['UPDATED_DATE'] . "</td>";
        echo "</tr>";
        echo "</tbody>";
    }
    else if($_GET['request'] == "viewJobsByUserId"){
        $user_id = $_GET['user_id'];
        /* find if he is a job seeker or recruiter */
        $userRow = $user->getUser($user_id);
        if($userRow){
            $user_type_id = $userRow['USER_TYPE_ID'];
            $type = $user->getUserType($user_type_id);
            if($type === "R"){
                $jobRows = $user->getAllJobs($user_id); 
                foreach($jobRows as $row)
                { 
                    $industry = $user->getIndustryType($row['JOB_INDUSTRY']);
                    $jobType = $user->getJobType($row['JOB_TYPE']);
                    $experience = $user->getExperienceType($row['JOB_EXPERIENCE']);
                    echo "<h4>". $row['JOB_TITLE'] ."</h4>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Organisation Name</th>";
                    echo "<td>" . $row['ORG_NAME'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Organisation Location</th>";
                    echo "<td>" . $row['ORG_LOCATION'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Title</th>";
                    echo "<td>" . $row['JOB_TITLE'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Industry</th>";
                    echo "<td>" . $industry . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Location</th>";
                    echo "<td>" . $row['JOB_LOCATION'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Type</th>";
                    echo "<td>" . $jobType . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Required Skills</th>";
                    echo "<td>" . $row['JOB_SKILLS'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Required Experience</th>";
                    echo "<td>" . $experience . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Posted Date</th>";
                    echo "<td>" . $row['UPDATED_DATE'] . "</td>";
                    echo "</tr>";
                    echo "</table>";
                }
            }else if(($type === "JS") || ($type === "ADMIN")){
                echo "<p> Selection is a Candidate/Admin, no jobs saved </p>";
            }
            else{
                echo "<p> Something went wrong! Unable to find user type..</p>";
            }
        }
        else{
            echo "<p> Something went wrong! User not found..</p>";
        }          
    }    
    else if($_GET['request'] == "getJobByJobId")/*for editing */
    { 
        $job_id = $_GET['job_id'];         
        $jobToEdit = $user->getJobDetails($job_id);   
        $name = $jobToEdit['ORG_NAME'];
        $postcode = $jobToEdit['ORG_LOCATION'];
        $title = $jobToEdit['JOB_TITLE'];
        $industry = $jobToEdit['JOB_INDUSTRY'];
        $location = $jobToEdit['JOB_LOCATION'];

        echo "<h4>". $jobToEdit['JOB_TITLE'] ."</h4>";        
        echo "<table>";
            /* Job ID - Hidden */
            echo "<tr>"; 
                echo "<input type='hidden' id='job_id' name='job_id' value='$job_id'>";
            echo "</tr>";  

            /* Organisation Name */
            echo "<tr>";
                echo "<th>";
                echo "<label for='org_name'>Organisation Name:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='org_name' name='org_name' value='$name'>";
                echo "</td>";                
            echo "</tr>";  

            /* Organisation Location */      
            echo "<tr>";
                echo "<th>";
                echo "<label for='org_location'>Organisation Location Postcode:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='org_location' name='org_location' value='$postcode'>";
                echo "</td>";                
            echo "</tr>";
                    
            /* Title */               
            echo "<tr>";
                echo "<th>";
                echo "<label for='title'>Job Title:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='title' name='title' value='$title'>";
                echo "</td>";                
            echo "</tr>";       

            /* Industry */
            echo "<tr>";
                echo "<th>";
                echo "<label for='industry'>Job Industry:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<select id='industry' name='industry' value='$industry'>";
                $industryList = $user->getJobIndustryList();
                foreach($industryList as $industry){
                    echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                }
                echo "</td>";                
            echo "</tr>";     

            /* Location */ 
            echo "<tr>";
                echo "<th>";
                echo "<label for='location'>Job Location Postcode:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='location' name='location' value='$location'>";
                echo "</td>";                
            echo "</tr>"; 

            /* Job type */ 
            echo "<tr>";
            echo "<th>";
            echo "<label for='jobType'>Job Type:</label></th>";
            echo "</th>";        
            echo "<td>";
            echo "<select id='jobType' name='jobType' value='".$jobToEdit['JOB_TYPE']."'>";
            $jobTypeList = $user->getJobTypeList();
            foreach($jobTypeList as $jobType){
                echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
                }
            echo "</td>";                
            echo "</tr>";

            /* Skills */
            echo "<tr>";
                echo "<th>";
                echo "<label for='skills'>Skills:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<textarea id='skills' name='skills' rows='4' cols='50'>".$jobToEdit['JOB_SKILLS']."</textarea>";
                echo "</td>";                
            echo "</tr>"; 

            /* Experience */ 
            echo "<tr>";
            echo "<th>";
            echo "<label for='experience'>Experience:</label></th>";
            echo "</th>";        
            echo "<td>";
            echo "<select id='experience' name='experience' value='".$jobToEdit['JOB_EXPERIENCE']."'>";
            $experienceList = $user->getExperienceList();
            foreach($experienceList as $experience){
                echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
                }
            echo "</td>";                
            echo "</tr>";

            /* Submit */
            echo "<tr>";
            echo "<th>";
            echo "</th>";
            echo "<td>";
            echo "<input type='submit' value='Submit' name='updateJob'>";
            echo "</td>";  
            echo "</tr>";

        echo "</table>";
    }        
    else if($_GET['request'] == "delJobByJobId"){ 
        $job_id = $_GET['job_id'];
        $result = $user->deleteJobOfferByJobID($job_id);
        if($result){
            $result = $user->deleteJob($job_id);
            if($result){
                echo "Deleted Successfully";
            }
            else{            
                echo "Delete Operation Failed! Try Again";
            }
        }
        else{                   
            echo "Delete Operation Failed! Try Again";
        }
    }
    else if($_GET['request'] == "viewOffersByUserId")
    {
        $user_id = $_GET['user_id'];
        /* find if he is a job seeker or recruiter */
        $userRow = $user->getUser($user_id);
        if($userRow)
        {
            $user_type_id = $userRow['USER_TYPE_ID'];
            $type = $user->getUserType($user_type_id);
            if($type === "JS")
            {
                $offerRows = $user->getOfferDetailsByUserId($user_id); 
                $nOffersSent = $user->getNOffersByUserId($user_id);
                if($nOffersSent)
                {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Candidate Name</th>";
                    echo "<th>Candidate Email Address</th>";
                    echo "<th>Offer Message</th>";
                    echo "<th>Offer Date</th>";
                    echo "</tr>";
                    foreach($offerRows as $offerRow) 
                    { 
                        echo "<tr>";
                        echo "<td>" . $userRow['FIRST_NAME']. " " .$userRow['LAST_NAME']. "</td>";
                        echo "<td>" . $userRow['USER_NAME'] . "</td>";
                        echo "<td>" . $offerRow['SUBJECT'] . "</td>";
                        echo "<td>" . $offerRow['UPDATED_DATE'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                else
                {
                    echo "<p> No Offers received Yet </p>"; 
                }
            }
            else if(($type === "R") || ($type === "ADMIN")){
                echo "<p> Selection is a recruiter/admin, has not received any offers </p>";
            }
            else{
                echo "<p> Something went wrong! Unable to find user type..</p>";
            }
        }   
        else{
            echo "<p> Something went wrong! User not found..</p>";
        }       
    }    
    else if($_GET['request'] == "viewProfileByUserId") /* for read-only */
    {
        $user_id = $_GET['user_id'];
        /* find if he is a job seeker or recruiter */
        $userRow = $user->getUser($user_id);
        if($userRow)
        {
            $user_type_id = $userRow['USER_TYPE_ID'];
            $type = $user->getUserType($user_type_id);
            if($type === "JS")
            {
                $profileRow = $user->getJSProfileByUserId($user_id); 
                $updated = $user->ifUserProfileUpdated($user_id);
                $industry = $user->getIndustryType($profileRow['JOB_INDUSTRY']);
                $jobType = $user->getJobType($profileRow['JOB_TYPE']);
                $experience = $user->getExperienceType($profileRow['JOB_EXPERIENCE']);
                if($updated)
                { 
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Job Title</th>";
                    echo "<td>" . $profileRow['JOB_TITLE'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Industry</th>";
                    echo "<td>" . $industry . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Location</th>";
                    echo "<td>" . $profileRow['JOB_LOCATION'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Job Type</th>";
                    echo "<td>" . $jobType . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Required Skills</th>";
                    echo "<td>" . $profileRow['JOB_SKILLS'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Required Experience</th>";
                    echo "<td>" . $experience . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>Posted Date</th>";
                    echo "<td>" . $profileRow['UPDATED_DATE'] . "</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                else
                {
                    echo "<p> Profile not updated yet </p>"; 
                }
            }
            else if(($type === "R") || ($type === "ADMIN")){
                echo "<p> Selection is a recruiter/admin, no profiles saved.. </p>";
            }
            else{
                echo "<p> Something went wrong! Unable to find user type..</p>";
            }
        } 
        else{
            echo "<p> Something went wrong! User not found..</p>";
        }       
    }    
    else if($_GET['request'] == "getProfileByUserId") /*for editing */
    {
        $user_id = $_GET['user_id'];
        $profileRow = $user->getJSProfileByUserId($user_id);
        $title = $profileRow['JOB_TITLE'];
        $industry = $profileRow['JOB_INDUSTRY'];
        $location = $profileRow['JOB_LOCATION'];
        echo "<h4>". $profileRow['JOB_TITLE'] ."</h4>";                       
        echo "<table>";
            /* User ID - Hidden */
            echo "<tr>"; 
            echo "<input type='hidden' id='user_id' name='user_id' value='$user_id'>";
            echo "</tr>";/* Title */               
            echo "<tr>";
                echo "<th>";
                echo "<label for='title'>Job Title:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='title' name='title' value='$title'>";
                echo "</td>";                
            echo "</tr>";       

            /* Industry */
            echo "<tr>";
                echo "<th>";
                echo "<label for='industry'>Job Industry:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<select id='industry' name='industry' value='$industry'>";
                $industryList = $user->getJobIndustryList();
                foreach($industryList as $industry){
                    echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                }
                echo "</td>";                
            echo "</tr>";     

            /* Location */ 
            echo "<tr>";
                echo "<th>";
                echo "<label for='location'>Job Location Postcode:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<input type='text' id='location' name='location' value='$location'>";
                echo "</td>";                
            echo "</tr>"; 

            /* Job type */ 
            echo "<tr>";
            echo "<th>";
            echo "<label for='jobType'>Job Type:</label></th>";
            echo "</th>";        
            echo "<td>";
            echo "<select id='jobType' name='jobType' value='".$profileRow['JOB_TYPE']."'>";
            $jobTypeList = $user->getJobTypeList();
            foreach($jobTypeList as $jobType){
                echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
            }
            echo "</td>";                
            echo "</tr>";

            /* Skills */
            echo "<tr>";
                echo "<th>";
                echo "<label for='skills'>Skills:</label></th>";
                echo "</th>";        
                echo "<td>";
                echo "<textarea id='skills' name='skills' rows='4' cols='50'>".$profileRow['JOB_SKILLS']."</textarea>";
                echo "</td>";                
            echo "</tr>"; 

            /* Experience */ 
            echo "<tr>";
            echo "<th>";
            echo "<label for='experience'>Experience:</label></th>";
            echo "</th>";        
            echo "<td>";
            echo "<select id='experience' name='experience' value='".$profileRow['JOB_EXPERIENCE']."'>";
            $experienceList = $user->getExperienceList();
            foreach($experienceList as $experience){
                echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
            }
            echo "</td>";                
            echo "</tr>";

            /* Submit */
            echo "<tr>";
            echo "<th>";
            echo "</th>";
            echo "<td>";
            echo "<input type='submit' value='Submit' name='updateProfile'>";
            echo "</td>";  
            echo "</tr>";

        echo "</table>"; 
    }      
    else if($_GET['request'] == "delProfileByUserId"){ 
        $user_id = $_GET['user_id'];        
        $result = $user->deleteJobOfferByUserID($user_id);
        if($result){
            $result = $user->deleteProfile($user_id);
            if($result){
                echo "Deleted Successfully";
            }
            else{            
                echo "Delete Operation Failed! Try Again";
            }
        }
        else{                   
            echo "Delete Operation Failed! Try Again";
        }
    }
}

/* Handle Post request */
if(isset($_POST['updateJob']))
{
    $job_id = test_input($_POST['job_id']);
    $org_name = test_input($_POST['org_name']);
    $org_location = test_input($_POST['org_location']);
    $job_title = test_input($_POST['title']);    
    $job_industry = test_input($_POST['industry']);    
    $job_location = test_input($_POST['location']);
    $job_type = test_input($_POST['jobType']);
    $skills = test_input($_POST['skills']);
    $experience = test_input($_POST['experience']);

    $index_id = $user->updateJobByJobId($job_id, $org_name, $org_location, $job_title, $job_industry, $job_location, $job_type, $skills, $experience);
        if($index_id){
            echo "Updated Successfully";
        }
        else{         
           echo "Update failed, try again";
        }
}
else if(isset($_POST['updateProfile']))
{
    $user_id = test_input($_POST['user_id']);
    $job_title = test_input($_POST['title']);    
    $job_industry = test_input($_POST['industry']);    
    $job_location = test_input($_POST['location']);
    $job_type = test_input($_POST['jobType']);
    $skills = test_input($_POST['skills']);
    $experience = test_input($_POST['experience']);

    $index_id = $user->updateProfileByUserId($user_id, $job_title, $job_industry, $job_location, $job_type, $skills, $experience);
        if($index_id){
            echo "Updated Successfully";
        }
        else{          
           echo "Update failed, try again";
        }
}
?>
