function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    select = x[currentTab].getElementsByTagName("select");
    textarea = x[currentTab].getElementsByTagName("textarea");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
      else{
          if(y[i].classList.contains("invalid")){
            y[i].classList.remove('invalid');
          }
      }
    }
    // A loop that checks every input field in the current tab:
    for (i = 0; i < select.length; i++) {
      // If a field is empty...
      if (select[i].value === "0") {
        //console.log("select[i].value = "+select[i].value);
        // add an "invalid" class to the field:
        select[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
      else{
          if(select[i].classList.contains("invalid")){
            select[i].classList.remove('invalid');
          }
      }
    }
    // A loop that checks every input field in the current tab:
    for (i = 0; i < textarea.length; i++) {
      // If a field is empty...
      if (textarea[i].value == "") {
        //console.log("textarea[i].value = "+textarea[i].value);
        // add an "invalid" class to the field:
        textarea[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
      else{
          if(textarea[i].classList.contains("invalid")){
            textarea[i].classList.remove('invalid');
          }
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }