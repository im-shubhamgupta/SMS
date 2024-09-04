<?php
include('myfunction.php');
if(isset($_REQUEST['classid']) && isset($_REQUEST['sectionid'])  && isset($_REQUEST['sessionid']) ){

$classid= $_REQUEST['classid']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];  

$result=timetable($classid,$sectionid,$sessionid);

	if(!empty($result)){
        $response["status"] = 1;
		$response["message"] = "Success"; 
		$response["result"] = $result;
		echo json_encode($response); 

	}else{
		$response["status"] = 0;
		$response["message"] = "Time Table Not Created Yet";
		echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter classid, sectionid, sessionid ";
	echo json_encode($response); 

}


	

	// echo timetable($object->classid, $object->sectionid);





?>