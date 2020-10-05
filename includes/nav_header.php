<?php
    session_start();
?>
 <div class="menu" id="myMenu">
    <a href="./index.php?id=home" class="menu-logo"><img src="./assets/img/svg/ojc.svg" alt="OJC" ><span>Opportunity Job Center</span></a>
    <nav class="menu-right">
      <a class="home" href="./index.php?id=home"> Home</a>
      <?php 
        if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "JS")){?>
          <a class="jobSeeker" href="./index.php?id=jobseeker"> Job Seeker</a>
        <?php }
        else if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "R")){
        }
        else{?>
          <a class="jobSeeker" href="./index.php?id=jobseeker"> Job Seeker</a>
       <?php } 
      ?>
      <?php 
        if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "R")){?>
          <a class="recruiter" href="./index.php?id=recruiter"> Recruiter</a>
        <?php }
        else if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "JS")){
        }
        else{?>
          <a class="recruiter" href="./index.php?id=recruiter"> Recruiter</a>
       <?php } 
      ?>
      <?php 
        if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "JS")){?>          
          <a class="jobSearch" href="./index.php?id=jobSearch"> Job Search</a>
        <?php }
      ?>
      <a class="contact" href="./index.php?id=contact"> Contact</a>
      <?php 
        if(isset($_SESSION['USER_ID'])){?>
          <a class="logOut" href="./index.php?id=logOut">Log Out</a>
        <?php }
          ?>
    </nav>

    <a href="javascript:void(0);" class="icon" onclick="toogleMenu()">
      <i class="fa fa-bars"></i>
    </a>
</div>
<script>
    function toogleMenu() 
    {
        var myMenuId = document.getElementById('myMenu');
        if (myMenuId.className === 'menu') {
          myMenuId.className += ' responsive';
        } else {
          myMenuId.className = 'menu';
        }
    }
</script>