// JavaScript validation of login, registration forms
var message = null;                                             // Store error message

/* Helper function to validate forms */
function validateUsername(username){
    var result = true;
    if (username == "")
    {
        message = "Username is required";
        result = false;
        console.log(message);
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(username)))
    {
        message = "Please enter a valid email address";
        result = false;
        console.log(message);
    }
    return result;
}

function validatePassword(password){
    var result = true;
    if (password == "")
    {
        message = "Password is required";
        result = false;
        console.log(message);
    }
    else if(password.length < 8){
        message = "Please make sure your password has at least 8 characters";
        result = false;
        console.log(message);
    }    
    return result;
}

function validateConfPassword(password1, password2){
    var result = true;
    if (password2 == "")
    {
        message = "Confirm Password is required";
        result = false;
        console.log(message);
    }
    else if(password1 != password2) {
        message = "Passwords Don't Match";
        result = false;
        console.log(message);
    }
    return result;
}

function showErrorMessage(el) {
    el.textContent = message;
}

function removeErrorMessage(el) {    
    el.textContent = null;
 }

/* Validate Login Form */
function loginFormvalidation(form)
{
    var username = form["username"].value;                      // Get entered username value
    var password = form["password"].value;                      // Get entered password value
    var usernameMsg = document.getElementById("errorMsg1");     // Find errormessage1 element       
    var passwordMsg = document.getElementById("errorMsg2");     // Find errormessage2 element
    var valid = {};                                             // Valid object
    var isValid;                                                // isvalid:check form controls
    var isFormValid;                                            // isFormValid:checks entire form
    console.log("Funcion Invoked");
    //Validate Username
    isValid = validateUsername(username);
    valid[username] = isValid;   // Add element to the valid object
    if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(usernameMsg);   // Show error messages
    } else {                           // Otherwise
        removeErrorMessage(usernameMsg); // Remove error messages
    } 

    //Validate Password
    isValid = validatePassword(password);
    valid[password] = isValid;   // Add element to the valid object
    if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(passwordMsg);   // Show error messages
    } else {                           // Otherwise
        removeErrorMessage(passwordMsg); // Remove error messages
    }     
    
    //Did the validation pass, can it submit the form?
      // Loop through valid object, if there are errors set isFormValid to false
      for (var field in valid) {          // Check properties of the valid object
        if (!valid[field]) {              // If it is not valid
          isFormValid = false;            // Set isFormValid variable to false
          break;                          // Stop the for loop, an error was found
        }                                 // Otherwise
        isFormValid = true;               // The form is valid and OK to submit
      }
      console.log(isFormValid);
      return isFormValid;
}

function registerFormValidation(form)
{
    var username = form["r_username"].value;                      // Get username value
    var password1 = form["r_password"].value;                      // Get password value
    var password2 = form["r_conf_password"].value;            // Get conf-password value
    var usernameMsg = document.getElementById("r_errorMsg1");     // Find errormessage1 element       
    var passwordMsg1 = document.getElementById("r_errorMsg2");     // Find errormessage2 element      
    var passwordMsg2 = document.getElementById("r_errorMsg3");     // Find errormessage3 element
    var valid = {};                                             // Valid object
    var isValid;                                                // isvalid:check form controls
    var isRegisterFormValid;                                    // isFormValid:checks entire form

    //Validate Username
    isValid = validateUsername(username);
    valid[username] = isValid;   // Add element to the valid object
    if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(usernameMsg);   // Show error messages
    } else {                           // Otherwise
        removeErrorMessage(usernameMsg); // Remove error messages
    } 

    //Validate Password
    isValid = validatePassword(password1);
    valid[password1] = isValid;   // Add element to the valid object
    if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(passwordMsg1);   // Show error messages
    } else {                           // Otherwise
        removeErrorMessage(passwordMsg1); // Remove error messages
    }
    
    //validate conf-Password
    isValid = validateConfPassword(password1, password2);
    valid[password2] = isValid;   // Add element to the valid object
    if (!isValid) {                    // If it does not pass these two tests
        showErrorMessage(passwordMsg2);   // Show error messages
    } else {                           // Otherwise
        removeErrorMessage(passwordMsg2); // Remove error messages
    }

    //Did the validation pass, can it submit the form?
      // Loop through valid object, if there are errors set isFormValid to false
      for (var field in valid) {          // Check properties of the valid object
        if (!valid[field]) {              // If it is not valid
            isRegisterFormValid = false;            // Set isFormValid variable to false
          break;                          // Stop the for loop, an error was found
        }                                 // Otherwise
        isRegisterFormValid = true;               // The form is valid and OK to submit
      }
      console.log(isRegisterFormValid);
      return isRegisterFormValid;
}
/* Toggle Login Form */
function showLoginForm() {
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
}
/* Toggle Registeration Form */
function showRegisterForm() {
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
    }
}
/* Toggle Password Visibility */
function tooglePassword(){
    var passwordId = document.getElementById('password');
    if (passwordId.type === "password") 
    {
        passwordId.type = "text";
    }
    else {
        passwordId.type = "password";
    }
}

function toogleRegisterPassword(){
    var passwordId = document.getElementById('r_password');
    var conf_passwordId = document.getElementById('r_conf_password');
    if (passwordId.type === "password") 
    {
        passwordId.type = "text";
    }
    else {
        passwordId.type = "password";
    }

    if (conf_passwordId.type === "password") 
    {
        conf_passwordId.type = "text";
    }
    else {
        conf_passwordId.type = "password";
    }
}