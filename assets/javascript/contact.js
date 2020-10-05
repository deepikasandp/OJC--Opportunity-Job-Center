function showErrorMessage(el, message) {
    el.textContent = message;
}

function removeErrorMessage(el) {    
    el.textContent = null;
}

function validateContactForm(form){    
    var isFormValid = false;	
    var name = form["name"].value;
    var email = form["email"].value;
    var subject = form["subject"].value;
    var message = form["message"].value;
    var errorMsg1 = document.getElementById("errorMsg1");      
    var errorMsg2 = document.getElementById("errorMsg2");      
    var errorMsg3 = document.getElementById("errorMsg3");      
    var errorMsg4 = document.getElementById("errorMsg4"); 
    var valid = {};                                             // Valid objectconsole.log("Funcion Invoked");
    
    //Validate fields
    if (name == "")
    {
        err_msg = "Name is required";
        valid[name] = false;
        showErrorMessage(errorMsg1, err_msg);
        console.log(err_msg);
    }
    else{// Otherwise
        valid[name] = true;
        removeErrorMessage(errorMsg1); // Remove error messages
    }

    if(email == "")
    {
        err_msg = "Email is required";
        valid[email] = false;
        showErrorMessage(errorMsg2,err_msg);
        console.log(err_msg);
    }
    else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
    {
        err_msg = "Please enter a valid email address";
        valid[email] = false;
        showErrorMessage(errorMsg2,err_msg);
        console.log(err_msg);
    }
    else{// Otherwise        
        valid[email] = true;
        removeErrorMessage(errorMsg2); // Remove error messages
    }

    if(subject == "")
    {
        err_msg = "Subject is required";
        valid[subject] = false;
        showErrorMessage(errorMsg3,err_msg);
        console.log(err_msg);
    }
    else{// Otherwise        
        valid[subject] = true;
        removeErrorMessage(errorMsg3); // Remove error messages
    }

    if(message == "")
    {
        err_msg = "Message is required";
        valid[message] = false;
        showErrorMessage(errorMsg4,err_msg);
        console.log(err_msg);
    }
    else{// Otherwise        
        valid[message] = true;
        removeErrorMessage(errorMsg4); // Remove error messages
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
