<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from publisher where publisher_id='$eid'");
header('location:dashboard.php?option=view_publisher');

?>