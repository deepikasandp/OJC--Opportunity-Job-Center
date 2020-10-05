<?php
$userProfileFound = false;
if (isset($_SESSION["USER_ID"]))
{
    /* Check if the candidate has updated his profile, If updated, show no option to update */
    /* Create database and user object to handle the job request */
    // Include config file
    include_once('./config/databaseConfig.php');
    include_once('./object/user.php');                                       
    include ('./google_distance_matrix/google_distance_matrix.php');
    $database = new DatabaseConfig();
    $db = $database->getConnection();   
    $user = new user($db);
    $userRow = $user->ifUserProfileUpdated($_SESSION['USER_ID']);
    if($userRow){
        $userProfileFound = true;       
    }
    else{
        $userProfileFound = false;
    }
    $nOffers = $user->getNOffersByUserId($_SESSION['USER_ID']);
    if($nOffers >= 1){
        $offerRows = $user->getOfferDetailsByUserId($_SESSION['USER_ID']);
    }
    $dm = new DistanceMatrix();
    /* Find the distance using google_distance_matrix API */ 
    if($userProfileFound){        
        $origin = $userRow['JOB_LOCATION'];
    }else{
     $origin = "";   
    }
    //$destination = $jobRow['JOB_LOCATION'];
    //$distance = $dm->getDistance($origin, $destination);
}
?>

<?php include('./includes/js_home_header.php'); ?> 
<script>
    $(document).ready(function(){
        $('.jobSeeker').addClass('active');
        $('.jobSeeker').parent().children('a').not('.jobSeeker').removeClass('active');
    });  
</script>

