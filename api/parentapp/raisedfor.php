<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if( isset($_REQUEST['sessionid']) ){

if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$raised=['Managment'=>'Managment','Teacher'=>'Teacher'];
$data = array();
foreach($raised as $val){

	$temp=array();
	$temp['raise_id']=$val;
	$temp['raise_val']=$val;
	
    array_push($data, $temp);
}


	if(!empty($data)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $data;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "No data Found";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter sessionid ";
	$response["result"] = [];
	echo json_encode($response); 

}

	// echo gallery($object->classid,$object->sectionid,$object->stuid);






?>