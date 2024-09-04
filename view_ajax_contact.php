<?php 
include('connection.php');
extract($_REQUEST);
$contact = $_POST['cno'];
$res=mysqli_query($con,"select * from students where student_contact='$contact'");
$row = mysqli_num_rows($res);
if($row){
	echo ("<font color='red'>This Contact Number is Already Exists.</font>");
}

?>
