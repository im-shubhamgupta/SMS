<?php 
include('connection.php');
$gid=$_GET['x'];
mysqli_query($con,"delete from grade where grade_id='$gid'");
echo "<script>window.location='dashboard.php?option=view_grade'</script>";
?>