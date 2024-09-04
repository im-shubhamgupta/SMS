<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

// if( isset($_REQUEST['sessionid']) ){

// $sessionid= $_REQUEST['sessionid'];
// echo 1324;
$result = requesttype();

if (!empty($result)) {
	$response["status"] = 1;
	$response["message"] = "Success";
	$response["result"] = $result;
	echo json_encode($response);
} else {
	$response["status"] = 0;
	$response["message"] = "No Details";
	$response["result"] = [];
	echo json_encode($response);
}

// }else{
// 	$response["status"] = 2;
// 	$response["message"] = "Required Parameter sessionid";
// 	echo json_encode($response); 

// }

	// echo requesttype();
