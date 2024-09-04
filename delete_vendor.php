<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from vendor where vendor_id='$eid'");
header('location:dashboard.php?option=view_vendor');

?>