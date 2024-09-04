<?php
	
session_start();
error_reporting(1);
// -----------------
// $user="abhigya_sch_db";
//  $pass="Sch_DB@#123$"; 
// //$pass="AIms@#123$";  
// $regdb="abhigya_schools";
$user="root";
 $pass=""; 
$regdb="psoft_school_admin";

$regcon=new mysqli($host,$user,$pass,$regdb)or die(mysqli_error());
	
//print_r($regcon);
if(isset($_POST['school_registation_no'])){
// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// echo "</pre>";
  
$response=array();
$registration=$regcon->real_escape_string($_POST['registration_no']);

$sql="SELECT * from `school_details` where `status`='1' and `registration_no`='$registration' ";
$Query=$regcon->query($sql);
if($Query->num_rows > 0){

	$row=$Query->fetch_assoc();

	
	$_SESSION['registration_no']=$row['registration_no'];
	$_SESSION['db_name']=trim($row['db_name']);
	$_SESSION['username']=trim($row['username']);
	$_SESSION['password']=trim($row['password']);

		$response['type']='SUCCESS';
		$response['msg']="Success";

}else{

		$response['type']='FAILED';
		$response['msg']="*Please Enter Correct Registration no.";


}
echo json_encode($response);

}	

function get_school_by_register_no($registration){
	$response=array();
	global $regcon;
	if(!empty($registration)){
		$sql="SELECT `name`,`logo`,`image` from `school_details` where `status`='1' and `registration_no`='$registration' ";
		$Query=$regcon->query($sql);
		if($Query->num_rows > 0){
			$row=$Query->fetch_assoc();
			// $res['registration_no']=$row['registration_no'];
			$res['name']=$row['name'];
			$res['logo']=$row['logo'];
			$res['image']=$row['image'];

			return $res;
		}else{
			return '';
		}
	}else{
		return '';
	}	
}	