<?php

require_once dirname(__FILE__) . '/conf/config.inc.php';

// Connect to MySQL 
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Get posted JSON and decode to an object
$usage_request = json_decode( file_get_contents('php://input') );

if (!$usage_request->customer)
{
	die('There was no data sent');
}

//-----------------------------------------------------
// Objects posted with the usage request (See full docs at: https://developer.chargeover.com/apidocs/usage/)
//-----------------------------------------------------

// Customer
$customer = $usage_request->customer;

// Billing Package
$package = $usage_request->package;

// Line item that this usage request is for
$this_line_item = $usage_request->this_line_item;

// Billing period range
$from = $usage_request->from_datetime;
$to = $usage_request->to_datetime;

// Security token which can be used to validate the request
$token = $usage_request->security_token;


//-----------------------------------------------------
// Let's get some usage from from MySQL
//-----------------------------------------------------

// Query based on the customer name and date range -  *NOTE: If you have a unique ID in your system, you can store that value in ChargeOver as an external_key

$sql = "SELECT SUM(`package_count`) AS count FROM `usage_data` WHERE customer_name='" . $customer->company . "' AND delivery_datetime >= '" . $from . "' AND delivery_datetime <= '" . $to . "'";

$res = mysqli_query($link, $sql, MYSQLI_USE_RESULT);

$db_usage = mysqli_fetch_array($res);

// Create array to return
$usage_response = array(
	'line_items' => array(
		array(
			'usage_ammount' => $db_usage['count'],
			),
		),
	);

// Return array as JSON
print json_encode($usage_response);