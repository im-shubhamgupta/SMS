<?php 
include('connection.php');
$eid=$_GET['x'];

mysqli_query($con,"delete from branch where branch_id='$eid'");
header('location:dashboard.php?option=view_branch');

?>