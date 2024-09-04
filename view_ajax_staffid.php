<?php 

include('connection.php');

extract($_REQUEST);

$stafid = $_POST['sid'];

$res=mysqli_query($con,"select * from staff where staff_id='$stafid'");

if(mysqli_num_rows($res) > 0){
	$response['type']='Already';
	$response['message']="<font color='red'>This Staff Id is Already Exists.</font>";
	echo json_encode($response);
}else{
	$response['type']='success';
	$response['message']="";
	echo json_encode($response);
}

// $row = mysqli_num_rows($res);

// if($row){

// 	echo ("<font color='red'>This Staff Id is Already Exists.</font>");

// }



?>

