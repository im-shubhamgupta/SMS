<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['studentid'])  && isset($_REQUEST['requestid']) && isset($_REQUEST['raisedfor']) && isset($_REQUEST['title']) && isset($_REQUEST['description'])  && isset($_REQUEST['sessionid']) ){

$studentid= $_REQUEST['studentid']; 
$requestid= $_REQUEST['requestid']; 
$raisedfor= $_REQUEST['raisedfor']; 
$title= $_REQUEST['title']; 
$description= $_REQUEST['description']; 

if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=feedback($studentid,$requestid, $raisedfor,$title,$description,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "Not Inserted";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter  studentid, requestid, raisedfor, title, description, sessionid ";
	$response["result"] = [];
	echo json_encode($response); 

}

	// echo feedback($object->dateofsubmission, $object->classid, $object->sectionid, $object->studentid,
	// $object->requestid, $object->raisedfor, $object->title, $object->description);


?>