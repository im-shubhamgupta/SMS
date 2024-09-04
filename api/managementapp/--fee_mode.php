<?php
include('myfunction.php');


$result=fee_mode();

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