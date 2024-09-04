<?php 
session_start();
extract($_REQUEST);
include('connection.php');
$cls_id=$_REQUEST['cid'];
$sec_id=$_REQUEST['secid'];

$c=mysqli_query($con,"select * from students where stu_status='0' and class_id='$cls_id' and section_id='$sec_id'");
$res=mysqli_num_rows($c);

echo $res;
?>

