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
}
?>

<?php include('includes/job_search_header.php'); ?> 
<script>
    $(document).ready(function(){
        $('.jobSearch').addClass('active');
        $('.jobSearch').parent().children('a').not('.jobSearch').removeClass('active');
    });  
    /* Recruiter Utility Functions */
    $(document).ready(function(){
        $("#job-search-showAdvOption").click(function(){
        $("#job-search-adv-option").toggle();
        });
    });

</script>

<div class="main">
    <div class="job-search-home-container">
        <!-- Start of Search Form -->
        <div class="job-search-item1">  
            <form class="job-search-form-container" onsubmit="return searchJobBySelection(this)" action="./jobseeker/ajax_request_handler.php" method="post">
                <div class="highlight">
                    <div class="section">
                        <div class="col1">
                            <h4>Quick Search<a href="javascript:void(0);" id="job-search-showQuickOption">&#x25BC;</a></h4> 
                            <span class="error" id="error_msg"></span>                            
                        </div>
                        <div class="col1">
                            <label for="industry">Industry:</label>
                            <select name="industry" id="industry">
                                <option value='0' >Select Industry</option>
                                <?php
                                $industryList = $user->getJobIndustryList();
                                foreach($industryList as $industry){
                                    echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                                }?>
                            </select>
                        </div>
                        <div class="col2">
                            <label for="jobType">Job Type:</label>
                            <select name="jobType" id="jobType">
                                <option value='0' >Select Job Type</option>
                                <?php
                                $jobTypeList = $user->getJobTypeList();
                                foreach($jobTypeList as $jobType){
                                    echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
                                }?>
                            </select>
                        </div>
                        <div class="col3">
                            <label for="experience">Experience:</label>
                            <select name="experience" id="experience">
                                <option value='0' >Select Experience</option>
                                <?php
                                $experienceList = $user->getExperienceList();
                                foreach($experienceList as $experience){
                                    echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
                                }?>
                            </select>
                        </div>                    
                        <div class="col1">                
                            <h4>Advanced Search<a href="javascript:void(0);" id="job-search-showAdvOption">&#x25BC;</a></h4> 
                        </div>  
                    </div>
                    <div class="hide" id="job-search-adv-option">
                        <div class="col1">           
                            <label for="title">Job Title:</label>
                            <input type="text" id="title" name="title" placeholder="Job Title">
                        </div>    
                        <div class="col2">
                            <label for="skills">Skills: <span class="skills-instruction">(Enter multiple skills separted by comma)</span></label>
                            <input type="text" id="skills" name="skills" placeholder="Enter your skill set">
                        </div>
                    </div>
                    <div class="section" style="padding-top:10px;align-items:center; margin:auto;">           
                        <div class="col2">                       
                            <input type="reset" value="Clear">
                        </div>
                        <div class="col3">
                            <input type="submit" value="Search" name="search">
                        </div>
                    </div>    
                </div>
            </form>
        </div>        
        <div class="job-search-item2" style="padding:10px;">
            <table id="showSearchResults"></table> 
        </div>
        <!-- End of Search Form -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#showSearchResults').DataTable();
    });
</script>