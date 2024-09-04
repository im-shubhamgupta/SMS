<?php 
include('connection.php');
$id=$_GET['x'];

mysqli_query($con,"delete from purge_data where purge_id='$id'");
header('location:dashboard.php?option=view_purge_data');

?>