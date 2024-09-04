<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$query_fee=mysqli_query($con,"select * from fees where class_id='$id'");
$query_stu=mysqli_query($con,"select * from students where class_id='$id'");
if(mysqli_num_rows($query_fee) or mysqli_num_rows($query_stu))
{
	echo "true";
}
}


if(isset($del_id))
{
if(mysqli_query($con,"delete from section where class_id='$del_id'"))
{
	if(mysqli_query($con,"delete from class where class_id='$del_id'"))
	{
				
		echo "deleted Successfully";
	}
}	 
}

?>