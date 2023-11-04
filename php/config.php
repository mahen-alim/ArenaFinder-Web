<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('476139599494-u3g2fp7ubo0qi56c7942vjr7gr6gu2o2.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/ArenaFinder/php/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>