<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

$result=leavetype();

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "No Details";
			$response["result"] = [];
			echo json_encode($response);  
	}

	// echo leavetype();


?>