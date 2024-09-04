<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['sessionid']) ){

$sessionid= $_REQUEST['sessionid'];
$class_id= $_REQUEST['class_id'];
$student_id=!empty($_REQUEST['student_id']) ? $_REQUEST['student_id'] : '' ;
$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

	if(!empty($student_id)){
		$result=studentdetail_byid($sessionid,$student_id);
	}else{
		$result=studentdetail($sessionid,$class_id,$student_id, $current_page, $per_page);
	}
	
	

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			// $response["result"] = $result;

			$response["status"] = 0;

			$response["message"] = "Not Found";
			

			echo json_encode($response);   

		}


}else{
    
    	$response["status"] = 2;
    	$response["message"] = "Provide Required Parameter";

	    echo json_encode($response);
}



?>