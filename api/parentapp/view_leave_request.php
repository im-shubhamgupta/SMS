<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['student_id']) && isset($_REQUEST['class_id']) && isset($_REQUEST['section_id'])  && isset($_REQUEST['sessionid']) ){

if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$student_id= $_REQUEST['student_id']; 
$class_id= $_REQUEST['class_id']; 
$section_id= $_REQUEST['section_id']; 

$sessionid= $_REQUEST['sessionid'];

$result=view_leave_request($student_id,$class_id,$section_id,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "Not any Request";
			$response["result"] = [];
			echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, sessionid ";
	$response["result"] = [];
	echo json_encode($response); 

}


	// echo gallerycount($object->stuid);





?>