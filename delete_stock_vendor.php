<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from stock_vendor where stock_vendor_id='$eid'");
header('location:dashboard.php?option=view_stock_vendor');

?>