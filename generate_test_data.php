<?php

require_once dirname(__FILE__) . '/conf/config.inc.php';

// Connect to MySQL 
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

header('Content-Type: text/plain');

$companies = array(
    'Edina Realty',
    'Judy and Judd LLP',
    'Parkdale Therapy',
    'VoxMedia Group',
    'The Recurring Billing Agency',
    'Subscriptions-R-Us'
    );

$counter = 0;

while ($counter < 85)
{
    $counter++;

    // Get random date
    $int= mt_rand(1427864400,1433134800);

    $sql = "INSERT INTO `usage_data`(`customer_name`, `delivery_datetime`, `package_count`) VALUES ('" . $companies[rand(0, 5)] . "','" . date("Y-m-d H:i:s", $int) . "','" . rand(1, 4) . "')";

    $retr = mysqli_query($link, $sql);
}