<div class="main">
    
    <div class="js-home-container">  
        <div class="menu-item">
            <button type="button" class="menu-button active" id="updateProfileLink" onclick="showUpdateForm();">Update Your Job Profile</button>
            <button type="button" class="menu-button" id="showProfileLink" onclick="showUpdatedProfile();">View Your Job Profile</button>  
            <button type="button" class="menu-button" id="showOffersLink" onclick="viewOffers();">View Your Job Offers <span class="offer-count"> <?php echo $nOffers ?></span></button>       
        </div>  
        <!-- Start of Update Profile Form -->
        <div class="js-update-form-item show" id="updateForm"> 
            <div class="section1">             
                <h2>Update Your Job Profile</h2>
            </div>
            <form id="updateProfileForm" class="updateForm-container" onsubmit="return updateFormValidation(this);" action="./jobseeker/js_form_handler.php" method="post">
                <!-- Check if profile is updated already -->
                <?php                    
                    if($userProfileFound){?>
                        <p>Your profile has already been updated successfully!</p>
                    <?php
                    }else
                    {
                        //Show the update notification                    
                        if(isset($_GET['update'])){
                            $status = $_GET['update'];
                            if($status == "success"){?>
                                <p>Thank you! Your profile has been updated successfully!</p>
                            <?php
                            }
                            else if($status == "failure"){
                                $error_code =  $_GET['error_msg'];
                                if($error_code == "error1"){?>
                                    <p>Sorry! Your profile update failed, we require all the fields.</p>
                                <?php
                                }
                                else if($error_code == "error2"){?>
                                    <p>Sorry, something went wrong! Profile update failed.</p>
                                <?php
                                }
                            }
                        }
                        else{?>
                            <div class="section1 tab">
                                <input type="hidden" id="user_id" name="user_id"  value="<?php echo $_SESSION["USER_ID"]?>">                             
                                <h4>Employment Details</h4>             
                                <span class="error">* required field</span> 
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
                                <input type="text" id="location" name="location" placeholder="Where do you like to work?">
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

                                <input type="hidden" id="updateJobVacancy" name="updateJSProfile" value="1">   
                            </div>
                            
                            <div class="section2 tab">
                                <h4>Skills & Experience</h4>
                                <span class="error_mark">*</span>
                                <label for="skills">Skills:<span class="skills-instruction">(Enter multiple skills separted by comma)</span></label>
                                <textarea id="skills" name="skills" rows="4" cols="50"></textarea>       
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
                            </div>
                                        
                            <div class="section3">
                                <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Circles which indicates the steps of the form: -->
                            <div style="text-align:center;margin-top:40px;">
                                <span class="step"></span>
                                <span class="step"></span>
                            </div>     
                        <?php
                        } 
                    }?>                 
            </form>        
        </div>
        <!-- End of Update Profile Form -->

        <!-- Start of View Form -->
        <div class="js-view-form-item hide" id="showProfile"> 
            <?php if($userProfileFound){?>
                <h2>View Your Job Profile</h2>
                <table id="userTable" class="table1">
                    <?php
                        $industry = $user->getIndustryType($userRow['JOB_INDUSTRY']);
                        $jobType = $user->getJobType($userRow['JOB_TYPE']);
                        $experience = $user->getExperienceType($userRow['JOB_EXPERIENCE']);     
                    ?>                                 
                    <tr>
                        <th>First Name</th>
                        <td><?php echo $_SESSION['FIRST_NAME']; ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo $_SESSION['LAST_NAME']; ?></td>
                    </tr>               
                    <tr>
                        <th>Job Title</th>
                        <td><?php echo $userRow['JOB_TITLE']; ?></td>
                    </tr>
                    <tr>
                        <th>Industry</th>
                        <td><?php echo $industry; ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?php echo $userRow['JOB_LOCATION']; ?></td>
                    </tr>           
                    <tr>
                        <th>Job Type</th>
                        <td><?php echo $jobType; ?></td>
                    </tr>               
                    <tr>
                        <th>Skills</th>
                        <td><?php echo $userRow['JOB_SKILLS']; ?></td>
                    </tr>
                    <tr>
                        <th>Experience</th>
                        <td><?php echo $experience; ?></td>
                    </tr>
                </table>
            <?php 
            } 
            else{?>
                <h2>No profile available yet!</h2>
            <?php
            }?>
        </div>
        <!-- End of View Form -->

        <!-- Start of View Offer -->
        <div class="js-view-offer-form-item hide" id="showOffers">        
            <h2>View Your Job Offers</h2>
            <div class="section1">                    
                <h2><span class="text">Number of offers received: <?php echo $nOffers;?></span></h2>
            </div>          
            <div class="view-container">
                <?php
                if($nOffers >= 1){?>
                    <table id="viewOfferTable">
                        <thead>
                            <th>No</th>
                            <th>Organisation Name</th>
                            <th>Job Title</th>
                            <th>Job Location</th>                   
                            <th>Distance From Your Location</th>                   
                            <th>Message</th>
                            <th>Offer Date</th>
                        </thead>
                        <?php
                        $nOffer = 1;
                        foreach($offerRows as $offerRow) 
                        {  
                            $jobRow = $user->getJobDetails($offerRow['JOB_ID']); 
                            $destination = $jobRow['JOB_LOCATION'];
                            $distance = $dm->getDistance($origin, $destination);
                            $address = $dm->getDestinationAddress($origin, $destination);                            
                            ?>
                            <tr>
                                <td><?php echo $nOffer; ?></td>
                                <td><?php echo $jobRow['ORG_NAME']; ?></td>
                                <td><?php echo $jobRow['JOB_TITLE']; ?></td>                                
                                <td><?php echo $address; ?></td>                                
                                <td><?php echo $distance; ?></td>
                                <td><a href="javascript:void(0);" onclick="showOfferMessage(<?php echo $offerRow['OFFER_ID'] ?>)">Show Offer</a></td>
                                <?php $datetime = $offerRow['UPDATED_DATE'];
                                      $date = date_create($datetime);
                                      $date = date_format($date,"d/m/Y");?>
                                <td><?php echo $date;?></td>
                            </tr>
                            <?php
                            $nOffer = $nOffer + 1;
                        }?>
                    </table>
                    <div style="padding:10px" id="showOfferMessageHere"></div>  
                <?php
                }?>
            </div>                          
        </div>
        <!-- End of View Offer -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#viewOfferTable').DataTable();
    });
</script>

