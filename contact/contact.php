<?php
$data[] = array();
$data['contact-address-street'] = "Sutherland Building";
$data['contact-address-city'] = "Newcastle-upon-Tyne";
$data['contact-address-postcode'] = "NE1 8ST";
$data['contact-address-phone1'] = "+44 (191) 232 6002";
$data['contact-address-phone2'] = "+44 (191) 227 3903";
?>
<script>
    $(document).ready(function(){
        $('.contact').addClass('active');
        $('.contact').parent().children('a').not('.contact').removeClass('active');
    });  
</script>

<div class="main">    
    <?php include('includes/contact_header.php'); ?> 
    
    <!-- Start Of Contact Form -->
    <div class="contact-container"> 
        <div class="contact-item1"> 
            <?php
                if(isset($_GET['status'])){
                    if(($_GET['status'] === "success") || ($_GET['dbUpdateStatus'] === "success")){
                        echo "<h3 style='color:green;text-align:center'>Thanks for contacting Us. We will get back to you asap!</h3>";
                    }
                    else{
                        echo "<h3 style='color:red;text-align:center'>Something went wrong, unable to submit the form. Please try again!</h3>";
                    }
                }
            ?> 
            <form id="contact-form" class="contact-form-container" onsubmit="return validateContactForm(this);" action="./contact/contact_handler.php" method="post">
                <div class="contact-form-leftPane">
                    <div class="col8">                   
                        <span class="error">* required field</span>
                        <label for="name">Full Name:<span class="error_mark">*</span></label>       
                        <input type="text" id="name" name="name" placeholder="Full Name">                        
                        <span id="errorMsg1"></span>      
                    </div>

                    <div class="col8">
                        <label for="email">Contact:<span class="error_mark">*</span></label>     
                        <input type="email" id="email" name="email" placeholder="Contact Email Address" class="input">
                        <span id="errorMsg2"></span>      
                    </div>

                    <div class="col8">
                        <label for="subject">Subject:<span class="error_mark">*</span></label> 
                        <input type="text" id="subject" name="subject" placeholder="Subject" class="input">                        
                        <span id="errorMsg3"></span>      
                    </div>

                    <div class="col8">
                        <label style="vertical-align: top" for="message">Message:
                        <span class="error_mark">*</span></label>
                        <textarea id="message" name="message" rows="4" cols="50" class="input"></textarea>
                        <span id="errorMsg4"></span>      
                    </div>
                    
                    <div class="col8">                        
                        <input type="submit" value="Submit" name="contactSubmit">
                    </div>
                </div>
                
                <div class="contact-form-rightPane">                 
                    <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1144.8748399462527!2d-1.6079968916224208!3d54.97748883440377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487e70c8a2a4a037%3A0x29992653bff31398!2sNewcastle%20upon%20Tyne%20NE1%208ST!5e0!3m2!1sen!2suk!4v1591452446443!5m2!1sen!2suk" frameborder="0" style="width:100%; height:300px; border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>                    
                    
                    <div class="col8">
                        <h4>Contact Address</h4>
                       <p><?php echo $data['contact-address-street']; ?></p>
                       <p><?php echo $data['contact-address-city']; ?></p>
                       <p><?php echo $data['contact-address-postcode']; ?></p>
                       <p><?php echo $data['contact-address-phone1']; ?></p>
                       <p><?php echo $data['contact-address-phone2']; ?></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Of Contact Form -->
</div>