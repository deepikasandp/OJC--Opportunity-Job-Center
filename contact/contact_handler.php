<!--https://phppot.com/jquery/php-contact-form-with-jquery-ajax/ -->
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

    if(isset($_POST["contactSubmit"]))
    {
        $name = test_input($_POST['name']);
        $email = test_input($_POST['email']);
        $subject = test_input($_POST['subject']);    
        $message = test_input($_POST['message']); 
    
        /* Create database and user object to handle the job request */
        $database = new DatabaseConfig();
        $db = $database->getConnection();   
        $user = new user($db);

        $error_msg = $user->validateContactForm($name, $email, $subject, $message);
        if (empty($error_msg))  /*valid user data*/
        {
            $index_id = $user->insertContactForm($name, $email, $subject, $message);
            if($index_id){
                $updateStatus = "success";
            }
            else{
                $updateStatus = "failure";
            }
            echo "$updateStatus";
        }
        else{
            echo "$error_msg";
            $updateStatus = "$error_msg";
        }        

        /* update the input to the phpmail variables */
        $recipient = 'enquiriesOJC@gmail.com';
        $subject = $subject;    
        $bodyText = $message;
        $bodyHtml = $message;
        include ("../phpmailer.php");    
    }
?>