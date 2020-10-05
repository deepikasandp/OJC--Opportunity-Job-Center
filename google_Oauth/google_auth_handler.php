<?php
// Include config file                    
include('./google_Oauth/index.php');
include_once('./config/databaseConfig.php');
include_once('./object/user.php');
include_once('./session.php');

function redirectOnSuccess($user_type)
{
  if($user_type == "JS"){
    header('Location: ./index.php?id=js_home');
  }
  else{
    header('Location: ./index.php?id=r_home');
  }
  exit();
}

if(isset($_GET['code'])) 
{   // it will attempt to exchange a code for an valid authentication token
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // this condition will check there is any error occure  during getting authentication token
    if(!isset($token['error'])) {
        // set the token used for request
        $google_client->setAccessToken($token['access_token']);
        $google_service = new Google_Service_Oauth2($google_client);
        // get user profile data from google
        $data =  $google_service->userinfo->get();

        /* update the user table with data from google in the database */
        $database = new DatabaseConfig();
        $db = $database->getConnection();   
        $user = new user($db);

        /* check if the user is already registered */
        $userRow = $user->ifUserExists($data['email']);
        if($userRow) /* If user already exists */
        {
            $user_id = $userRow['USER_ID'];
            $user_type = $_COOKIE['userType'];
            //setSession($userRow['USER_ID'], $user_type, $userRow['FIRST_NAME'], $userRow['LAST_NAME']); 
            
            $_SESSION['USER_ID'] = $user_id;        
            $_SESSION['USER_TYPE'] = $user_type;     
            $_SESSION['FIRST_NAME'] = $userRow['FIRST_NAME'];       
            $_SESSION['LAST_NAME'] = $userRow['LAST_NAME'];
 
            echo $_SESSION['USER_ID'];      
            echo $_SESSION['USER_TYPE'];
            echo $_SESSION['FIRST_NAME'];      
            echo $_SESSION['LAST_NAME'];
            redirectOnSuccess($user_type);              
        }else{
            $password = md5("GOOGLEUSER");            
            $user_type = $_COOKIE['userType'];
            $user_id = $user->insertUser($data['given_name'], $data['family_name'], $data['email'], $password, $user_type);
            
            //setSession($userRow['USER_ID'], $user_type, $userRow['FIRST_NAME'], $userRow['LAST_NAME']); 
            $_SESSION['USER_ID'] = $user_id;        
            $_SESSION['USER_TYPE'] = $user_type;    
            $_SESSION['FIRST_NAME'] = $userRow['FIRST_NAME'];       
            $_SESSION['LAST_NAME'] = $userRow['LAST_NAME'];
           
            echo $_SESSION['USER_ID'];      
            echo $_SESSION['USER_TYPE'];  
            echo $_SESSION['FIRST_NAME'];      
            echo $_SESSION['LAST_NAME'];
            redirectOnSuccess($user_type);
        }

        /* Set session variables */
        // below you can find get profile data and store into session 
        /*
        $_SESSION['access_token']  = $token['access_token'];

        if(!empty($data['given_name'])) {

            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($data['picture'])) {
            $_SESSION['image'] = $data['picture'];
        }
        */
    }
}
/*
//   here you are checking user has login into system with this google account or not
if(!isset($_SESSION['access_token'])) {
    // create a url to obtain user auth
    $login_button = '<a href="'. $google_client->createAuthUrl() .'" class="button">Login With Google</a>';
}*/
?>