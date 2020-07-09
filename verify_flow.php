<?php
/**
 * Verify Phone API for Chatfuel
 * Created by Edmund Cinco
 * Website: https://www.edmundcinco.com
 */

// Twilio PHP Helper Library
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

$sid    = "your_twilio_sid_here";
$token  = "your_twilio_auth_token_here";
$twilio = new Client($sid, $token);

session_id($_POST['messenger_user_id']); // create a session id using {{messenger user id}}
session_start();

$verification_code = $_POST['verification_code'];

$from    = "whatsapp:" . "+14155238886"; // your Twilio number
$to      = "whatsapp:" . $_POST['userPhone'];
$message = "Verification has been successfully completed. Thank you!";

if ($_SESSION["challenge_code"] == $verification_code) {
    
    $message = $twilio->messages
                      ->create($to, // to
                               array(
                                   "from" => $from,
                                   "body" => $message
                               )
                      );

    $json = '{
                "set_attributes":
                  {
                    "status": "success"
                  }
              }';

} else {
    
    $json = '{
                "set_attributes":
                  {
                    "status": "failed"
                  }
              }';

}

echo $json;

session_destroy();
