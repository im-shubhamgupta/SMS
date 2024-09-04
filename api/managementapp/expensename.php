<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
 if(isset($_REQUEST['sessionid'])){
	 
	 $sessionid=$_REQUEST['sessionid'];
	 
	 
	$result=expensename($sessionid);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "No Expense";

			echo json_encode($response);   

		}

 }else{
	 
	   $response["status"] = 2;

		$response["message"] = "Required Parameter   is missing"; 

	    echo json_encode($response); 
	 
 }

	

?>