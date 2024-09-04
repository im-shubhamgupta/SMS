<?php 
include('connection.php');
$rid=$_GET['x'];
mysqli_query($con,"delete from transport where route_id='$rid'");
mysqli_query($con,"delete from route where route_id='$rid'");

echo "<script>window.location='dashboard.php?option=view_route'</script>";
?>