<?php 
extract($_REQUEST);
include('connection.php');

$q=mysqli_query($con,"select * from students where student_id='$stu_id'");
$r=mysqli_fetch_array($q);
echo $fathername=$r['father_name'];

?>

		