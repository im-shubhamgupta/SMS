<?php
include('connection.php');
extract($_REQUEST);

$q1 = mysqli_query($con,"select * from student_due_fees where student_id='$stu_id'");
$r1 = mysqli_fetch_array($q1);
$row = mysqli_num_rows($q1);
$status = $r1['status'];

$q2 = mysqli_query($con,"select * from students where student_id='$stu_id'");
$r2 = mysqli_fetch_array($q2);
$stuname = $r2['student_name'];

if($row)
{
	echo $stuname;
}
?>