<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['deptid']) && isset($_REQUEST['message'])   && isset($_REQUEST['login_userid'])  ){


	$deptid=mysqli_real_escape_string($con,$_REQUEST['deptid']);
	if(!empty($_REQUEST['message'])){
		$message=mysqli_real_escape_string($con,$_REQUEST['message']);
	}else{
		$response["status"] = 4;

		$response["message"] = "Please write Something";

		echo json_encode($response); die; 

	}
	$sessionid=isset($_REQUEST['sessionid']) ? $_REQUEST['sessionid'] : '';
	$login_userid=mysqli_real_escape_string($con,$_REQUEST['login_userid']);
	
  

	$result=staffcommunication($deptid,$message,$login_userid,$sessionid);

		if($result=='success'){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}elseif($result=='error'){
			$response["result"] = $result;

		    $response["status"] = 3;

			$response["message"] = "Something went wrong plesae try again";  

			echo json_encode($response);  

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid Department.";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter deptid, message, login_userid  is missing"; 

	    echo json_encode($response);

	}


	// echo staffcommunication($object->deptid,$object->message,$object->username);

	
?>