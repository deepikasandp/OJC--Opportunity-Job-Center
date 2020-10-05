<div class="footerMenu" id="myFooterMenu">
  <nav>
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
    <a class="privacy_policy" href="./index.php?id=privacy_policy"> Privacy Policy</a>
    <a class="admin" href="./index.php?id=admin"> Admin</a>
  </nav>
</div>
