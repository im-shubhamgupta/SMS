<?php 
include('connection.php');
extract($_REQUEST);

if(isset($id))
{
$query=mysqli_query($con,"select * from assign_driver_route where driver_id='$id'");

if(mysqli_num_rows($query))
{
	echo "true";
}
}


if(isset($del_id))
{
	
	if(mysqli_query($con,"delete from driver where id='$del_id'"))
	{
		echo "deleted Successfully";
	}
	
}

?>