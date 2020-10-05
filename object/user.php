<?php
class user
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function validateLoginData($email, $password)
    {
        // Define variables and initialize with empty values     
        $error_msg = "";  

        if(!empty($email)){
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "error1"; /*"Invalid email format";*/
            return $error_msg;
            }
        }
        else{
            $error_msg  = "error2"; /*"Username is required";*/
            return $error_msg;
        }
    
        if(empty($password)){
            $error_msg  = "error3";/*"Password is required";*/
            return $error_msg;
        }
    }

    function validateRegisterData($fname, $lname, $email, $password, $confirmPassword)
    {
        // Define variables and initialize with empty values      
        $error_msg = "";
    
        //Retrieve the field values from our login form.
        if(empty($fname)){
            $error_msg  = "error1";/*"First Name is required";*/
            return $error_msg;
        }

        if(empty($lname)){
            $error_msg  = "error2";/*"Last Name is required";*/
            return $error_msg;
        }

        if(!empty($email)){
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "error3"; /*"Invalid email format";*/
            return $error_msg;
            }
        }
        else{
            $error_msg  = "error4"; /*"Username is required";*/
            return $error_msg;
        }
    
        if(empty($password)){
            $error_msg  = "error5";/*"Password is required";*/
            return $error_msg;
        }
    }

    function ifUserExists($email)
    {
        $query = "SELECT * FROM OJC_USER WHERE USER_NAME = :email";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':email', $email);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRow;                  
    }

    function validateUserType($userID, $requestingUsertype){
        $result = false;
        $registeredUserTypeId = NULL;
        $registeredUserType = NULL;

        $query = "SELECT USER_TYPE_ID FROM OJC_USER WHERE USER_ID = :userId";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':userId', $userID);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userRow){
            $registeredUserTypeId = $userRow['USER_TYPE_ID'];                  

            $query = "SELECT TYPE FROM OJC_USER_TYPE WHERE USER_TYPE_ID = :id";       
            $stmt = $this->conn->prepare($query);
    
            //Bind value.
            $stmt->bindParam(':id', $registeredUserTypeId);
      
            //Execute.
            $stmt->execute();
            $userTypeRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if($userTypeRow){
                $registeredUserType = $userTypeRow['TYPE'];
            
                if($requestingUsertype == $registeredUserType){
                    $result = true;
                }
                else{
                    $result = false; 
                }
            }
        }        
        echo $userID;
        echo $requestingUsertype;
        echo $registeredUserTypeId;
        echo $registeredUserType;
        return $result;
    }

    function getUserType($userTypeId){
        $result = NULL;
        $query = "SELECT * FROM OJC_USER_TYPE WHERE USER_TYPE_ID = :userTypeId";       
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':userTypeId', $userTypeId);
  
        //Execute.
        $stmt->execute();
        $userTypeRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userTypeRow){
            $result = $userTypeRow['TYPE'];
        }
        return $result;
    }

    function getUserTypeId($usertype){
        $result = NULL;
        $query = "SELECT USER_TYPE_ID FROM OJC_USER_TYPE WHERE TYPE = :type";       
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':type', $usertype);
  
        //Execute.
        $stmt->execute();
        $userTypeRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userTypeRow['USER_TYPE_ID'];
    }

    function insertUser($fname, $lname, $email, $password, $usertype)
    {        
        $last_id = NULL;
        $query = "INSERT INTO OJC_USER (FIRST_NAME, LAST_NAME, USER_NAME, PASSWORD, USER_TYPE_ID) VALUES (:fname, :lname, :email, :password, :user_type_id)";
        $stmt = $this->conn->prepare($query); 
        
        $user_type_id = $this->getUserTypeId($usertype);

        //Bind value.
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_type_id', $user_type_id);

        //Execute.
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        
       /* echo "*** New created id = ". $last_id;*/
        return $last_id;
    }

    function getUser($user_id)
    {
        $query = "SELECT * FROM OJC_USER WHERE USER_ID = :user_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':user_id', $user_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRow;                  
    }

    function getAllUser()
    {
        $query = "SELECT * FROM OJC_USER";        
        $stmt = $this->conn->prepare($query); 
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userRow;                  
    }

	function insertOAuthUser($token, $userData, $user_type) {
        $user_id = NULL;
        /* Insert the details in the OJC_GOOGLE_OAUTH table */
        $query = "INSERT INTO OJC_GOOGLE_OAUTH (OAUTH_TOKEN, OAUTH_USER_F_NAME,OAUTH_USER_L_NAME,OAUTH_USER_EMAIL,OAUTH_USER_PHOTO) VALUES (:token, :fname, :lname, :email, :photo)";
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':fname', $userData['given_name']);
        $stmt->bindParam(':lname', $userData['family_name']);
        $stmt->bindParam(':email', $userData['email']);
        $stmt->bindParam(':photo', $userData['picture']);

        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($userRow)){
            $oauth_id = $userRow['GOOGLE_OAUTH_ID'];
        }

        /* Insert the details in the OJC_USER table */
		$query = "INSERT INTO OJC_USER (USER_NAME, PASSWORD, USER_TYPE_ID, GOOGLE_OAUTH_ID) VALUES (:email, :password, :user_type, :user_oauth_id)";
        $stmt = $this->conn->prepare($query); 
        
        //Bind value.
         $stmt->bindParam(':email', $userData->email);
         $stmt->bindParam(':password', $userData->name);
         $stmt->bindValue(':user_type', $user_type);               
         $stmt->bindParam(':user_oauth_id', $oauth_id);

        //Execute.
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($result)){
            $user_id = $result['USER_ID'];
        }
        return $user_id;
    }
    
    function validateJobData($user_id, $org_name, $org_location, $job_title, $job_industry, $job_location, $job_type, $skills, $experience)
    { 
        $error_msg = "";
    
        if(empty($user_id) ||
           empty($org_name) ||
           empty($org_location) ||
           empty($job_title) ||
           empty($job_industry) ||
           empty($job_location) ||
           empty($job_type) ||
           empty($skills) ||
           empty($experience)){
            $error_msg  = "error1";/* Value is empty */
            return $error_msg;
        }        
    }

    function insertNewJob($user_id, $org_name, $org_location, $job_title, $job_industry, $job_location, $job_type, $skills, $experience)
    {   
        $last_id = NULL;
        $query = "INSERT INTO OJC_JOB (USER_ID,ORG_NAME, ORG_LOCATION, JOB_TITLE, JOB_INDUSTRY, JOB_LOCATION, JOB_TYPE, JOB_SKILLS, JOB_EXPERIENCE) VALUES (:id, :org_name, :org_location, :title, :industry, :job_location, :job_type, :skills, :experience)";
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':org_name', $org_name);
        $stmt->bindParam(':org_location', $org_location);
        $stmt->bindParam(':title', $job_title);
        $stmt->bindParam(':industry', $job_industry);
        $stmt->bindParam(':job_location', $job_location);
        $stmt->bindParam(':job_type', $job_type);
        $stmt->bindParam(':skills', $skills);
        $stmt->bindParam(':experience', $experience);

        //Execute.
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        
        echo "*** New created id = ". $last_id;
        return $last_id;
    }

    function getAllJobs($user_id)
    {
        $query = "SELECT * FROM OJC_JOB WHERE USER_ID = :id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':id', $user_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userRow; 
    }  
    
    function getAllJobsByOrgName($org_name)
    {
        $query = "SELECT * FROM OJC_JOB WHERE ORG_NAME = :org_name";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':org_name', $org_name);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userRow; 
    }  
    
    function getJobDetails($job_id)
    {
        $query = "SELECT * FROM OJC_JOB WHERE JOB_ID = :job_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':job_id', $job_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRow; 
    }      

    function deleteJob($job_id){
        $query = "DELETE FROM OJC_USER WHERE USER_ID = :user_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':user_id', $job_id);
  
        //Execute.
        $stmt->execute();
    }

    function validateJSProfileData($user_id, $job_title, $job_industry, $job_location,$job_type, $skills, $experience)
    {    
        $error_msg = "";
    
        if(empty($user_id) ||
           empty($job_title) ||
           empty($job_location) ||         
           empty($job_industry) ||
           empty($job_type) ||
           empty($skills) ||
           empty($experience)){
            $error_msg  = "error1";/* Value is empty */
            return $error_msg;
        }        
    }

    function insertJSProfile($user_id, $job_title, $job_industry, $job_location, $job_type, $skills, $experience)
    {   
        $last_id = NULL;
        $query = "INSERT INTO OJC_JS_PROFILE (USER_ID, JOB_TITLE, JOB_INDUSTRY, JOB_LOCATION, JOB_TYPE, JOB_SKILLS, JOB_EXPERIENCE) VALUES (:id, :title, :job_industry, :job_location, :job_type, :skills, :experience)";
        $stmt = $this->conn->prepare($query); 

        //Bind value.
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':title', $job_title);
        $stmt->bindParam(':job_industry', $job_industry);
        $stmt->bindParam(':job_location', $job_location);
        $stmt->bindParam(':job_type', $job_type);
        $stmt->bindParam(':skills', $skills);
        $stmt->bindParam(':experience', $experience);

        //Execute.
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        
        echo "*** New created id = ". $last_id;
        return $last_id;
    }

    function getAllJSProfile()
    {
        $query = "SELECT * FROM OJC_JS_PROFILE";        
        $stmt = $this->conn->prepare($query); 
  
        //Execute
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userRow; 
    }  

    function getJSProfileByUserId($user_id)
    {
        $query = "SELECT * FROM OJC_JS_PROFILE WHERE USER_ID = :id";        
        $stmt = $this->conn->prepare($query);
        //Bind value.
        $stmt->bindParam(':id', $user_id);   
  
        //Execute
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRow; 
    } 

    function ifUserProfileUpdated($user_id)
    {
        $query = "SELECT * FROM OJC_JS_PROFILE WHERE USER_ID = :id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':id', $user_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userRow;     
    }
    function getRecruiterDetails($job_id){

    }

    function insertJobOffer($user_id, $job_id, $subject, $message)
    {   
        $last_id = NULL;
        $query = "INSERT INTO OJC_OFFER (USER_ID, JOB_ID, SUBJECT, MESSAGE) VALUES (:user_id, :job_id, :subject, :message)";
        $stmt = $this->conn->prepare($query); 

        //Bind value.
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':job_id', $job_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        //Execute.
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        
        //echo "*** New created id = ". $last_id;
        return $last_id;
    }

    function getNOffers($job_id)
    {        
        $result = 0;
        $query = "SELECT * FROM OJC_OFFER WHERE JOB_ID = :id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':id', $job_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($userRow){
            foreach($userRow as $data){
                $result += 1; 
            }
        }
        return $result; 
    }

    function getOfferDetails($job_id)
    {
        $query = "SELECT * FROM OJC_OFFER WHERE JOB_ID = :job_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':job_id', $job_id);
  
        //Execute.
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }

    function getOfferDetailsByOfferId($offer_id)
    {
        $query = "SELECT * FROM OJC_OFFER WHERE OFFER_ID = :offer_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':offer_id', $offer_id);
  
        //Execute.
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
    } 

    function getNOffersByUserId($user_id)
    {        
        $result = 0;
        $query = "SELECT * FROM OJC_OFFER WHERE USER_ID = :id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':id', $user_id);
  
        //Execute.
        $stmt->execute();
        $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($userRow){
            foreach($userRow as $data){
                $result += 1; 
            }
        }
        return $result; 
    }

    function getOfferDetailsByUserId($user_id)
    {
        $query = "SELECT * FROM OJC_OFFER WHERE USER_ID = :user_id";        
        $stmt = $this->conn->prepare($query); 
        //Bind value.
        $stmt->bindParam(':user_id', $user_id);
  
        //Execute.
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }

    function getJobIndustryList()
    {
        $query = "SELECT * FROM OJC_JOB_INDUSTRY ORDER BY TYPE";        
        $stmt = $this->conn->prepare($query);   
        //Execute.
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }

    function getJobTypeList()
    {
        $query = "SELECT * FROM OJC_JOB_TYPE ORDER BY TYPE";        
        $stmt = $this->conn->prepare($query);   
        //Execute.
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }
    
    function getExperienceList()
    {
        $query = "SELECT * FROM OJC_JOB_EXPERIENCE ORDER BY TYPE";        
        $stmt = $this->conn->prepare($query);   
        //Execute.
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; 
    }

    function validateContactForm($name, $email, $subject, $message)
    {    
        $error_msg = "";
    
        if(empty($name) ||
           empty($email) ||
           empty($subject) ||         
           empty($message)){
            $error_msg  = "error1";/* Value is empty */
            return $error_msg;
        }        
    }
    function insertContactForm($name, $email, $subject, $message)
    {
        $last_id = NULL;
        $query = "INSERT INTO OJC_CONTACT (FULL_NAME, EMAIL_ADDRESS, EMAIL_SUBJECT, EMAIL_MESSAGE) VALUES (:name, :email, :subject, :message)";
        $stmt = $this->conn->prepare($query); 

        //Bind value.
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        //Execute.
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        
        echo "*** New created id = ". $last_id;
        return $last_id;
    }

    function searchCandidate($job_details)
    {        
        $query = "SELECT USER_ID FROM `OJC_JS_PROFILE` WHERE `JOB_INDUSTRY`= '".$job_details['JOB_INDUSTRY']."' AND `JOB_TYPE` = '".$job_details['JOB_TYPE']."' AND `JOB_EXPERIENCE` = '".$job_details['JOB_EXPERIENCE']."'";

        $title_terms = explode(" ", $job_details['JOB_TITLE']);
        $i = 0;
        foreach($title_terms as $title_term){
            $title_term = trim($title_term);
            $i = $i + 1;
            if ($i == 1){
                $query .= " AND ( `JOB_TITLE` LIKE '%".$title_term."%'";
            }
            else{
                $query .= " OR `JOB_TITLE` LIKE '%".$title_term."%'";
            }
        }
        if($i >0){
            $query .= ") ";
        }

        $title_skills = explode(",", $job_details['JOB_SKILLS']);
        $i = 0;
        foreach($title_skills as $title_skill){
            $title_skill = trim($title_skill);
            $skill_word = explode(" ", $title_skill);
            foreach($skill_word as $word){
                $i = $i + 1;
                if ($i == 1){
                    $query .= "AND (`JOB_SKILLS` LIKE '%".$word."%'";
                }
                else{
                    $query .= " OR `JOB_SKILLS` LIKE '%".$word."%'";
                }
            }  
        }             
        if($i >0){
            $query .= ") ";
        }     

        //echo $query;
        
        $stmt = $this->conn->prepare($query);

        //Execute.
        $stmt->execute();
        
        $userIDRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userIDRows;

    }

    function searchCandidateBySelection($industry,$jobType,$experience,$jobTitle,$skills)
    {  
        $query = "SELECT JOB_ID FROM `OJC_JOB` WHERE";

        if($industry > 0 ){
            $query .= "`JOB_INDUSTRY`= '".$industry."'";
        }
        if($jobType >0){
            if($industry > 0){
                $query .= " AND ";    
            }
            $query .= " `JOB_TYPE`= '".$jobType."'";
        }
        
        if($experience >0){
            if($industry > 0 || $jobType >0 ){
                $query .= " AND ";    
            }
            $query .= " `JOB_EXPERIENCE`= '".$experience."'";
        }
        if($jobTitle != ""){
            $title_terms = explode(" ", $jobTitle);
            $i = 0;
            foreach($title_terms as $title_term){
                $title_term = trim($title_term);
                $i = $i + 1;
                if ($i == 1){
                    $query .= " AND ( `JOB_TITLE` LIKE '%".$title_term."%'";
                }
                else{
                    $query .= " OR `JOB_TITLE` LIKE '%".$title_term."%'";
                }
            }
            if($i >0){
                $query .= ") ";
            }
        }
        if(!empty($skills)){
            $title_skills = explode(",", $skills);
            $i = 0;
            foreach($title_skills as $title_skill){
                $title_skill = trim($title_skill);
                $i = $i + 1;
                if ($i == 1){
                    $query .= "AND (`JOB_SKILLS` LIKE '%".$title_skill."%'";
                }
                else{
                    $query .= " OR `JOB_SKILLS` LIKE '%".$title_skill."%'";
                }
            }
            if($i >0){
                $query .= ") ";
            }
        }  
        //echo $query;
        
        $stmt = $this->conn->prepare($query);

        //Execute.
        $stmt->execute();
        
        $jobIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $jobIds;

    }

    function getIndustryType($industryId){
        $result = NULL;
        $query = "SELECT * FROM OJC_JOB_INDUSTRY WHERE JOB_INDUSTRY_ID = :industryId";       
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':industryId', $industryId);
  
        //Execute.
        $stmt->execute();
        $industryRow= $stmt->fetch(PDO::FETCH_ASSOC);
        if($industryRow){
            $result = $industryRow['TYPE'];
        }
        return $result;
    }

    function getJobType($jobTypeId){
        $result = NULL;
        $query = "SELECT * FROM OJC_JOB_TYPE WHERE JOB_TYPE_ID = :jobTypeId";       
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':jobTypeId', $jobTypeId);
  
        //Execute.
        $stmt->execute();
        $jobTypeRow= $stmt->fetch(PDO::FETCH_ASSOC);
        if($jobTypeRow){
            $result = $jobTypeRow['TYPE'];
        }
        return $result;
    }

    function getExperienceType($experienceId){
        $result = NULL;
        $query = "SELECT * FROM OJC_JOB_EXPERIENCE WHERE JOB_EXPERIENCE_ID = :experienceId";       
        $stmt = $this->conn->prepare($query);

        //Bind value.
        $stmt->bindParam(':experienceId', $experienceId);
  
        //Execute.
        $stmt->execute();
        $experienceTypeRow= $stmt->fetch(PDO::FETCH_ASSOC);
        if($experienceTypeRow){
            $result = $experienceTypeRow['TYPE'];
        }
        return $result;
    }
}