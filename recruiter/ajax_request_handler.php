<?php
// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');                                     
include_once('../google_distance_matrix/google_distance_matrix.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);
$dm = new DistanceMatrix();

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
            $datetime = $userRow['UPDATED_DATE'];
            $date = date_create($datetime);
            $date = date_format($date,"d/m/Y");
            echo "<td>" . $date . "</td>";
            echo "</tr>";
            echo "</table>";

            $nOffersSent = $user->getNOffers($_GET['job_id']);            
            $offerRows = $user->getOfferDetails($_GET['job_id']);
            $nUser = 1; 
            echo "<h4> Number of offers sent to \"".$userRow['JOB_TITLE']. "\" job is \"" . $nOffersSent . "\"</h4>";
            if($nOffersSent){
                echo "<table>";
                echo "<tr>";
                echo "<th>No</th>";
                echo "<th>Candidate Name</th>";
                echo "<th>Candidate Email Address</th>";
                echo "<th>Offer Subject</th>";
                echo "<th>Offer Message</th>";
                echo "<th>Offer Date</th>";
                echo "</tr>";
                foreach($offerRows as $offerRow) 
                {  
                    $userOfferRow = $user->getUser($offerRow['USER_ID']); 
                    echo "<tr>";
                    echo "<td>" . $nUser . "</td>";
                    echo "<td>" . $userOfferRow['FIRST_NAME']. " " .$userOfferRow['LAST_NAME']. "</td>";
                    echo "<td>" . $userOfferRow['USER_NAME'] . "</td>";
                    echo "<td>" . $offerRow['SUBJECT'] . "</td>";
                    echo "<td><textarea rows='20' cols='100'>" . $offerRow['MESSAGE'] . "</textarea></td>";
                    $datetime = $offerRow['UPDATED_DATE'];
                    $date = date_create($datetime);
                    $date = date_format($date,"d/m/Y");
                    echo "<td>" . $date . "</td>";
                    echo "</tr>";
                    $nUser = $nUser + 1;
                }
                echo "</table>";
            }      
        }
    }
    else if($_GET['request'] == "getOfferData"){
        if(isset($_GET['job_id']))
        {
            $jobDetailRow = $user->getJobDetails($_GET['job_id']);
            $nOffersSent = $user->getNOffers($_GET['job_id']);            
            $rows = $user->getOfferDetails($_GET['job_id']);
            $nUser = 1; 
            echo "<h4> Number of offers sent to \"".$jobDetailRow['JOB_TITLE']. "\" job is \"" . $nOffersSent . "\"</h4>";
            if($nOffersSent){
                echo "<table id='offerDetailsTable'>";                 
                echo "<thead>";           
                echo "<th>No</th>";
                echo "<th>Candidate Name</th>";
                echo "<th>Candidate Email Address</th>";
                echo "<th>Offer Subject</th>";
                echo "<th>Offer Message</th>";
                echo "<th>Offer Date</th>"; 
                echo "</thead>";                
                echo "<tbody>";
                foreach($rows as $row) 
                {  
                    $userRow = $user->getUser($row['USER_ID']); 
                    echo "<tr>";
                    echo "<td>" . $nUser . "</td>";
                    echo "<td>" . $userRow['FIRST_NAME']. " " .$userRow['LAST_NAME']. "</td>";
                    echo "<td>" . $userRow['USER_NAME'] . "</td>";
                    echo "<td>" . $row['SUBJECT'] . "</td>";
                    echo "<td><textarea rows='20' cols='100'>" . $row['MESSAGE'] . "</textarea></td>";
                    $datetime = $row['UPDATED_DATE'];
                    $date = date_create($datetime);
                    $date = date_format($date,"d/m/Y");
                    echo "<td>" . $date . "</td>";
                    echo "</tr>";
                    $nUser = $nUser + 1;
                }               
                echo "</tbody>";                
                echo "<table>";
            }            
        }
    }
    else if($_GET['request'] == "searchCandidates"){
        if(isset($_GET['job_id'])){
            $jobDetails = $user->getJobDetails($_GET['job_id']);
            /* Find the distance using google_distance_matrix API */
            $recruiterLocation = $jobDetails['JOB_LOCATION'];

            $candidateIDs = $user->searchCandidate($jobDetails);
            if($candidateIDs){
                echo "<table>";
                echo "<h4> BELOW MATCHES FOUND <h4> <br>";
                echo "<table>";
                echo "<thead>";
                    echo "<th>Full Name</th>";
                    echo "<th>Email Address</th>";
                    echo "<th>Skills</th>";
                    echo "<th>Candidate Location</th>";
                    echo "<th>Candidate Location Distance From Job Location</th>";                    
                    echo "<th>More Details</th>";
                    echo "<th>Send Offer?</th>";
                echo "</thead>";
                foreach($candidateIDs as $candidateId)
                {
                    $userRow = $user->getUser($candidateId['USER_ID']);
                    $profileRow = $user->getJSProfileByUserId($candidateId['USER_ID']);
                    $jsLocation = $profileRow['JOB_LOCATION'];
                    $distance = $dm->getDistance($recruiterLocation, $jsLocation);
                    $address = $dm->getDestinationAddress($recruiterLocation, $jsLocation);
                    
                    echo "<tbody>";
                        echo "<tr>";
                            echo "<td>" . $userRow['FIRST_NAME'].$userRow['LAST_NAME']. "</td>";
                            echo "<td>" . $userRow['USER_NAME'] . "</td>";
                            echo "<td>" . $profileRow['JOB_SKILLS'] . "</td>";                               
                            echo "<td>" . $address. "</td>";             
                            echo "<td>" . $distance . "</td>";
                            echo "<td><a href='javascript:void(0);' onclick='viewProfileByUserId(" . $candidateId['USER_ID'] . ")'>More Details</a></td>";
                            echo "<td><a href='javascript:void(0);' onclick='sendOfferForm(" . $_GET['job_id'] . "," . $candidateId['USER_ID'] . ")'>CLICK HERE TO SEND OFFER NOW!</a></td>"; 
                        echo "</tr>";
                    echo "</tbody>";
                }
                echo "</table>";
            }
            else{
                echo "<h4>Sorry, No Matches found yet<h4>";
            }
        }
    }
    else if($_GET['request'] == "sendOfferForm")
    {
        if((isset($_GET['job_id'])) && (isset($_GET['user_id'])))
        {  
            $user_id = $_GET['user_id'];
            $job_id = $_GET['job_id'];
                echo "<h4> This is autogenerated template <h4>";
                echo "<h3> You can edit the date and time information in message line! </h3>";
                echo "<table>";
                    /* User ID - Hidden */
                    echo "<tr>"; 
                        echo "<input type='hidden' id='offer_user_id' name='offer_user_id' value='$user_id'>";
                    echo "</tr>";
                    echo "<tr>"; 
                        echo "<input type='hidden' id='offer_job_id' name='offer_job_id' value='$job_id'>";
                    echo "</tr>";
                    $userRow = $user->getUser($user_id);   
                    $name =  $userRow['FIRST_NAME'].' '.$userRow['LAST_NAME'];         
                    /* Subject */
                    echo "<tr>";
                        echo "<th>";
                            echo "<label for='offer_subject'>Subject:</label></th>";
                        echo "</th>";        
                        echo "<td>";
                            echo "<input type='text' id='offer_subject' name='offer_subject' value='Offer Letter'>";
                        echo "</td>";                
                    echo "</tr>";            
                    /* Message */       
                    echo "<tr>";
                        echo "<th>";
                            echo "<label for='offer_message'>Message:</label></th>";
                        echo "</th>";        
                        echo "<td>";
                            $jobDetails = $user->getJobDetails($job_id);  
                            $jobLocation = $jobDetails['JOB_LOCATION'];
                            $address = $dm->getDestinationAddress($jobLocation, $jobLocation);     
                            $industry = $jobDetails['JOB_INDUSTRY'];
                            $title = $jobDetails['JOB_TITLE'];
                            $location = $address;
                            $recruiterRow = $user->getUser($jobDetails['USER_ID']);
                            $contact = $recruiterRow['USER_NAME'];
                            $recruiterName = $recruiterRow['FIRST_NAME'].' '.$recruiterRow['LAST_NAME'];
                            $orgName = $jobDetails['ORG_NAME'];
                            $radius = 0;
                            echo "<textarea id='offer_message' name='offer_message' rows='20' cols='100'>";
                                echo "Dear $name,&#13;&#10;";
                                echo "&#13;&#10;Job Title: $title position.&#13;&#10;";
                                echo "Further to your application in the job site, I would be delighted if you could attend an interview on (date) at (time) at $orgName, $location.&#13;&#10;";
                                echo "Please write to $contact to confirm that you are able to attend. &#13;&#10;";
                                echo "I look forward to seeing you.&#13;&#10;";
                                echo "&#13;&#10;Yours sincerely,&#13;&#10;";
                                echo "$recruiterName&#13;&#10;";
                            echo "</textarea>";
                        echo "</td>";                
                    echo "</tr>";
                    /* Submit */
                    echo "<tr>";
                        echo "<th>";
                            echo "<label for='offer_submit'>CLICK HERE TO SEND:</label></th>";
                        echo "</th>";
                        echo "<td>";
                            echo "<input type='submit' value='SEND' name='sendOfferMail'>";
                        echo "</td>";  
                    echo "</tr>";
                echo "</table>";
        }
        else
        {
            echo "<h4>Sorry, Unable to process request, please try again.<h4>";
        }
    } 
    else if($_GET['request'] == "viewProfileByUserId") /* for read-only */
    {
        $user_id = $_GET['user_id'];
        /* find if he is a job seeker or recruiter */
        $userRow = $user->getUser($user_id);
        if($userRow)
        {
            $profileRow = $user->getJSProfileByUserId($user_id);             
            $industry = $user->getIndustryType($profileRow['JOB_INDUSTRY']);
            $jobType = $user->getJobType($profileRow['JOB_TYPE']);
            $experience = $user->getExperienceType($profileRow['JOB_EXPERIENCE']);
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
            echo "<th>Location</th>";
            echo "<td>" . $profileRow['JOB_LOCATION'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Job Type</th>";
            echo "<td>" . $jobType . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Skills</th>";
            echo "<td>" . $profileRow['JOB_SKILLS'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Experience</th>";
            echo "<td>" . $experience . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Posted Date</th>";
            $datetime = $profileRow['UPDATED_DATE'];
            $date = date_create($datetime);
            $date = date_format($date,"d/m/Y");
            echo "<td>" . $date . "</td>";
            echo "</tr>";
            echo "</table>";
        } 
        else{
            echo "<p> Something went wrong! User not found..</p>";
        }       
    } 
    else if($_GET['request'] == "insertOffer") /* to be deleted */
    {
        $user_id = test_input($_GET['offer_user_id']);
        $job_id = test_input($_GET['offer_job_id']);    
        $subject = test_input($_GET['offer_subject']);    
        $message = test_input($_GET['offer_message']);
    
        $index_id = $user->insertJobOffer($user_id, $job_id, $subject, $message);
        if($index_id){
            echo "Updated Successfully";
        }
        else{           
            echo "Update failed, try again";
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

if(isset($_POST['sendOfferMail']))
{
    $user_id = test_input($_POST['offer_user_id']);
    $job_id = test_input($_POST['offer_job_id']);    
    $subject = test_input($_POST['offer_subject']);    
    $message = test_input($_POST['offer_message']);

    $index_id = $user->insertJobOffer($user_id, $job_id, $subject, $message);
    if($index_id){
        echo "Thanks! ";
    }
    else{        
        echo "Offer Update failed, try again";
    }  

    /* update the input to the phpmail variables */      
    $userRow = $user->getUser($user_id);
    $recipient = $userRow['USER_NAME']; 
    $subject = $subject;    
    $bodyText = $message;
    $bodyHtml = "<p>". $message. "</p>";
    include ("../phpmailer.php");
}
?>