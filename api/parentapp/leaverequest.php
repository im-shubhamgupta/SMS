<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['dateofsubmission'])  && isset($_REQUEST['studentid'])  && isset($_REQUEST['fromdate']) && isset($_REQUEST['todate']) && isset($_REQUEST['leavetypeid']) && isset($_REQUEST['noofdays'])  && isset($_REQUEST['reason']) && isset($_REQUEST['note'])  && isset($_REQUEST['sessionid']) ){

$dateofsubmission= $_REQUEST['dateofsubmission']; 
$classid= $_REQUEST['classid']; 
$sectionid= $_REQUEST['sectionid']; 
$studentid= $_REQUEST['studentid']; 
$fromdate= $_REQUEST['fromdate']; 
$todate= $_REQUEST['todate']; 
$leavetypeid= $_REQUEST['leavetypeid']; 
$noofdays= $_REQUEST['noofdays']; 
$reason= $_REQUEST['reason']; 
$note= $_REQUEST['note']; 

if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=leaverequest($dateofsubmission,$studentid,$fromdate, $todate,$leavetypeid,$noofdays,$reason,$note,$sessionid);

	if($result=='Inserted'){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}elseif($result=='Error'){
			$response["status"] = 0;
			$response["message"] = "Something Went Wrong Please Try Again ";
			$response["result"] = [];
			echo json_encode($response);
	}else{
			$response["status"] = 4;
			$response["message"] = "Already Exists";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter dateofsubmission, classid, sectionid, studentid, fromdate, todate, leavetypeid, noofdays, reason, note, sessionid ";
	$response["result"] = [];
	echo json_encode($response); 

}



?>