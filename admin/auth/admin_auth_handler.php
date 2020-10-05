<?php    
// session_destroy();
session_start();

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

//log error and redirect
function logErrorAndRedirect($error_msg){
    header('Location: ../admin_index.php?error_msg='.$error_msg);    
    exit();
}
  
//Redirect to respective home page
function redirectOnSuccess()
{    
    header('Location: ../admin_index.php');
    exit();
}

// Processing login form data on submit
if(isset($_POST["submit"]))
{    
    $requestingUsertype = test_input($_POST['usertype']);
    $email = test_input($_POST['username']);
    $password = md5(test_input($_POST['password']));

    $database = new DatabaseConfig();
    $db = $database->getConnection();   
    $user = new user($db);

    $error_msg = $user->validateLoginData($email, $password);

    if (empty($error_msg))  /*valid user data*/
    {
      //Retrieve the user account information for the given username.
      $userRow = $user->ifUserExists($email);
      
      //If $row is FALSE.
      if($userRow === false){
        //Could not find a user with that username!
        $error_msg  = "error5"; /*"Username does not exist. Enter a different account or register with us";*/        
        logErrorAndRedirect($error_msg);
      } 
      else
      {
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our OJC_JOB_SEEKER table.
        
        //Compare the passwords, if passwords matched, the login has been successful.
        if($password == $userRow['PASSWORD'])
        {   
            /* Check to determine if the user type('ADMIN') requested is same as registered */
            if($user->validateUserType($userRow['USER_ID'], $requestingUsertype))
            {  
                echo $_POST["username"];
                $_SESSION["username"] = $_POST["username"];
                echo $_SESSION["username"];
                redirectOnSuccess();               
            }
            else{
              /* requested user type doesn't match the registered */     
              $error_msg  = "error7"; /*"Username does not exist. Enter a different account or register with us";*/  
              logErrorAndRedirect($error_msg);              
            }    
        } 
        else
        {
            //if passwords do not match.
            $error_msg = "error6"; /*"Incorrect username / password combination! Try again";*/
            logErrorAndRedirect($error_msg);
        }
      }
    }
}
// Processing logout
if(isset($_GET["id"])){
    if($_GET["id"] === "logOut"){
        if (isset($_SESSION["username"]))
        {
            session_destroy();                
            header('Location: ../admin_index.php');
        }
        else{
            echo"hello";
        }
    }
} 
?>