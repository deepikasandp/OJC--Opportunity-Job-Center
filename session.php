<?php
//Set session variables
function setSession($user_id,$user_type, $fname, $lname){
  //Provide the user with a login session.
  $_SESSION['USER_ID'] = $user_id;        
  $_SESSION['USER_TYPE'] = $user_type;       
  $_SESSION['FIRST_NAME'] = $fname;       
  $_SESSION['LAST_NAME'] = $lname; 
 
  echo $_SESSION['USER_ID'];      
  echo $_SESSION['USER_TYPE'];       
  echo $_SESSION['FIRST_NAME'];     
  echo $_SESSION['LAST_NAME'];
}

function destroySession(){
    // Unset all of the session variables.
    $_SESSION = array();
    unset($_SESSION["USER_ID"]);
    unset($_SESSION["USER_TYPE"]);
    unset($_SESSION["FIRST_NAME"]);
    unset($_SESSION["LAST_NAME"]);
    // Finally, destroy the session.
    session_destroy();
}
?>