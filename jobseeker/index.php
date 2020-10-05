<?php
    if (isset($_SESSION["USER_ID"]))
    {
        //echo $_SESSION['USER_ID'];      
        //echo $_SESSION['USER_TYPE'];
        //echo $_SESSION['FIRST_NAME'];
        //echo $_SESSION['LAST_NAME'];
        include('js_home.php'); /* If already logged in */
    }
    else{     
        include('./includes/js_auth_header.php');   
        include('./auth.php'); /* If not logged in */
    }
?>

<script>
    $(document).ready(function(){
        $('.jobSeeker').addClass('active');
        $('.jobSeeker').parent().children('a').not('.jobSeeker').removeClass('active');
    });  
</script>

<script src="./assets/javascript/js_utilities.js"></script>
<script src="./assets/javascript/js_auth_validation.js"></script>
<script src="./assets/javascript/js_updateformValidator.js"></script>
<script src="./assets/javascript/js_home_validation.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>