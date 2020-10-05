<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Home</title>    
    <link rel="stylesheet" href="./assets/css/main.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/nav_header.css" type="text/css">    
    <link rel="stylesheet" href="./assets/css/nav_footer.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/header.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/auth.css" type="text/css">  
    <link rel="stylesheet" href="./assets/css/js_home.css" type="text/css">     
    <link rel="stylesheet" href="./assets/css/r_home.css" type="text/css">       
    <link rel="stylesheet" href="./assets/css/partners.css" type="text/css">      
    <link rel="stylesheet" href="./assets/css/job_search.css" type="text/css">     
    <link rel="stylesheet" href="./assets/css/contact.css" type="text/css">           
    <link rel="stylesheet" href="./assets/css/mail.css" type="text/css"> 
    <link rel="stylesheet" href="./assets/css/partners.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/image-gallery.css" type="text/css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/219be7d205.js" crossorigin="anonymous"></script> 
    <script src="./assets/javascript/contact.js"></script>   
    <script src="./assets/javascript/partners.js"></script>  
    <script src="./assets/javascript/job_search.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function(){
            $('.home').addClass('active');
            $('.home').parent().children('a').not('.home').removeClass('active');
        });  
    </script>
</head>
<body>
    <!-- Start of Top Navigation Menu Section -->
    <?php include './includes/nav_header.php' ?>
    <script>
        $(document).ready(function(){
            if ((isset($_SESSION["USER_ID"])) || (isset($_SESSION["USER_ID"])))
            {
                $('.logOut').removeClass('hide_logOut');
                $('.logOut').addClass('show_logOut');
            }
            else{                
                $('.logOut').removeClass('show_logOut');
                $('.logOut').addClass('hide_logOut');
            }
        });  
    </script>
    <!-- End of Top Navigation Menu Section -->
    
    <!-- Start of Main Section -->
    <?php     
        if(isset($_GET["id"])) {
            $myId = $_GET["id"];
            if($myId === "jobseeker") {
                include('./jobseeker/index.php');
            } 
            else if($myId === "recruiter") {
                include('./recruiter/index.php'); 
            }
            else if($myId === "home"){
                include('home.php');
            }
            else if($myId === "contact"){
                /*header("Location:contact.php");*/
                include('./contact/contact.php');
            }
            else if($myId === "jobSearch"){
                include('./jobseeker/job_search.php');
            }
            else if($myId === "company1"){
                include('./partner/partners.php');
            }
            else if($myId === "company2"){
                include('./partner/partners.php');
            }
            else if($myId === "company3"){
                include('./partner/partners.php');
            }
            else if($myId === "company4"){
                include('./partner/partners.php');
            }
            else if($myId === "js_home"){
                include('./jobseeker/index.php');
            }
            else if($myId === "js_auth"){                
                include('./jobseeker/index.php');
            }
            else if($myId === "r_home"){
                include('./recruiter/index.php');
            }
            else if($myId === "r_auth"){                
                include('./recruiter/index.php');
            }
            else if($myId === "logOut"){
                include('session.php');
                if(isset($_SESSION['USER_ID'])){
                    $USER_TYPE = $_SESSION["USER_TYPE"];
                    // Unset all of the session variables.
                    destroySession();
                    if($USER_TYPE == "JS") {
                        header('Location: ./index.php?id=js_auth');
                        exit();
                    } 
                    else if($USER_TYPE == "R") {
                        header('Location: ./index.php?id=r_auth');
                        exit();
                    }   
                    else {
                        header('Location: ./index.php?id=home');
                        exit();
                    }                     
                }
            }
            else if($myId === "google_auth_request"){ 
                if($_GET['type'] == "jobseeker" || $_GET['type'] == "js_auth"){
                    $user_type = "JS"; 
                    /* Set Cookie to hold user request data */
                    setUserType("userType", $user_type);
                    include('./google_Oauth/index.php');
                    header("Location:$login_button");
                }
                else if($_GET['type'] == "recruiter" || $_GET['type'] == "r_auth"){                     
                    $user_type = "R";  
                    /* Set Cookie to hold user request data */
                    setUserType("userType", $user_type);
                    include('./google_Oauth/index.php');
                    header("Location:$login_button");
                }
            } 
            else if($myId === "google_response_redirect"){ 
                if(isset($_COOKIE['userType']) == 'JS'){
                    //echo $_COOKIE['userType'];
                    include('./google_Oauth/google_auth_handler.php');
                }
                else if(isset($_COOKIE['userType']) == 'R'){  
                    //echo $_COOKIE['userType'];  
                    include('./google_Oauth/google_auth_handler.php');
                }
            }
            else if($myId === "admin"){
                header('Location: ./admin/index.php');
                exit();
            }
            else if($myId === "privacy_policy"){                
                include('./privacy_policy.php');
            }
        }
        else{
            include('home.php');
        }

        function setUserType($name, $value){
            setcookie($name, $value, time() + (86400 * 30), "/");
        }
    ?>
    <!-- Start of Main Section -->

     <!-- Start of Footer Navigation Menu Section -->
     <?php include './includes/nav_footer.php' ?>
     <!-- End of Top Navigation Menu Section -->
</body>
</html>