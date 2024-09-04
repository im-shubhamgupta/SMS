<?php 

include('myfunction.php');


if( isset($_REQUEST['stuid'])  && isset($_REQUEST['month'])  && isset($_REQUEST['sessionid']) ){

$student_id= $_REQUEST['stuid']; 
$month= $_REQUEST['month']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=stumonthlyattdetail($student_id,$month,$sessionid);  

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "Invalid Details";
			echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, month, sessionid";
	echo json_encode($response); 

}

	// echo stumonthlyattdetail($object->regno,$object->month);


?>