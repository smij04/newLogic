<?php
require_once("vendor/autoload.php");
require 'functions.php';

use Spatie\Browsershot\Browsershot;

//url of page 
$url = 'https://www.newlogic.cz/kontakt/';

//set the empty array for numbers to store
$phone_numbers = [];
$regex = '/([+]\d{1,3}[. \s])(\d{3}?[. \s]?)(\d{3}?[. \s]?)(\d{3}?[. \s]?)/';

while(true) {
    //get the page content
    $webContent = file_get_contents($url);

    //search for number in the page
    preg_match_all($regex,$webContent,$extract_numbers);

    if (empty($phone_numbers)) {
        //we don't need to send info and save screenshot when we run the script for a first time
        $phone_numbers = $extract_numbers[0];
    } else {
        if (!empty(array_diff($phone_numbers,$extract_numbers[0]))) {
            //get the old and new phone numbers
            $diff_old = array_diff($phone_numbers,$extract_numbers[0]);
            $diff_new = array_diff($extract_numbers[0],$phone_numbers);

            //send info
            sendEmail($diff_old,$diff_new);
            sendSMS($diff_old,$diff_new);
            takeScreenshot($url);

            //rewrite existing phone numbers
            $phone_numbers = $extract_numbers[0];
        }
    }

    //sleep for an hour
    //there will occur a problem, that if we take a screenshot where we wait for 4 seconds, this will actually sleep for more than an hour
    sleep(3600);
}



?>