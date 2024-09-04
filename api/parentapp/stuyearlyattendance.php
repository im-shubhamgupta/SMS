<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['stuid']) && isset($_REQUEST['sessionid']) && isset($_REQUEST['year'])){


if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
if(empty($_REQUEST['stuid'])){
	$response["status"] = 3;
	$response["message"] = "Required Student id no"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$stuid=mysqli_real_escape_string($con,$_REQUEST['stuid']); 
$sessionid=mysqli_real_escape_string($con, $_REQUEST['sessionid']);
$year=mysqli_real_escape_string($con,$_REQUEST['year']);

$result=stuyearlyattendance($stuid,$year,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["att_detail"] =$result[1]; 
			$response["result"] = $result[0];
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "Invalid Details";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, sessionid, year is missing ";
	$response["result"] = [];
	echo json_encode($response); 

}


	// echo stuyearlyattendance($object->stuid,$object->years);






?>