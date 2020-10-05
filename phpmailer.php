<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
//require '../vendor/autoload.php';
require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
//$sender = 'sandeep.senguttuvan@gmail.com';
//$senderName = 'Sandeep Senguttuvan';
$sender = 'enquiriesOJC@gmail.com';
$senderName = 'OJC Admin';
$sendCopyTo = 'enquiriesOJC@gmail.com';
$sendCopyToName = 'OJC Admin';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
//$recipient = 'sandeepsalone@yahoo.com';
//$recipient = 'deepikasandp@gmail.com';

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = '';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = '';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = '';
$port;

// The subject line of the email
//$subject = 'Amazon SES test (SMTP interface accessed using PHP)';

// The plain-text body of the email
 //$bodyText =  "Email Test\r\nThis email was sent through the
 //Amazon SES SMTP interface using the PHPMailer class.";

// The HTML-formatted body of the email
// $bodyHtml = '<h1>Email Test</h1>
//     <p>This email was sent through the
//     <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
//     interface using the <a href="https://github.com/PHPMailer/PHPMailer">
//     PHPMailer</a> class.</p>';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.
    $mail->AddCC("$sendCopyTo", "$sendCopyToName");

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();

    if(isset($_POST['contactSubmit']))
    {
        header('Location:../index.php?id=contact&status=success&dbUpdateStatus='.$updateStatus);
    } 
    else if(isset($_POST['sendOfferMail']))
    {
        echo "Mail sent successfully";       
    }  
    //echo "Email sent!" , PHP_EOL;
    } 
    catch (phpmailerException $e) 
    {
        //echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
        if(isset($_POST['contactSubmit']))
        {
            header('Location:../index.php?id=contact&status=failure&dbUpdateStatus='.$updateStatus);
        } 
        else if(isset($_POST['sendOfferMail']))
        {
            //echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
            echo "Unable to send mail, try again!";       
        }  
    } 
    catch (Exception $e) 
    {
        //echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
        if(isset($_POST['contactSubmit'])){
            header('Location:../index.php?id=contact&status=failure&dbUpdateStatus='.$updateStatus);
        } 
        else if(isset($_POST['sendOfferMail']))
        {
            //echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
            echo "Unable to send mail, try again!";       
        }
    }

?>

