<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if( isset($_REQUEST['expid']) && isset($_REQUEST['sessionid']) ){

	if(!empty($_REQUEST['fromdt'])){
		$fromdt=mysqli_real_escape_string($con,$_REQUEST['fromdt']);
	}else{
		$fromdt='';
	}
	if(!empty($_REQUEST['todt'])){
		$todt=mysqli_real_escape_string($con,$_REQUEST['todt']);
	}else{
		$todt='';
	}
	
	$sessionid=$_REQUEST['sessionid'];
	
	$expid=mysqli_real_escape_string($con,$_REQUEST['expid']);
	
	$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
	$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

	$result=expensedetail($fromdt,$todt,$expid,$sessionid,$current_page,$per_page);

		if(!empty($result['total_records'])){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid id ";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter  expenseid  is missing"; 

	    echo json_encode($response);

	}


	// echo expensedetail($object->fromdt,$object->todt,$object->expid);


?>