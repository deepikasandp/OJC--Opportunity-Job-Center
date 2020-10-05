<?php

// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');

// Utility function to validate the form data
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST["updateJobVacancy"]))
{
    $user_id = test_input($_POST['user_id']);
    $org_name = test_input($_POST['org_name']);
    $org_location = test_input($_POST['org_location']);
    $job_title = test_input($_POST['title']);    
    $job_industry = test_input($_POST['industry']);    
    $job_location = test_input($_POST['location']);
    $job_type = test_input($_POST['jobType']);
    $skills = test_input($_POST['skills']);
    $experience = test_input($_POST['experience']);

    /* Create database and user object to handle the job request */
    $database = new DatabaseConfig();
    $db = $database->getConnection();   
    $user = new user($db);

    /* validate the data */
    $error_msg = $user->validateJobData($user_id, $org_name, $org_location, $job_title, $job_industry, $job_location, $job_type, $skills, $experience);

    if (empty($error_msg))  /*valid user data*/
    {
        $index_id = $user->insertNewJob($user_id, $org_name, $org_location, $job_title, $job_industry, $job_location, $job_type, $skills, $experience);
        if($index_id){
            header('Location: ../index.php?id=r_home&update=success');
        }
        else{
            $error_msg = "error2";
            header('Location: ../index.php?id=r_home&update=failure&error_msg='.$error_msg);
           // echo $index_id;
        }
    }
    else
    {
        /*
        echo $user_id;
        echo $org_name;
        echo $org_location;
        echo $job_title;
        echo $job_industry;
        echo $job_location;
        echo $job_type;
        echo $skills;
        echo $experience;*/
        header('Location: ../index.php?id=r_home&update=failure&error_msg='.$error_msg);
    }    
}
?>
