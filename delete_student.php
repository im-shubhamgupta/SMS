<?php 
include('connection.php');
$stuid=$_GET['x'];
mysqli_query($con,"update students set stu_status='1' where student_id='$stuid'");
echo "<script>window.location='dashboard.php?option=view_students'</script>";
?>