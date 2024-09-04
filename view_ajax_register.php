<?php 

include('connection.php');

extract($_REQUEST);

$uname = mysqli_real_escape_string($con,trim($_POST['rno']));
$response=array();

$res=mysqli_query($con,"select * from students where register_no='$uname'");

// $row = mysqli_num_rows($res);

if(mysqli_num_rows($res) > 0){
	$response['type']='Already';
	$response['message']="This Register Number is Already Exists.";
	echo json_encode($response);
	// return $response;
	// echo ("<font color='red'>This Register Number is Already Exists.</font>");
}else{
	$response['type']='success';
	$response['message']="";
	echo json_encode($response);
}



?>

