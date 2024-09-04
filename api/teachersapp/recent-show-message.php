<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['teacher_id']) && isset($_REQUEST['session_id'])   ){

	$teacher_id=$_REQUEST['teacher_id'];
    
    if(isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])){
    	$session_id=$_REQUEST['session_id'];
    }else{
    	$response["status"] = 3;
		$response["message"] = "session_id not found "; 
	    echo json_encode($response); die;

    }

	$result= recentshowmessage($teacher_id,$session_id);

		if(!empty($result)){
			$response["status"] = 1;
			$response["message"] ="success";
			$response["result"] = $result;  
			echo json_encode($response);   
		}else{

			$response["status"] = 0;
			$response["message"] = "No Message";
			$response["result"] =[];
			echo json_encode($response);   

		}
	}else{
		$response["status"] = 2;
		$response["message"] = "Required Parameter teacher_id, session_id "; 
		$response["result"] =[];
	    echo json_encode($response);

	}


?>