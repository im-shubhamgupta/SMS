<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$query_fee=mysqli_query($con,"select * from fees where fees_id='$id'");
$rfee=mysqli_fetch_array($query_fee);
$rf=$rfee['class_id'];

$query_stu=mysqli_query($con,"select * from students where class_id='$rf'");
$rstu=mysqli_fetch_array($query_stu);
$rs=$rstu['student_id'];

$query_bill=mysqli_query($con,"select * from bill where student_id='$rs'");

if(mysqli_num_rows($query_stu) or mysqli_num_rows($query_bill))
{
	echo "true";
}
}


if(isset($del_id))
{
	if(mysqli_query($con,"delete from fees where fees_id='$del_id'"))
	{
		
		echo "deleted Successfully";

	}	 
}

?>