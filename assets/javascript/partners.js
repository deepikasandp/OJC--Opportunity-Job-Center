function getjobDetails(job_id){
    var xhttp;  
    if (job_id == "") {
      document.getElementById("displayJobDetails").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("displayJobDetails").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "./partner/ajax_request_handler.php?request=getAllJobData&job_id="+job_id, true);
    xhttp.send();
}