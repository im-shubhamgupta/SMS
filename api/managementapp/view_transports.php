<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';

include('myfunction.php');

if($_REQUEST['session_id']){
	$session_id=$_REQUEST['session_id'];
}else{
	$session_id='';
}
$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

$result=view_transports($session_id, $current_page, $per_page);

if(!empty($result['total_records'])){

	$response['result']=$result;
	$response['status']=1;
	$response['message']='Success';
	echo json_encode($response);
}else{

	$response['status']=0;
	$response['message']='Error';
	echo json_encode($response);

}