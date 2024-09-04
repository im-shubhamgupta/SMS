<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['assign_id']) && isset($_REQUEST['session_id']) ){
	$assign_id=$_REQUEST['assign_id'];
	$session_id=$_REQUEST['session_id'];

$result=view_driver_by_id($assign_id,$session_id);

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
}else{
    $response['status']=2;
        $response['message']="assign_id, session_id required fields can't empty" ;
        echo json_encode($response);



}    