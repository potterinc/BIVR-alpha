<?php

/**
 * Send the mail to yourself because the sender may use a forged email address
 * Instead, add the sender's mail to the replyPath
 * in whichc case, the entire request should be ignored
 * 
 * */

// PHPMailer configuration and dependencies
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'src/PHPMailer.php';
require 'src/SMTP.php';

$mailer = new PHPMailer();
//Server settings
$mailer->SMTPDebug = SMTP::DEBUG_OFF;
$mailer->isSMTP();
$mailer->Host       = 'bivr.io';
$mailer->SMTPAuth   = true;
$mailer->Username   = 'mail@bivr.io';
$mailer->Password   = 'Z4JKsLV_KNIU';
$mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mailer->Port       = 465;

// Recipient
$mailer->setFrom("support@bivr.io", 'CONTACT FORM');
$mailer->addAddress("support@bivr.io");

// Validating the sender email address
if ($mailer->addReplyTo($_REQUEST['email'], $_REQUEST['firstname'] . " " . $_REQUEST['lastname'])) {
    $mailer->isHTML(true);
    $mailer->Subject = "CONTACT FORM";
    $mailer->Body = "{$_REQUEST['message']} <br /><br /><hr /> <br> Yours sincerely,<br>
                <strong>{$_REQUEST['firstname']} {$_REQUEST['lastname']}</strong> <br>
                <strong>{$_REQUEST['email']}</strong><br> <strong>{$_REQUEST['telephone']}</strong><br>";
    $mailer->AltBody = "{$_REQUEST['message']}
                \n\n=================================\nYours sincerely,
                \n{$_REQUEST['firstname']} {$_REQUEST['lastname']}
                \n{$_REQUEST['email']}\n{$_REQUEST['telephone']}";

    // sending the mailer$mailer
    if ($mailer->send()) {
        $response = [
            'status' => true,
            'msg' => 'Message Sent: Thank you for your request'
        ];
        print(json_encode($response, JSON_PRETTY_PRINT));
    } else {
        $response = [
            'status' => false,
            'msg' => 'FAILED: Something went wrong'
        ];
        print(json_encode($response, JSON_PRETTY_PRINT));
    }
} else {
    $response = [
        'status' => false,
        'msg' => 'ERROR: Invalid Email Address, please try agian.'
    ];
    print(json_encode($response, JSON_PRETTY_PRINT));
}