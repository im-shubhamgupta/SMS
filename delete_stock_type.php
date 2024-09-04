<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from stock_type where stock_type_id='$eid'");
header('location:dashboard.php?option=view_stock_type');

?>