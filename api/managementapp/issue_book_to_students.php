<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
$session_id=isset($_REQUEST['sessionid']) ? $_REQUEST['sessionid'] : '';
$branch_id=isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : '';
$book_id=isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : '';

$result=issue_book_to_students($branch_id,$book_id);

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