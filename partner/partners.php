<?php
// Include config file
include_once('./config/databaseConfig.php');
include_once('./object/user.php');

$database = new DatabaseConfig();
$db = $database->getConnection();   
$user = new user($db);
$partner1_name = "Life Groups";
?>
  
<div class="main">   
    <?php include './includes/partners_header.php';?>
    <div class="company-container" id="partner1">
        <div class="title">
        <img src="./assets/img/Banking/logo.png" alt="Life Groups" />
           <h2>Life Groups</h2>
           <a href="javascript:void(0);">Visit our website</a>
        </div> 
        <div class="company-details-left">        
            <div class="about">
                <h2>About Us</h2>
                <p> 
                    We are a financial services group with millions of UK customers with a presence in nearly every community; we are familiar on the high street and with over 1 million businesses through our portfolio of brands.
                </p>
                <p>
                    Our business is focused on retail and commercial financial services. We thrive based on how well we serve our customers; on our relationships within the communities we serve; and on helping Britain prosper.
                </p>
            </div>
            <div class="job-openings">
                <h2>Current Job Openings</h2>
                <?php
                $jobsRow = $user->getAllJobsByOrgName($partner1_name);
                if($jobsRow)
                {?>                    
                    <ul>
                        <?php
                            foreach($jobsRow as $jobRow)
                            {?>
                                <li class="job"><a href="javascript:void(0);" onclick="getjobDetails(<?php echo $jobRow['JOB_ID'] ?>)"><?php echo $jobRow['JOB_TITLE'] ?> at <?php echo $jobRow['JOB_LOCATION'] ?></a></li>
                            <?php 
                            }?>
                    </ul>
                <?php 
                }?>
                <div id="displayJobDetails"></div>                
            </div>                    
            <!-- Start of Image Gallery Section -->
            <div class="img-gallery">                
                <h2>Image Gallery</h2>
                <div class="img-column">
                    <img src="./assets/img/Banking/Pic1.jpg" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
                </div>                
                <div class="img-column">
                    <img src="./assets/img/Banking/Pic2.jpg" onclick="openModal();currentSlide(2)" class="hover-shadow cursor">  
                </div>              
                <div class="img-column">
                    <img src="./assets/img/Banking/Pic3.jpg" onclick="openModal();currentSlide(3)" class="hover-shadow cursor">
                </div>                             
                <div class="img-column">
                    <img src="./assets/img/Banking/Pic4.jpg" onclick="openModal();currentSlide(3)" class="hover-shadow cursor">
                </div>
                <div id="myModal" class="modal">
                    <span class="close cursor" onclick="closeModal()">&times;</span>
                    <div class="modal-content">
                        <div class="mySlides">
                            <div class="numbertext">1 / 4</div>
                                <img src="./assets/img/Banking/Pic1Large.jpg">
                        </div>
                        <div class="mySlides">
                            <div class="numbertext">2 / 4</div>
                                <img src="./assets/img/Banking/Pic2Large.jpg">
                        </div>
                        <div class="mySlides">
                            <div class="numbertext">3 / 4</div>
                                <img src="./assets/img/Banking/Pic3Large.jpg">
                        </div> 
                        <div class="mySlides">
                            <div class="numbertext">4 / 4</div>
                                <img src="./assets/img/Banking/Pic4Large.jpg">
                        </div>             
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>
                        <div class="model-img-column">
                            <img class="demo cursor" src="./assets/img/Banking/Pic1.jpg" style="width:100%" onclick="currentSlide(1)" alt="London Head Office">
                        </div>
                        <div class="model-img-column">
                            <img class="demo cursor" src="./assets/img/Banking/Pic2.jpg" style="width:100%" onclick="currentSlide(2)" alt="Team Meetings">
                        </div>
                        <div class="model-img-column">
                            <img class="demo cursor" src="./assets/img/Banking/Pic3.jpg" style="width:100%" onclick="currentSlide(3)" alt="Workspace">
                        </div>
                        <div class="model-img-column">
                            <img class="demo cursor" src="./assets/img/Banking/Pic4.jpg" style="width:100%" onclick="currentSlide(4)" alt="News">
                        </div>
                    </div>
                </div>
            </div>            
            <!-- End of Image Gallery Section -->
            <!-- Start of Video Gallery Section -->          
            <div class="video-gallery">
                <h2>Video Gallery</h2>
                <div class="video-column">
                    <div class="caption-container">Jobs at Fortune Banking Group</div>
                    <video controls>
                        <source src='./assets/video/advert1.mp4' type="video/mp4">
                    </video>
                </div>
                <div class="video-column">
                    <div class="caption-container">Our Mental Health Awareness Day</div>
                    <video controls>
                        <source src='./assets/video/advert1.mp4' type="video/mp4">
                    </video>
                </div>
            </div>            
            <!-- End of Video Gallery Section -->
        </div>           
        <div class="company-details-right">
            <h2>Advertisement</h2>
            <ul class="adverts-column">
                <li class=""><a href="">Coronovirus Updates and Support</a></li>
                <li class=""><a href="">Latest News</a></li>
                <li class=""><a href="">Our WorkForce</a></li>
                <li class=""><a href="">Annual General Meeting 2020(AGM)</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>