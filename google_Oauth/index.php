<?php
    //require_once './vendor/autoload.php';
    require_once './google-api-php-client-2.5.0/google-api-php-client-2.5.0/vendor/autoload.php';
    //require_once './google-api-php-client-2.1.3/google-api-php-client-2.1.3/vendor/autoload.php';
    
    // apiclent
    $google_client = new Google_Client();

    // set oAuth 2.0 client id
    $google_client->setClientId('');


    //set client auth secret key
    $google_client->setClientSecret('');
    
    //redirection url
    $google_client->setRedirectUri('');

    $google_client->addScope('email');
    $google_client->addScope('profile');
    
    $login_button = $google_client->createAuthUrl();
?>
