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

$verification_code = generateRandomNumber(6); // can generate up to 255

$_SESSION["challenge_code"] = $verification_code;

/*
	Send verification code
 */
$from	 = "whatsapp:" . "+14155238886"; // your Twilio number
$to      = "whatsapp:" . $_POST['userPhone'];
$message = $verification_code . " is your 'Verify Phone API' verification code. Don't reply to this message.";

$message = $twilio->messages
                  ->create($to, // to
                           array(
                               "from" => $from,
                               "body" => $message
                           )
                  );

function generateRandomNumber($length = 255)
{

    return substr(str_shuffle(str_repeat($x = '0123456789', ceil($length / strlen($x)))), 1, $length);

}
