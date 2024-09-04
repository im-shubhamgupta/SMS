<?php 
include('myfunction.php');
if(isset($_REQUEST['teacher_id']) && isset($_REQUEST['staffid']) ){


	// $teacher_id=$_REQUEST['teacher_id'];
    $staffid=$_REQUEST['staffid'];
    // $session=profile($teacher_id)['session'];

 
	$result= voicemessage($staffid);
	 

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "No Voice Message";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter teacherid, staffid"; 

	    echo json_encode($response);

	}





	



	



?>