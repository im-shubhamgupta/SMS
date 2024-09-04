<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$query_fee=mysqli_query($con,"select * from fees where fees_id='$id'");
$r2=mysqli_fetch_array($query_fee);
$c2=$r2['class_id'];

$query_stu=mysqli_query($con,"select * from students where class_id='$c2'");
$r3=mysqli_fetch_array($query_stu);
$c3=$r3['student_id'];

$query_bill=mysqli_query($con,"select * from bill where student_id='$c3'");	

if(mysqli_num_rows($query_stu) or mysqli_num_rows($query_bill))
{
	echo "true";
}
}


if(isset($del_id))
{
	if(mysqli_query($con,"delete from fees where fees_id='$id'"))
	{
			echo "deleted Successfully";
	}	 
}

?>

