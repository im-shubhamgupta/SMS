<?php 
include('connection.php');
extract($_REQUEST);
$que=mysqli_query($con,"select * from transports where trans_id='$rou_id'");
$res=mysqli_fetch_array($que);
$price=$res['price'];
echo ($price);
?>


