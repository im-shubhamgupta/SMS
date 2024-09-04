<?php

// include('connection.php');
include('myfunction.php');

extract($_REQUEST);



$q1 = mysqli_query($con,"select `sturoute_id`,`status` from student_route where student_id='$stu_id' and session='".$_SESSION['session']."'  ");

$r1 = mysqli_fetch_array($q1);

$status = $r1['status']; 



$q2 = mysqli_query($con,"select `student_name`,`bus_facility` from students where student_id='$stu_id'");

$r2 = mysqli_fetch_array($q2);

$stuname = $r2['student_name'];
$bus_facility = $r2['bus_facility'];


$response['status']=$status;
$response['stuname']=$stuname;
$response['bus_facility']=$bus_facility;

// if($status==1){

	echo json_encode($response);

// }

?>