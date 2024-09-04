<?php 
include('connection.php');
extract($_REQUEST);

$query_fee=mysqli_query($con,"delete from test where class_id='$cls' && section_id='$sect' && test_name='$tes'");

echo "<script>window.location='dashboard.php?option=delete_test'</script>";

?>