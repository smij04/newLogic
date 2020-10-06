<?php
require_once("vendor/autoload.php");
use Spatie\Browsershot\Browsershot;


//The screenshot function is not working properly. For some reason the Spatie can not take a screenshot of a fullpage, nor can it scroll or take a clip
//I have left all the options i have tried commented.
function takeScreenshot($url) {
    //we will probably not need minutes and seconds given that the script will run every hour
    $filename = strval(date("Ymd_H-m-s")) . ".png";
    $path = 'assets/screenshots/';
    Browsershot::url($url)
    // ->waitUntilNetworkIdle()
    // ->disableJavascript()
    ->fullPage()
    // ->select('wrp_comp_body row--flex flex--wrap')
    // ->clip($x, $y, $width, $height)
    ->setDelay(4000)
    // ->clip(0, 400, 900, 500)
    // ->setDelay(4000)
    ->save($path . $filename);
}


function sendEmail($previous_numbers, $new_numbers ) {
    $date = date("d.m.Y");
    $time = date("H:m:s");
    $address = "test@newlogic.cz";
    $subject = "change in phone numbers";
    $msg = "Hello\n
    this e-mail is automatically generated to inform you, that on " . $date . " in " . $time . " there has occured some changes in phone numbers.\n
    the changes were as follows:\n";
    for ($i = 1 ; $i <= sizeof($previous_numbers) ; $i ++) {
        $msg .= "   " . $previous_numbers[$i] . "  =>  " . $new_numbers[$i] . "\n";
    }
    $msg .= "\n
    Best Regards\n
    Team New Logic\n";

    //the e-mail will not be send unless the SMTP ports and setting in php.ini are correctly set
    mail($address,$subject,$msg);
}

function sendSMS($previous_numbers, $new_numbers ) {
    $date = date("d.m.Y");
    $time = date("H:m:s");
    $number = 776872777;
    $msg = "Hello\n
    this SMS is automatically generated to inform you, that on " . $date . " in " . $time . " there has occured some changes in phone numbers.\n
    the changes were as follows:\n";
    for ($i = 1 ; $i <= sizeof($previous_numbers) ; $i ++) {
        $msg .= "   " . $previous_numbers[$i] . "  =>  " . $new_numbers[$i] . "\n";
    }
    $msg .= "\n
    Best Regards\n
    Team New Logic\n";

    //We will shot the message in terminal instead of sending sms
    echo $msg;
    //send email via some SMS gateway. Forexample we can use messagebird.com
}

?>