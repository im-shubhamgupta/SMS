<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['class_id'])  && isset($_REQUEST['session_id']) ){

if(!empty($_REQUEST['session_id'])){
	$session_id=$_REQUEST['session_id'];
}else{
	$response["status"] = '3';
	$response["message"] = "Session can't be empty";
	echo json_encode($response); die;  
}
// if(!empty($_REQUEST['class_id'])){
	$class_id=$_REQUEST['class_id'] ;
// }else{
// 	$response["status"] = '3';
// 	$response["message"] = "Class can't be empty";
// 	echo json_encode($response); die; 

// }
$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

$section_id=$_REQUEST['section_id'];


	$result=transport_fees_paid_students($session_id,$class_id,$section_id, $current_page, $per_page);

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
}else{
	$response["status"] = 2;

	$response["message"] = "Required parameter missing session_id, class_id";

	echo json_encode($response);  

}		

?>