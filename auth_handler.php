<?php
session_start();

// Include config file
include_once('config/databaseConfig.php');
include_once('object/user.php');
include_once('session.php');

// Utility function to validate the form data
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//log error and redirect
function logErrorAndRedirect($error_msg, $userType, $requestType){
  if($userType == "JS"){
    header('Location: ./index.php?id=js_auth&error_msg='.$error_msg.'&type='.$requestType);
  }
  else{        
    header('Location: ./index.php?id=r_auth&error_msg='.$error_msg.'&type='.$requestType);
  }
  exit();
}

//Redirect to respective home page
function redirectOnSuccess($user_type)
{
  if($user_type == "JS"){
    header('Location: ./index.php?id=js_home');
  }
  else{
    header('Location:./index.php?id=r_home');
  }
  exit();
}

// Processing login form data on submit
if(isset($_POST["loginRequest"]))
{  
    $requestingUsertype = test_input($_POST['usertype']);
    $email = test_input($_POST['username']);
    $password = md5(test_input($_POST['password']));
    $requestType = "login";

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
        logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);
      } 
      else
      {
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our OJC_JOB_SEEKER table.
        
        //Compare the passwords, if passwords matched, the login has been successful.
        if($password == $userRow['PASSWORD']){  
            /* Check to determine if the user type('JS', 'R', 'ADMIN') requested is same as registered */
            if($user->validateUserType($userRow['USER_ID'], $requestingUsertype))
            {  
              setSession($userRow['USER_ID'], $requestingUsertype, $userRow['FIRST_NAME'], $userRow['LAST_NAME']); 
              redirectOnSuccess($requestingUsertype);              
            }
            else{
              /* requested user type doesn't match the registered */     
              $error_msg  = "error7"; /*"Username does not exist. Enter a different account or register with us";*/  
              logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);              
            }
        } else
        {
            //if passwords do not match.
            $error_msg = "error6"; /*"Incorrect username / password combination! Try again";*/
            logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);
        }
      }
    }
    else{
      logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);
    }
}
// Processing register form data on submit
else if(isset($_POST["registerRequest"]))
{  
    $requestingUsertype = $_POST['r_usertype'];
    $fname = test_input($_POST['r_fname']);
    $lname = test_input($_POST['r_lname']);
    $email = test_input($_POST['r_username']);
    $password = md5(test_input($_POST['r_password']));
    $confirmPassword = md5(test_input($_POST['r_conf_password']));
    $requestType = "register";

    $database = new DatabaseConfig();
    $db = $database->getConnection();   
    $user = new user($db);

    $error_msg = $user->validateRegisterData($fname, $lname, $email, $password, $confirmPassword);

    if (empty($error_msg)) /*valid user data*/
    {
      //Retrieve the user account information for the given username.
      $userRow = $user->ifUserExists($email);

      //If $row is FALSE.
      if($userRow == false){
        //New user, insert the username and password into the database.
        $userId = $user->insertUser($fname, $lname, $email, $password, $requestingUsertype);
        if ($userId)
        {
          //Provide the user with a login session.          
          setSession($userId, $requestingUsertype, $fname, $lname); 
          redirectOnSuccess($requestingUsertype); 
        }
      } 
      else
      { 
        //User account found.
        $error_msg  = "error5"; /*"User already exists.";*/
        logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);
      }
    }
    else{      
      logErrorAndRedirect($error_msg, $requestingUsertype, $requestType);
    }
}
else{  
  header('Location: ./index.php');
}
?>