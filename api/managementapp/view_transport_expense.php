<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

$session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '' ;
$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
$result=view_transport_expense($session_id, $current_page, $per_page);

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