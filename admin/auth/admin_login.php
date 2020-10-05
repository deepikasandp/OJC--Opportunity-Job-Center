<div class="main">
    <form id="adminLogin" class="adminLogin-container" onsubmit="return adminLoginValidate(this);" 
    action="../admin/auth/admin_auth_handler.php" method="post">        
        <h4> LOGIN </h4>
        <span id="loginErrorMsg">
            <?php 
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
                    echo "This account is not registered with admin rights!";
                }
            }
            ?>                        
        </span>  
        <p class="error_mark">* required field</p>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Email Address">
        <span class="error_mark">*</span>
        <span id="usernameError"></span>               
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password">
        <span class="error_mark">*</span>
        <span id="passwordError"></span>               
        <input type="checkbox" name="showPassword" id="showPassword" value="1" onClick="tooglePassword()">
        <label for="showPassword">Show Password </label>
        <input type="hidden" id="usertype" name="usertype" value="ADMIN">
        <input type="submit" value="Submit" name="submit">
    </form>
</div>
