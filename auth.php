<?php
if(isset($_GET["id"])) 
{
    $myId = $_GET["id"];
}
include('./google_Oauth/google_auth_handler.php'); 
?>
<div class="main">
    <div class="auth-container">
        <a id="loginLink" class="auth-item auth-item-left active" href="javascript:void(0);" onClick="showLoginForm()">Login</a>
        <a id="registerLink" class="auth-item auth-item-right" href="javascript:void(0);" onClick="showRegisterForm()">Register</a>            
    </div>
    <div class="auth-form">   
        <form id="loginForm" class="show" onsubmit="return loginFormvalidation(this);" action="./auth_handler.php" method="post">
            <div class="form-container">                                                     
                <h3 class="form-item msg">Login Using Your Social Media Account or Login Manually</h3>
                <div class="form-item-left">                    
                <button type="button" class="button" onclick="window.location.href='index.php?id=google_auth_request&type=<?php echo $_GET['id']?>'"><i class="fa fa-google" aria-hidden="true">  Login With Google</i></button>
                </div>  

                <div class="form-item-right">
                    <span id="loginErrorMsg">
                       <?php  
                        if(isset($_GET['type'])){
                            $type = $_GET['type'];
                            if($type == 'login'){
                                if(isset($_GET['error_msg'])){
                                    $loginCheck = $_GET['error_msg'];

                                    if($loginCheck == "error1"){                                
                                        echo "Invalid email format! Try again!";
                                    }
                                    else if($loginCheck == "error2"){                                
                                        echo "Username is required! Try again!";
                                    }
                                    else if($loginCheck == "error3"){
                                        echo "Password is required! Try again!";
                                    }   
                                    else if($loginCheck == "error5"){
                                        echo "Username does not exist. Enter a different account or register with us!";
                                    }
                                    else if($loginCheck == "error6"){
                                        echo "Incorrect username / password combination! Try again!";
                                    }
                                    else if($loginCheck == "error7"){
                                        $myId = $_GET["id"];
                                        if($myId == "r_auth")
                                        {
                                            echo "This account is registered as a Job Seeker. Please click on JobSeeker menu to login!";
                                        }
                                        else if($myId == "js_auth")
                                        {
                                            echo "This account is registered as a Recruiter. Please click on Recruiter menu to login!";
                                        }
                                    }
                                }
                            }
                        }
                        ?>                        
                    </span>                    
                    <span class="error">* required field</span>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Email Address" autocomplete="off">
                    <span class="error_mark">*</span>
                    <span id="errorMsg1"></span>               
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <span class="error_mark">*</span>
                    <span id="errorMsg2"></span>               
                    <input type="checkbox" name="showPassword" id="showPassword" value="1" onClick="tooglePassword()">
                    <label for="showPassword">Show Password </label>
                    <?php
                    if(isset($_GET["id"])) 
                    {
                        $myId = $_GET["id"];
                        if(($myId == "jobseeker") || ($myId == "js_auth"))
                        {
                        ?>
                            <input type="hidden" id="usertype" name="usertype" value="JS">
                        <?php
                        }
                        elseif(($myId == "recruiter") || ($myId == "r_auth"))
                        {
                        ?>
                            <input type="hidden" id="usertype" name="usertype" value="R">
                        <?php  
                        }
                    }
                    ?>
                    <input type="submit" value="Submit" name="loginRequest" id="login">
                    <label for="login">Are you a new user?</label>
                    <a id="redirect" href="javascript:void(0);" onClick="showRegisterForm()">Register Here!</a>
                </div>
            </div>              
        </form>

        <form id="registerForm" class="hide" onsubmit="return registerFormValidation(this);" action="./auth_handler.php" method="post"> 
            <div class="form-container">                                                                           
                <h3 class="form-item msg">Register Using Your Social Media Account or Register Manually</h3>
                <div class="form-item-left">                                       
                    <button type="button" class="button" onclick="window.location.href='index.php?id=google_auth_request&type=<?php echo $_GET['id']?>'"><i class="fa fa-google" aria-hidden="true">  Login With Google</i></button>
                </div>  

                <div class="form-item-right">
                    <span id="registerErrorMsg">
                       <?php
                        if(isset($_GET['type'])){
                            $type = $_GET['type'];
                            if($type == 'register'){
                                if(isset($_GET['error_msg'])){
                                    $loginCheck = $_GET['error_msg'];

                                    if($loginCheck == "error1"){                                
                                        echo "First Name is required! Try again!";
                                    }
                                    else if($loginCheck == "error2"){                                
                                        echo "Last Name is required! Try again!";
                                    }
                                    else if($loginCheck == "error3"){                                
                                        echo "Invalid email format! Try again!";
                                    }
                                    else if($loginCheck == "error4"){                                
                                        echo "Username is required! Try again!";
                                    }
                                    else if($loginCheck == "error5"){
                                        echo "Password is required! Try again!";
                                    }                            
                                    else if($loginCheck == "error6"){
                                        echo "Passwords should be same! Try again!!";
                                    }
                                    else if($loginCheck == "error7"){
                                        echo "User already exists! Enter a different account or login with us!";
                                    }
                                    else if($loginCheck == "error8"){
                                        echo "Incorrect username / password combination! Try again!";
                                    }
                                }
                            }
                        }
                        ?>                        
                    </span>                    
                    <span class="error">* required field</span>
                    <label for="r_fname">First Name:</label>
                    <input type="text" id="r_fname" name="r_fname" placeholder="First Name" autocomplete="off">
                    <span class="error_mark">*</span>
                    <label for="r_lname">Last Name:</label>
                    <input type="text" id="r_lname" name="r_lname" placeholder="Last Name" autocomplete="off">
                    <span class="error_mark">*</span>
                    <label for="r_username">Username:</label>
                    <input type="text" id="r_username" name="r_username" placeholder="Email Address" autocomplete="off">
                    <span class="error_mark">*</span>
                    <span id="r_errorMsg1"></span>                              
                    <label for="password">Password:</label>
                    <input type="password" id="r_password" name="r_password" placeholder="Password">
                    <span class="error_mark">*</span>
                    <span id="r_errorMsg2"></span>               
                    <label for="r_conf_password">Confirm Password:</label>
                    <input type="password" id="r_conf_password" name="r_conf_password" placeholder="Password">
                    <span class="error_mark">*</span>
                    <span id="r_errorMsg3"></span>               
                    <input type="checkbox" name="r_showPassword" id="r_showPassword" value="1" onClick="toogleRegisterPassword()">
                    <label for="r_showPassword">Show Password </label><?php
                    if(isset($_GET["id"])) 
                    {
                        $myId = $_GET["id"];
                        if(($myId == "jobseeker")|| ($myId == "js_auth"))
                        {
                        ?>
                            <input type="hidden" id="r_usertype" name="r_usertype" value="JS">
                        <?php
                        }
                        elseif(($myId == "recruiter") || ($myId == "r_auth"))
                        {
                        ?>
                            <input type="hidden" id="r_usertype" name="r_usertype" value="R">
                        <?php  
                        }
                    }
                    ?>
                    <input type="submit" value="Register" name="registerRequest" id="register">
                    <label for="register">Already registered with us?</label>
                    <a id="r_redirect" href="javascript:void(0);" onClick="showLoginForm()">Login Here!</a>
                </div>  
            </div>              
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        <?php 
        if(isset($_GET["type"]))
        { 
            $type = $_GET["type"];
            if($type === "login") 
            {?>
                var loginId = document.getElementById('loginForm');
                var registerId = document.getElementById('registerForm');
                var loginLink = document.getElementById('loginLink');
                var registerLink = document.getElementById('registerLink');
                var contains;

                loginId.className = 'show';
                registerId.className = 'hide';

                contains = registerLink.classList.contains("active");
                if(contains)
                {
                    registerLink.classList.remove('active');
                }
                contains = loginLink.classList.contains("active");
                if(!contains){
                    loginLink.classList.add('active');
                }
       <?php
            }
            else if($type === "register")
            {?>            
                var loginId = document.getElementById('loginForm');
                var registerId = document.getElementById('registerForm');
                var loginLink = document.getElementById('loginLink');
                var registerLink = document.getElementById('registerLink');
                var contains;

                registerId.className = 'show';            
                loginId.className = 'hide';

                contains = loginLink.classList.contains("active");
                if(contains)
                {
                    loginLink.classList.remove('active');
                }
                contains = registerLink.classList.contains("active");
                if(!contains){
                    registerLink.classList.add('active');
                }<?php
            }
        }?>
    });
</script>