<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['stuid']) && isset($_REQUEST['sessionid']) ){


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


$result=student_year($stuid,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "Not Found";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, sessionid is missing ";
	$response["result"] = [];
	echo json_encode($response); 

}


	// echo stuyearlyattendance($object->stuid,$object->years);






?>