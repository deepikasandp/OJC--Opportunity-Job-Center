<?php
    if (isset($_SESSION["USER_ID"]))
    {
        //echo $_SESSION['USER_ID'];      
        //echo $_SESSION['USER_TYPE'];
        include('r_home.php'); /* If already logged in */
    }
    else{  
        include('./includes/r_auth_header.php');      
        include('./auth.php'); /* If not logged in */
    }
?>

<script>
        $(document).ready(function(){
            $('.recruiter').addClass('active');
            $('.recruiter').parent().children('a').not('.recruiter').removeClass('active');
        });  
</script>

<script type="text/javascript" src="./assets/javascript/r_auth_validation.js"></script>
<script type="text/javascript" src="./assets/javascript/r_home_validation.js"></script>
<script type="text/javascript" src="./assets/javascript/r_updateformValidator.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./assets/javascript/r_utilities.js"></script>