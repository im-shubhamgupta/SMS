<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['sessionid'])){


if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id";
	$response["result"] =[]; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

 
 $result=EmergencyContact();
 	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
	
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "No Data";
			$response["result"] =[];
			echo json_encode($response);  
	}

	 
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter student_id, sessionid ";
	$response["result"] =[];
	echo json_encode($response); 
}

