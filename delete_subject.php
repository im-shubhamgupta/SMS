<?php 
include('connection.php');
$sid=$_GET['x'];
mysqli_query($con,"delete from subject where subject_id='$sid'");
echo "<script>window.location='dashboard.php?option=view_subject'</script>";
?>