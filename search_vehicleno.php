<?php 
session_start();
extract($_REQUEST);
include('connection.php');
if(isset($vehno))
{
	$que = mysqli_query($con,"select * from vehicle where vehicle_id='$vehno'");
	$res = mysqli_fetch_array($que);
	echo $res['vehicle_number'];
}

?>

