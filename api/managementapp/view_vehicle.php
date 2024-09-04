<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if($_REQUEST['session_id']){
	$session_id=$_REQUEST['session_id'];
}else{
	$response['status']=2;
	$response['message']='Session not found';
	echo json_encode($response); die;
}

$result=view_vehicle($session_id);

if(!empty($result)){

	$response['result']=$result;
	$response['status']=1;
	$response['message']='Success';
	echo json_encode($response);
}else{

	$response['status']=0;
	$response['message']='Error';
	echo json_encode($response);

}