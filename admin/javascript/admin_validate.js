function showErrorMessage(el, message) {
    el.textContent = message;
}

function removeErrorMessage(el) {    
    el.textContent = null;
}

function adminLoginValidate(form){    
    var isFormValid = false;	
    var email = form["username"].value;
    var password = form["password"].value;
    var err_msg;
    var errorMsg1 = document.getElementById("usernameError");      
    var errorMsg2 = document.getElementById("passwordError"); 
    var valid = {}; 

    //Validate fields
    if(email == "")
    {
        err_msg = "Username is required";
        valid[email] = false;
        errorMsg1.textContent = err_msg;
        console.log(err_msg);
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
    {
        err_msg = "Please enter a valid email address";
        valid[email] = false;
        errorMsg1.textContent = err_msg;
        console.log(err_msg);
    }
    else{// Otherwise
        removeErrorMessage(errorMsg1); // Remove error messages
        valid[email] = true;
    }

    if(password == "")
    {
        err_msg = "password is required";
        valid[password] = false;
        showErrorMessage(errorMsg2, err_msg);
        console.log(err_msg);
    }
    else if(password.length < 8)
    {
        err_msg = "Please make sure your password has at least 8 characters";
        valid[password] = false;
        showErrorMessage(errorMsg2, err_msg);
        console.log(err_msg);
    }  
    else{// Otherwise
        removeErrorMessage(errorMsg2, err_msg); // Remove error messages
        valid[email] = true;v
    }
    
    //Did the validation pass, can it submit the form?
    // Loop through valid object, if there are errors set isFormValid to false
    for (var field in valid) {            // Check properties of the valid object
        if (!valid[field]) {              // If it is not valid
            isFormValid = false;          // Set isFormValid variable to false
          break;                          // Stop the for loop, an error was found
        }                                 // Otherwise
        isFormValid = true;               // The form is valid and OK to submit
      }
      console.log(isFormValid);
      return isFormValid;
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