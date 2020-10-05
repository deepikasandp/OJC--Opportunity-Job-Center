<?php
include('../includes/admin_home_header.php'); 
// Include config file
include_once('../config/databaseConfig.php');
include_once('../object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);
$userRows = $user->getAllUser(); 
$jobRows = $user->getJobs(); 
$profileRows = $user->getAllJSProfile();

if (isset($_GET['editJob'])) {
    $id = $_GET['editJob'];
    $update = true;
    $jobToEdit = $user->getJobDetails($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>  
    <link rel="stylesheet" type="text/css" href="../css/admin.css"> 
</head>
<body>
    
<table>
    <h4 style="text-align:center">UPDATE JOB <?php echo $jobToEdit['JOB_ID']; ?> <h4>
    <form action="./admin/updates/admin_ajax_request_handler.php" method="post">                      
        <input type="hidden" id="job_id" name="job_id"  value="<?php echo $jobToEdit['JOB_ID'];?>">
        <tr>
            <th>
            <label for="org_name">Organisation Name:</label></th>
            <td>
            <input type="text" id="org_name" name="org_name" value="<?php echo $jobToEdit['ORG_NAME']; ?>"></td>
        </tr>

        <tr>
            <th>
            <label for="org_location">Organisation Location Postcode:</label></th>
            <td>
            <input type="text" id="org_location" name="org_location" value="<?php echo $jobToEdit['ORG_LOCATION']; ?>"></td>
        <tr>

        <tr>
            <th>
            <label for="title">Job Title:</label>
            </th>
            <td>
            <input type="text" id="title" name="title" value="<?php echo $jobToEdit['JOB_TITLE']; ?>">
            </td>
        </tr>

        <tr>
            <th>
                <label for="industry">Industry:</label>
            </th>
            <td>
                <select name="industry" id="industry" value="<?php echo $jobToEdit['JOB_INDUSTRY'];?>">
                    <?php
                    $industryList = $user->getJobIndustryList();
                    foreach($industryList as $industry){
                        echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                    }?>
                </select>  
            </td>
        </tr>
        
        <tr>
            <th>
            <label for="location">Job Location Postcode:</label>
            </th>
            <td>
            <input type="text" id="location" name="location" value="<?php echo $jobToEdit['JOB_LOCATION']; ?>"> 
            </td>
        </tr>

        <tr>
            <th>
                <label for="jobType">Job Type:</label>
            </th>
            <td>
                <select name="jobType" id="jobType" value="<?php echo $jobToEdit['JOB_TYPE']; ?>">
                <?php
                $jobTypeList = $user->getJobTypeList();
                foreach($jobTypeList as $jobType){
                    echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
                }?>
                </select> 
            </td> 
        </tr>

        <tr>
            <th>
            <label for="skills">Skills:</label>
            </th>
            <td>
                <textarea id="skills" name="skills" rows="4" cols="50"><?php echo $jobToEdit['JOB_SKILLS']; ?>
                </textarea> 
            </td>     
        </tr>

        <tr>
            <th><label for="experience">Experience:</label></th>
            <td>
            <select name="experience" id="experience" value="<?php echo $jobToEdit['JOB_EXPERIENCE'];?>">
                <?php
                $experienceList = $user->getExperienceList();
                foreach($experienceList as $experience){
                    echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
                }?>
            </select> 
            </td>
        </tr>
        <tr>            
            <th><input type="submit" value="Submit" class="edit_btn" name="updateJob"></th>
        </tr>
    </form>    
</table>
</body>
</html>    
    
<?php
}
?>


<?php
        if (isset($_GET['editJob'])) 
        {
            $id = $_GET['editJob'];
            $update = true;
            $jobToEdit = $user->getJobDetails($id);
        
    ?>
        <table>
            <h4 style="text-align:center">UPDATE JOB <?php echo $jobToEdit['JOB_ID']; ?> <h4>
            <form action="./admin/updates/admin_ajax_request_handler.php" method="post">                      
                <input type="hidden" id="job_id" name="job_id"  value="<?php echo $jobToEdit['JOB_ID'];?>">
                <tr>
                    <th>
                    <label for="org_name">Organisation Name:</label></th>
                    <td>
                    <input type="text" id="org_name" name="org_name" value="<?php echo $jobToEdit['ORG_NAME']; ?>"></td>
                </tr>

                <tr>
                    <th>
                    <label for="org_location">Organisation Location Postcode:</label></th>
                    <td>
                    <input type="text" id="org_location" name="org_location" value="<?php echo $jobToEdit['ORG_LOCATION']; ?>"></td>
                <tr>

                <tr>
                    <th>
                    <label for="title">Job Title:</label>
                    </th>
                    <td>
                    <input type="text" id="title" name="title" value="<?php echo $jobToEdit['JOB_TITLE']; ?>">
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="industry">Industry:</label>
                    </th>
                    <td>
                        <select name="industry" id="industry" value="<?php echo $jobToEdit['JOB_INDUSTRY'];?>">
                            <?php
                            $industryList = $user->getJobIndustryList();
                            foreach($industryList as $industry){
                                echo "<option value='".$industry['JOB_INDUSTRY_ID']."'>".$industry['TYPE']."</option>";
                            }?>
                        </select>  
                    </td>
                </tr>
                
                <tr>
                    <th>
                    <label for="location">Job Location Postcode:</label>
                    </th>
                    <td>
                    <input type="text" id="location" name="location" value="<?php echo $jobToEdit['JOB_LOCATION']; ?>"> 
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="jobType">Job Type:</label>
                    </th>
                    <td>
                        <select name="jobType" id="jobType" value="<?php echo $jobToEdit['JOB_TYPE']; ?>">
                        <?php
                        $jobTypeList = $user->getJobTypeList();
                        foreach($jobTypeList as $jobType){
                            echo "<option value='".$jobType['JOB_TYPE_ID']."'>".$jobType['TYPE']."</option>";
                        }?>
                        </select> 
                    </td> 
                </tr>

                <tr>
                    <th>
                    <label for="skills">Skills:</label>
                    </th>
                    <td>
                        <textarea id="skills" name="skills" rows="4" cols="50"><?php echo $jobToEdit['JOB_SKILLS']; ?>
                        </textarea> 
                    </td>     
                </tr>

                <tr>
                    <th><label for="experience">Experience:</label></th>
                    <td>
                    <select name="experience" id="experience" value="<?php echo $jobToEdit['JOB_EXPERIENCE'];?>">
                        <?php
                        $experienceList = $user->getExperienceList();
                        foreach($experienceList as $experience){
                            echo "<option value='".$experience['JOB_EXPERIENCE_ID']."'>".$experience['TYPE']."</option>";
                        }?>
                    </select> 
                    </td>
                </tr>
                <tr>            
                    <th><input type="submit" value="Submit" class="edit_btn" name="updateJob"></th>
                </tr>
            </form>    
        </table>
    <?php 
        }   
    ?>