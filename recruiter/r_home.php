<?php
if (isset($_SESSION["USER_ID"]))
{
    /* Check if the candidate has updated his profile, If updated, show no option to update */
    /* Create database and user object to handle the job request */
    // Include config file
    include_once('./config/databaseConfig.php');
    include_once('./object/user.php');
    $database = new DatabaseConfig();
    $db = $database->getConnection();   
    $user = new user($db);
    $userRow = $user->getAllJobs($_SESSION['USER_ID']);
    if($userRow){
        foreach($userRow as $row) {
            //echo $row['JOB_ID'];
        }
    }        
}
?>
<?php include('./includes/r_home_header.php'); ?> 
<script>
    $(document).ready(function(){
        $('.recruiter').addClass('active');
        $('.recruiter').parent().children('a').not('.recruiter').removeClass('active');
    });  
</script>

<div class="main">
    <div class="r-home-container">  
        <div class="menu-item">
            <button type="button" class="menu-button active" id="addVacancyLink" onclick="addNewVacancy();">Add New Vacancy</button>
            <button type="button" class="menu-button" id="showVacancyLink" onclick="showAllVacancies();">View Vacancy Posting / Find Candidate</button> 
        </div>       
        <!-- Start of Vacancy Form -->
        <div class="r-vacancy-form-item show" id="addVacancy"> 
            <h2>Add New Job Vacancy</h2>
            <?php
            if(isset($_GET['update'])){
                $status = $_GET['update'];
                if($status == "success"){?>
                    <h2 style="color:green">Thank you! Your job vacancy has been added successfully!</h2>
                <?php
                }
                else if($status == "failure"){
                    $error_code =  $_GET['error_msg'];
                    if($error_code == "error1"){?>
                        <h2 style="color:red">Sorry! Job update failed, we require all the fields.</h2>
                    <?php
                    }
                    else if($error_code == "error2"){?>
                        <h2 style="color:red">Sorry, something went wrong! Job update failed.</h2>
                    <?php
                    }
                }
            }?>
            <form id="updateVacancyForm" class="vacancyForm-container" action="./recruiter/r_form_handler.php" method="post">
                <div class="section1 tab">                  
                    <input type="hidden" id="user_id" name="user_id"  value="<?php echo $_SESSION["USER_ID"]?>">
                    <h4>Organisation Details</h4>                
                    <span class="error">* required field</span>    
                    <label for="org_name">Organisation Name:</label>
                    <input type="text" id="org_name" name="org_name" placeholder="Organisation Name">
                    <span class="error_mark">*</span> 

                    <label for="org_location">Organisation Location Postcode:</label>
                    <input type="text" id="org_location" name="org_location" placeholder="Organisation Location">
                    <span class="error_mark">*</span>
                </div>

                <div class="section2 tab">               
                    <span class="error">* required field</span>    
                    <h4>Employment Details</h4>
                    <label for="title">Job Title:</label>
                    <input type="text" id="title" name="title" placeholder="Job Title">
                    <span class="error_mark">*</span>
                    
                    <label for="industry">Industry:</label>
                    <select name="industry" id="industry">
                        <option value='0' >Select Industry</option>
                        <?php
                        $industryList = $user->getJobIndustryList();
                        foreach($industryList as $industry){
                            echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                        }?>
                    </select>         
                    <span class="error_mark">*</span>

                    <label for="location">Job Location Postcode:</label>
                    <input type="text" id="location" name="location" placeholder="Work Location">                    
                    <span class="error_mark">*</span>

                    <label for="jobType">Job Type:</label>
                    <select name="jobType" id="jobType">
                        <option value='0' >Select Job Type</option>
                        <?php
                        $jobTypeList = $user->getJobTypeList();
                        foreach($jobTypeList as $jobType){
                            echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
                        }?>
                    </select>         
                    <span class="error_mark">*</span> 
                </div>
                
                <div class="section3 tab">             
                    <span class="error">* required field</span>  
                    <h4>Skills & Experience</h4>
                    <label for="skills">Skills:<span class="skills-instruction">(Enter multiple skills separted by comma)</span></label>
                    <textarea id="skills" name="skills" rows="4" cols="50">Enter your skill set.
                    </textarea>                     
                    <span class="error_mark">*</span>

                    <label for="experience">Experience:</label>
                    <select name="experience" id="experience">
                        <option value='0' >Select Experience</option>
                        <?php
                        $experienceList = $user->getExperienceList();
                        foreach($experienceList as $experience){
                            echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
                        }?>
                    </select>       
                    <span class="error_mark">*</span>
                    <input type="hidden" id="updateJobVacancy" name="updateJobVacancy" value="1">      
                </div>
                
                <div class="section4">
                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                </div>

                <div class="section5">
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </div>                        
            </form>        
        </div>
        <!-- End of  Vacancy Form -->

        <!-- Start of View Vacancies -->
        <div class="r-view-vacancies-item hide" id="showVacancies">
            <h2>View all your current vacancies</h2>
            <!--Loop through vacancies and list all of them here -->
            <div class="view-container">
                <table id="viewJobsTable">                    
                    <thead>
                        <th>No</th>
                        <th>Job Title</th>
                        <th>Job Location</th>
                        <th>Date Posted</th>
                        <th>Offers Sent</th>
                        <th>More Details</th>
                        <th>Find Candidate</th>

                    </thead>                    
                    <tbody>
                        <?php                    
                        $i = 1;
                        foreach($userRow as $row) 
                        {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['JOB_TITLE']; ?></td>
                            <td><?php echo $row['JOB_LOCATION']; ?></td>
                            <?php
                            $datetime = $row['UPDATED_DATE'];
                            $date = date_create($datetime);
                            $date = date_format($date,"d/m/Y");
                            ?>
                            <td><?php echo $date; ?></td>                            
                            <td><a class="offer" href="javascript:void(0);" onclick="showOffer(<?php echo $row['JOB_ID'] ?>)">Show Offers</a></td>
                            <td><a class="moreDetails" href="javascript:void(0);" onclick="showMoreDetails(<?php echo $row['JOB_ID'] ?>)">Show More Details</a></td>
                            <td><a class="candidate" href="javascript:void(0);" onclick="showCandidates(<?php echo $row['JOB_ID'] ?>)">Search Candidate</a></td>
                        </tr>
                        <?php 
                        $i = $i + 1;
                        } 
                        ?>
                    </tbody>
                </table>             
                <div id="offerDetails" style="padding-bottom: 10px;">
                </div>
                <form style="padding-bottom: 10px;" onsubmit="return insertOffer(this)" action="./recruiter/ajax_request_handler.php" method="post">
                    <div id="offerFormDisplay" style="margin-bottom:20px">
                    </div>
                </form>
                <div style="padding-bottom: 10px;color:green;text-transform:uppercase" id="offerUpdateNotification"></div>
            </div>         
        </div>
        <!-- End of View Vacancies --> 
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#viewJobsTable').DataTable();
});
</script>