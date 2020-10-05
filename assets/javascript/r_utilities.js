function showMoreDetails(job_id){
    var xhttp;  
    if (job_id == "") {
      document.getElementById("offerDetails").innerHTML = "";
      document.getElementById("offerFormDisplay").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("offerDetails").innerHTML = this.responseText;        
        document.getElementById("offerFormDisplay").innerHTML = "";
      }
    };
    xhttp.open("GET", "./recruiter/ajax_request_handler.php?request=getAllJobData&job_id="+job_id, true);
    xhttp.send();
}

function showOffer(job_id){
    var xhttp;
    if (job_id == "") {
      document.getElementById("offerDetails").innerHTML = "";
      document.getElementById("offerFormDisplay").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("offerDetails").innerHTML = this.responseText;
        document.getElementById("offerFormDisplay").innerHTML = "";
      }
    };
    xhttp.open("GET", "./recruiter/ajax_request_handler.php?request=getOfferData&job_id="+job_id, true);
    xhttp.send();
}

function showCandidates(job_id){
    var xhttp;
    if (job_id == "") {
    document.getElementById("offerDetails").innerHTML = "";
    document.getElementById("offerFormDisplay").innerHTML = "";
    return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("offerDetails").innerHTML = this.responseText;
        document.getElementById("offerFormDisplay").innerHTML = "";
    }
    };
    xhttp.open("GET", "./recruiter/ajax_request_handler.php?request=searchCandidates&job_id="+job_id, true);
    xhttp.send();
}

function sendOfferForm(job_id, user_id){
  var xhttp;
  if (job_id == "") {
  document.getElementById("offerFormDisplay").innerHTML = "";
  return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
      document.getElementById("offerFormDisplay").innerHTML = this.responseText;
  }
  };
  xhttp.open("GET", "./recruiter/ajax_request_handler.php?request=sendOfferForm&job_id="+job_id+"&user_id="+user_id, true);
  xhttp.send();
}

/* script to view profile of the user */
function viewProfileByUserId(user_id){        
  var xhttp;
  if (user_id == "") {
    document.getElementById("offerFormDisplay").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
      document.getElementById("offerFormDisplay").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "./recruiter/ajax_request_handler.php?request=viewProfileByUserId&user_id="+user_id, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send();
}

function insertOffer(form) {
  var user_id = form["offer_user_id"].value;
  var job_id = form["offer_job_id"].value;
  var subject = form["offer_subject"].value;
  var message = form["offer_message"].value;
  var submit = form["sendOfferMail"].value;
  
  event.preventDefault();
  // Returns successful data submission message when the entered information is stored in database.
  var dataString = 'sendOfferMail=' + submit + '&offer_user_id=' + user_id + '&offer_job_id=' + job_id + '&offer_subject=' + subject + '&offer_message=' + message+ '&offer_submit=' + submit;
  if (user_id == '' || job_id == '' || subject == '' || message == '') {
    alert("Please Fill All Fields");
  } 
  else {
    //alert(dataString);// AJAX code to submit form.
    $.ajax({
        type: "POST",
        url: "./recruiter/ajax_request_handler.php",
        data: dataString,
        cache: false,
        success: function(html) {
            alert(html);            
            document.getElementById("offerFormDisplay").innerHTML = "";
            document.getElementById("offerUpdateNotification").innerHTML = html;
            }
        });
    }
  return false;
}

$(document).ready(function() {
  $('#viewJobsTable').DataTable();
});

$(document).ready(function() {
  $('#offerDetailsTable').DataTable();
});