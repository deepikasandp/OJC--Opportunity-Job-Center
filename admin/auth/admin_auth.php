<?php 
    session_start();
    if (isset($_SESSION["username"]))
    {          
        include('./includes/admin_home_header.php'); 
        include('./home/admin_home.php'); 
    }
    else{ 
        include('./includes/admin_header.php'); 
        include('../admin/auth/admin_login.php');
    }  
    
?>