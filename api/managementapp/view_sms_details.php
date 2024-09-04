<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');




$result=view_sms_details();

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