<?php 
include('myfunction.php');
if(isset($_REQUEST['teacher_id']) && isset($_REQUEST['status'])  && isset($_REQUEST['regno']) && isset($_REQUEST['stuid']) && isset($_REQUEST['classid'])  && isset($_REQUEST['sectionid']) && isset($_REQUEST['attendanceid']) && isset($_REQUEST['atdate']) && isset($_REQUEST['stuattid']) ){


	$teacher_id=$_REQUEST['teacher_id'];
	$status=$_REQUEST['status'];
	$regno=$_REQUEST['regno'];
	$stuid=$_REQUEST['stuid'];
	$classid=$_REQUEST['classid'];
	$sectionid=$_REQUEST['sectionid'];
	$attendanceid=$_REQUEST['attendanceid'];
	$atdate=$_REQUEST['atdate'];
	$stuattid=$_REQUEST['stuattid'];
   

    $session=profile($teacher_id)['session'];

    if(empty($session) || empty($teacher_id)){
	  $response['status']=4;		
		$response['message']="Session Not Found";		
		echo json_encode($response);
		die;
    }

	// $result= studentattendance($session,$staffid);
	$result=studentattendance($session,$status,$regno,$stuid,$classid,$sectionid,$attendanceid,$atdate,$stuattid);

	 

		if($result=="Inserted"){

			$response["result"] = $result;
		    $response["status"] = 1;
			$response["message"] = "Attendance Taken Successfully";  
			echo json_encode($response);   

		}elseif($result=="Updated"){

			$response["result"] = $result;
		    $response["status"] = 2;
			$response["message"] = "Attendance Updated Successfully";  
			echo json_encode($response); 

		}
		else{

			$response["status"] = 0;

			$response["message"] = "No Message";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 3;

		$response["message"] = "Required Parameter teacherid,status,regno,stuid,classid,sectionid,attendanceid,atdate,stuattid"; 

	    echo json_encode($response);

	}


	
  

?>