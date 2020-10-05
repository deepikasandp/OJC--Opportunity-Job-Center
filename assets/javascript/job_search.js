function searchJobBySelection(form) {
    var industry = form["industry"].value;
    var jobType = form["jobType"].value;
    var experience = form["experience"].value;
    var jobTitle = form["title"].value;
    var skills = form["skills"].value;
    var submit = form["search"].value;
    console.log("searchJobBySelection");
    
    event.preventDefault();
    if(industry == "0" && jobType == "0" && experience == "0"){
        alert("Enter aleast one criteria from Quick search" );
        document.getElementById("error_msg").textContent = "Enter aleast one criteria from Quick search";
    }
    else{
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'search=' + submit + '&industry=' + industry + '&jobType=' + jobType + '&experience=' + experience + '&jobTitle=' + jobTitle + '&skills=' + skills;
        //alert(dataString);// AJAX code to submit form.
        $.ajax({
            type: "POST",
            url: "./jobseeker/ajax_request_handler.php",
            data: dataString,
            cache: false,
            success: function(html) {
                //alert(html);    
                document.getElementById("showSearchResults").innerHTML = html;
                }
            });
    }
    return false;
  }