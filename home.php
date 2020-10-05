<link rel="stylesheet" href="./assets/css/home.css" type="text/css">

<div class="main">
    <?php include './includes/home_header.php';?>
    <div class="home-container">
        <div class="about-item about-container">        
            <div class="services-item">
                <h2>Who we are?</h2>
                <p>Opportunity Job Centre (OJC) is a newly established government-funded employment agency. Our aim is to help people (Job Seekers) of working age to find employment. Our plan includes providing resources to enable job-searchers to find work, through telephone service and our OJC website. </p>
                <h2>What services we offer?</h2>
                <div class="service-card-container">
                    <div class="service1">
                        <h4>Are you a Job Seeker?</h4>
                        <p> We can help you land your dream job!</p>
                        <?php 
                            if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "R")){?>
                                <button onclick="window.location.href='index.php?id=jobseeker'" disabled>More Info</button>
                            <?php
                            }
                            else{?>
                                <button onclick="window.location.href='index.php?id=jobseeker'">More Info</button>
                            <?php
                            }?>
                    </div>
                    <div class="service2">
                        <h4>Are you a Recruiter?</h4>
                        <p>We can help you find a star candidate!</p>
                        <?php 
                            if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "JS")){?>
                                <button onclick="window.location.href='index.php?id=recruiter'" disabled>More Info</button>
                            <?php
                            }
                            else{?>
                                <button onclick="window.location.href='index.php?id=recruiter'">More Info</button>
                            <?php
                            }?>                        
                    </div>
                    <div class="service3">
                        <h4>I'm a Job Seeker!</h4>
                        <p>You can find out the latest jobs around your location..</p>
                        <?php 
                            if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "R")){?>
                                <button onclick="window.location.href='index.php?id=jobseeker'" disabled>More Info</button>
                            <?php
                            }
                            else{?>
                                <button onclick="window.location.href='index.php?id=jobseeker'">More Info</button>
                            <?php
                            }?>
                    </div>
                    <div class="service4">
                        <h4>I'm a Recruiter!</h4>
                        <p>You can submit your vacancies and become our partner and advertise your profile with us..</p>
                        <?php 
                            if(isset($_SESSION["USER_TYPE"]) && ($_SESSION["USER_TYPE"] == "JS")){?>
                                <button onclick="window.location.href='index.php?id=recruiter'" disabled>More Info</button>
                            <?php
                            }
                            else{?>
                                <button onclick="window.location.href='index.php?id=recruiter'">More Info</button>
                            <?php
                            }?>
                    </div>
                </div>
            </div> 
        </div>
        <div class="partnerLogos-item">
            <h2>Our Partners</h2>
            <ul> 
                <li class="partner-list">
                    <a href="index.php?id=company1"><img src="./assets/img/Banking/logo.png" alt="Life Groups" /></a>
                </li>
                <li class="partner-list">
                    <a href="javascript:void(0);"><img src="./assets/img/IT/logo.png" alt="OJC" /></a>
                </li > 
                <li class="partner-list">
                    <a href="javascript:void(0);"><img src="./assets/img/Holistic_center/logo.png" alt="OJC" /></a>
                </li>
            </ul>
        </div>
        <div class="sidebar-item">
            <div class="lastestUpdates">
                <h2>Latest Updates</h2>
                <ul class="news">
                    <li class=""><a href="">OJC News</a></li>
                    <li class=""><a href="https://www.gov.uk/guidance/coronavirus-covid-19-what-to-do-if-youre-employed-and-cannot-work">Guidance
                    Coronavirus (COVID-19): what to do if you were employed and have lost your job - GOV.UK</a></li>
                    <li class=""><a href="https://www.gov.uk/apply-national-insurance-number">How to apply for a National Insurance number - GOV.UK</a></li>
                    <li class=""><a href="https://www.thejobfairs.co.uk/">Book your place in 2020 Job Fairs</a></li>
                    <li class=""><a href="">Archives</a></li>
                </ul>
            </div>
            <div class="featuredAdverts">                
                <h2>Featured Advert<span class="title">Job@ Eloquent Ltd</span></h2>
                <video controls>
                    <source src='./assets/video/advert1.mp4' type="video/mp4">
                    <track default kind="subtitles" label="English" srclang="en" src="/assets/video/advert1.vtt"/>Sorry, your browser doesn't support embedded videos.</video>
            </div>
        </div>  
    </div>
</div>