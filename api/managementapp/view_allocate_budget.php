<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';

include('myfunction.php');

if($_REQUEST['session_id']){
	$session_id=$_REQUEST['session_id'];
}else{
	$session_id='';
}

$result=view_allocate_budget($session_id);

if(!empty($result)){

	$response['result']=$result;
	$response['status']=1;
	$response['message']='Success';
	echo json_encode($response);
}else{

	$response['status']=0;
	$response['message']='Not Found';
	echo json_encode($response);

}