<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

// $class_id=isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : '';
// $section_id=isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';
$session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';


	$result=view_feedback($session_id,$current_page, $per_page);

		if(!empty($result['total_records'])){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Not Found";

			echo json_encode($response);   

		}
	

?>