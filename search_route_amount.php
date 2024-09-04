<?php 
extract($_REQUEST);
include('connection.php');

//echo $r_id;die();
$c=mysqli_query($con,"select * from transports where trans_id='$r_id'");
$s_res=mysqli_fetch_array($c);
echo $s_res['price'];
?>
