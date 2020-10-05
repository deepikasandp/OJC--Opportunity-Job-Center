    $(document).ready(function() {
        $('#displayUserTable').DataTable();
    });  

    $(document).ready(function() {
        $('#displayJSTable').DataTable();
    });

    $(document).ready(function() {
        $('#displayRTable').DataTable();
    });

    function showUsersTable(){
        var showUserContent = document.getElementById('showUserContent');
        var showRContent = document.getElementById('showRContent');
        var showJSContent = document.getElementById('showJSContent');
        var showUser = document.getElementById('showUser');
        var showRecruiter = document.getElementById('showRecruiter');
        var showJobSeeker = document.getElementById('showJobSeeker');
    
        contains = showUserContent.classList.contains("display");
        if(!contains)
        {
            showUserContent.classList.add('display');                
        }
        contains = showUserContent.classList.contains("nodisplay");
        if(contains)
        {
            showUserContent.classList.remove('nodisplay');                
        }

        contains = showRContent.classList.contains("display");
        if(contains)
        {
            showRContent.classList.remove('display');                
        }
        contains = showRContent.classList.contains("nodisplay");
        if(!contains)
        {
            showRContent.classList.add('nodisplay');                
        }

        contains = showJSContent.classList.contains("display");
        if(contains)
        {
            showJSContent.classList.remove('display');                
        }
        contains = showJSContent.classList.contains("nodisplay");
        if(!contains)
        {
            showJSContent.classList.add('nodisplay');                
        }

        contains = showUser.classList.contains("set");
        if(!contains)
        {
            showUser.classList.add('set');
        }

        contains = showRecruiter.classList.contains("set");
        if(contains)
        {
            showRecruiter.classList.remove('set');
        }
        
        contains = showJobSeeker.classList.contains("set");
        if(contains){
            showJobSeeker.classList.remove('set');
        }
    }

    function showJobsTable(){
        var showUserContent = document.getElementById('showUserContent');
        var showRContent = document.getElementById('showRContent');
        var showJSContent = document.getElementById('showJSContent');
        var showUser = document.getElementById('showUser');
        var showRecruiter = document.getElementById('showRecruiter');
        var showJobSeeker = document.getElementById('showJobSeeker');
    
        contains = showUserContent.classList.contains("display");
        if(contains)
        {
            showUserContent.classList.remove('display');                
        }
        contains = showUserContent.classList.contains("nodisplay");
        if(!contains)
        {
            showUserContent.classList.add('nodisplay');                
        }

        contains = showRContent.classList.contains("display");
        if(!contains)
        {
            showRContent.classList.add('display');                
        }
        contains = showRContent.classList.contains("nodisplay");
        if(contains)
        {
            showRContent.classList.remove('nodisplay');                
        }

        contains = showJSContent.classList.contains("display");
        if(contains)
        {
            showJSContent.classList.remove('display');                
        }
        contains = showJSContent.classList.contains("nodisplay");
        if(!contains)
        {
            showJSContent.classList.add('nodisplay');                
        }

        contains = showUser.classList.contains("set");
        if(contains)
        {
            showUser.classList.remove('set');
        }

        contains = showRecruiter.classList.contains("set");
        if(!contains)
        {
            showRecruiter.classList.add('set');
        }
        
        contains = showJobSeeker.classList.contains("set");
        if(contains){
            showJobSeeker.classList.remove('set');
        }
    }

    function showProfilesTable(){
        var showUserContent = document.getElementById('showUserContent');
        var showRContent = document.getElementById('showRContent');
        var showJSContent = document.getElementById('showJSContent');
        var showUser = document.getElementById('showUser');
        var showRecruiter = document.getElementById('showRecruiter');
        var showJobSeeker = document.getElementById('showJobSeeker');
    
        contains = showUserContent.classList.contains("display");
        if(contains)
        {
            showUserContent.classList.remove('display');                
        }
        contains = showUserContent.classList.contains("nodisplay");
        if(!contains)
        {
            showUserContent.classList.add('nodisplay');                
        }

        contains = showRContent.classList.contains("display");
        if(contains)
        {
            showRContent.classList.remove('display');                
        }
        contains = showRContent.classList.contains("nodisplay");
        if(!contains)
        {
            showRContent.classList.add('nodisplay');                
        }

        contains = showJSContent.classList.contains("display");
        if(!contains)
        {
            showJSContent.classList.add('display');                
        }
        contains = showJSContent.classList.contains("nodisplay");
        if(contains)
        {
            showJSContent.classList.remove('nodisplay');                
        }

        contains = showUser.classList.contains("set");
        if(contains)
        {
            showUser.classList.remove('set');
        }

        contains = showRecruiter.classList.contains("set");
        if(contains)
        {
            showRecruiter.classList.remove('set');
        }
        
        contains = showJobSeeker.classList.contains("set");
        if(!contains){
            showJobSeeker.classList.add('set');
        }
    } 

    /* script to view all jobs listed by user if he is a recruiter */
    function viewJobsByUserId(user_id){
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moreDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=viewJobsByUserId&user_id="+user_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    /* script to view all offers listed/received by user */
    function viewOffersByUserId(user_id){
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moreDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=viewOffersByUserId&user_id="+user_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
    /* script to view profile of the user */
    function viewProfileByUserId(user_id){        
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moreDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=viewProfileByUserId&user_id="+user_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    /* script to view job */
    function getJobByJobId(job_id){         
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moreActions").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=getJobByJobId&job_id="+job_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    /* script to update job  */
    function updateJobByJobId(form)
    {  
        var job_id = form["job_id"].value;
        var org_name = form["org_name"].value;
        var org_location = form["org_location"].value;
        var title = form["title"].value;
        var industry = form["industry"].value;
        var location = form["location"].value;
        var jobType = form["jobType"].value;
        var skills = form["skills"].value;
        var experience = form["experience"].value;
        var submit = form["updateJob"].value;
        
        event.preventDefault();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'updateJob=' + submit + '&job_id=' + job_id + '&org_name=' + org_name + '&org_location=' + org_location + '&title=' + title + '&industry=' + industry + '&location=' + location + '&jobType=' + jobType + '&skills=' + skills + '&experience=' + experience;
        if (job_id == '' || org_name == '' || industry == ''|| location == ''|| jobType == ''|| skills == ''|| experience == ''|| title == '' || org_location == '') {
            alert("Please Fill All Fields");
        } 
        else 
        {
            event.preventDefault();        
            //alert(dataString);// AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "./updates/admin_ajax_request_handler.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    alert(html);            
                    document.getElementById("moreActions").innerHTML = "";
                    document.getElementById("notification").innerHTML = html;
                    }
                });
        }
        return false;
    }

    /* script to delete job */
    function delJobByJobId(job_id){         
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);           
            document.getElementById("notification").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=delJobByJobId&job_id="+job_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    /* script to view profile of the user */
    function getProfileByUserId(user_id)
    { 
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("moreProfileActions").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=getProfileByUserId&user_id="+user_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    /* script to update profile of the user */
    function updateProfileByUserId(form)
    {  
        var user_id = form["user_id"].value;
        var title = form["title"].value;
        var industry = form["industry"].value;
        var location = form["location"].value;
        var jobType = form["jobType"].value;
        var skills = form["skills"].value;
        var experience = form["experience"].value;
        var submit = form["updateProfile"].value;
        
        event.preventDefault();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'updateProfile=' + submit + '&user_id=' + user_id + '&title=' + title + '&industry=' + industry + '&location=' + location + '&jobType=' + jobType + '&skills=' + skills + '&experience=' + experience;
        if (user_id == '' || industry == ''|| location == ''|| jobType == ''|| skills == ''|| experience == ''|| title == '') {
            alert("Please Fill All Fields");
        } 
        else 
        {
            event.preventDefault();        
            //alert(dataString);// AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "./updates/admin_ajax_request_handler.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    alert(html);            
                    document.getElementById("moreProfileActions").innerHTML = "";
                    document.getElementById("profileNotification").innerHTML = html;
                    }
                });
        }
        return false;
    }

    /* script to delete profile of the user */
    function delProfileByUserId(user_id){
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);           
            document.getElementById("profileNotification").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./updates/admin_ajax_request_handler.php?request=delProfileByUserId&user_id="+user_id, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    