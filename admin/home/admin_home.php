<?php
// Include config file
include_once('./config/databaseConfig.php');
include_once('./object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);
$userRows = $user->getAllUser(); 
$jobRows = $user->getJobs(); 
$profileRows = $user->getAllJSProfile(); 
?>
<div class="main">
    <div class="admin-home">
        <div class="options">
            <button class="option set" id="showUser" onclick="showUsersTable();">View Users</button>
            <button class="option" id="showRecruiter" onclick="showJobsTable();">Manage Jobs</button>
            <button class="option" id="showJobSeeker" onclick="showProfilesTable();">Manage Profiles</button>
        </div>
        <div class="content">
            <?php
            if(isset($_GET['update']))
            {
                if($_GET['update'] === "success")
                {?>
                    <h2>Action Performed Successfully</h2>
                <?php 
                }
                else if($_GET['update'] === "failure")
                {?>
                <h2>Action Failed, Please try again!</h2>
                <?php 
                }
            }?>
            <!-- Show User Table -->
            <div class="display" id="showUserContent">
                <h4 style="text-align:center;">OJC's USERS LIST - ADMIN, CANDIDATES AND RECRUTERS</h4>
                <table id="displayUserTable">
                    <thead>
                        <th>USER_ID</th>
                        <th>FIRST_NAME</th>
                        <th>LAST_NAME</th>
                        <th>USER_NAME</th>
                        <th>USER_TYPE</th>
                        <th>CREATED_DATE</th>
                        <th>VIEW JOBS</th>
                        <th>VIEW OFFERS</th>
                        <th>VIEW PROFILE</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($userRows as $row) 
                        { 
                            $userType = $user->getUserType($row['USER_TYPE_ID'])?>
                            <tr>
                                <td><?php echo $row['USER_ID'] ?></td>
                                <td><?php echo $row['FIRST_NAME']?></td>
                                <td><?php echo $row['LAST_NAME']?></td>
                                <td><?php echo $row['USER_NAME']?></td>
                                <td><?php echo $userType?></td>
                                <?php
                                    $datetime = $row['UPDATED_DATE'];
                                    $date = date_create($datetime);
                                    $date = date_format($date,"d/m/Y");
                                ?>
                                <td><?php echo $date?></td>                          
                                <td><a href="javascript:void(0);" onclick="viewJobsByUserId(<?php echo $row['USER_ID'] ?>)">VIEW JOBS</a></td>
                                <td><a href="javascript:void(0);" onclick="viewOffersByUserId(<?php echo $row['USER_ID'] ?>)">VIEW OFFERS</a></td>
                                <td><a href="javascript:void(0);" onclick="viewProfileByUserId(<?php echo $row['USER_ID'] ?>)">VIEW PROFILE</a></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>                                          
                <div id="moreDetails"></div>
            </div>            
            <!-- End User Table --> 
            
            <!-- Show R Table -->            
            <div class="nodisplay" id="showRContent" >
                <h4 style="text-align:center;">OJC's JOBS LIST POSTED BY RECRUITERS</h4>
                <table id="displayRTable" class="hide">
                    <thead>
                        <th>USER_ID</th>
                        <th>JOB_ID</th>
                        <th>ORG_NAME</th>
                        <th>ORG_LOCATION</th>
                        <th>JOB_TITLE</th>
                        <th>JOB_INDUSTRY</th>
                        <th>JOB_TYPE</th>
                        <th>JOB_SKILLS</th>
                        <th>JOB_EXPERIENCE</th>
                        <th>UPDATED DATE</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($jobRows as $row) 
                        { 
                            $industry = $user->getIndustryType($row['JOB_INDUSTRY']);
                            $jobType = $user->getJobType($row['JOB_TYPE']);
                            $experience = $user->getExperienceType($row['JOB_EXPERIENCE']);?>
                            <tr>
                                <td><?php echo $row['USER_ID'] ?></td>                               
                                <td><?php echo $row['JOB_ID'] ?></td>
                                <td><?php echo $row['ORG_NAME']?></td>
                                <td><?php echo $row['ORG_LOCATION']?></td>
                                <td><?php echo $row['JOB_TITLE']?></td>
                                <td><?php echo $industry?></td>
                                <td><?php echo $jobType?></td>
                                <td><?php echo $row['JOB_SKILLS']?></td>
                                <td><?php echo $experience?></td>
                                <?php
                                    $datetime = $row['UPDATED_DATE'];
                                    $date = date_create($datetime);
                                    $date = date_format($date,"d/m/Y");
                                ?>
                                <td><?php echo $date?></td>                           
                                <td><a href="javascript:void(0);" onclick="getJobByJobId(<?php echo $row['JOB_ID'] ?>)" class="edit_btn">UPDATE</a></td>
                                <td><a href="javascript:void(0);" onclick="delJobByJobId(<?php echo $row['JOB_ID'] ?>)" class="del_btn">DELETE</a></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>                    
                </table>   
                <form style="padding-bottom: 10px;" onsubmit="return updateJobByJobId(this)" action="../admin/updates/admin_ajax_request_handler.php" method="post">
                    <div id="moreActions">
                    </div>
                </form>
                <div style="padding-bottom: 10px;color:green;text-transform:uppercase" id="notification"></div>                          
            </div>                        
            <!-- End R Table -->
            
            <!-- Show JS Table -->            
            <div class="nodisplay" id="showJSContent" >
                <h4 style="text-align:center;">OJC's PROFILE LIST OF CANDIDATES</h4>
                <table id="displayJSTable" class="hide">
                    <thead>
                        <th>USER_ID</th> 
                        <th>JOB_TITLE</th>
                        <th>JOB_INDUSTRY</th>
                        <th>JOB_TYPE</th>
                        <th>JOB_SKILLS</th>
                        <th>JOB_EXPERIENCE</th>
                        <th>UPDATED DATE</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($profileRows as $row) 
                        { 
                            $industry = $user->getIndustryType($row['JOB_INDUSTRY']);
                            $jobType = $user->getJobType($row['JOB_TYPE']);
                            $experience = $user->getExperienceType($row['JOB_EXPERIENCE']);?>
                            <tr>
                                <td><?php echo $row['USER_ID'] ?></td> 
                                <td><?php echo $row['JOB_TITLE']?></td>
                                <td><?php echo $industry?></td>
                                <td><?php echo $jobType?></td>
                                <td><?php echo $row['JOB_SKILLS']?></td>
                                <td><?php echo $experience?></td>
                                <?php
                                    $datetime = $row['UPDATED_DATE'];
                                    $date = date_create($datetime);
                                    $date = date_format($date,"d/m/Y");
                                ?>
                                <td><?php echo $date?></td>                          
                                <td><a href="javascript:void(0);" onclick="getProfileByUserId(<?php echo $row['USER_ID'] ?>)" class="edit_btn">UPDATE</a></td>
                                <td><a href="javascript:void(0);" onclick="delProfileByUserId(<?php echo $row['USER_ID'] ?>)" class="del_btn">DELETE</a></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
                <form style="padding-bottom: 10px;" onsubmit="return updateProfileByUserId(this)" action="../admin/updates/admin_ajax_request_handler.php" method="post">
                    <div id="moreProfileActions">
                    </div>
                </form>
                <div style="padding-bottom: 10px;color:green;text-transform:uppercase" id="profileNotification"></div>                          
            </div>
             <!-- End JS Table -->        
        </div> 
</div>  