<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if( isset($_REQUEST['stuid']) && isset($_REQUEST['sessionid']) ){

// isset($_REQUEST['fromdate']) && isset($_REQUEST['todate'])  &&  //set one month default
$fromdate= $_REQUEST['fromdate']; 
$todate= $_REQUEST['todate']; 
$stuid= $_REQUEST['stuid']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];
$current_page=isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
$per_page=isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
echo $result=eventcalendar($fromdate,$todate,$stuid,$sessionid,$current_page,$per_page);

	// if(!empty($result)){
	//         $response["status"] = 1;
	// 		$response["message"] = "Success"; 
	// 		$response["current_page"] = $result['current_page'];
	// 		$response["per_page"] = $result['per_page'];
	// 		$response["total_page"] = $result['total_page'];
	// 		$response["total_records"] = $result['total_records'];
	// 		$response["result"] = $result['data'];
	// 		echo json_encode($response);   
	// }else{
	// 		$response["status"] = 0;
	// 		$response["message"] = "No Events";
	// 		echo json_encode($response);  
	// }

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid,  sessionid is missing";
	$response["result"] = [];
	echo json_encode($response); 

}

	// echo eventcalendar($object->fromdate,$object->todate,$object->classid,$object->sectionid);

	



 ?>