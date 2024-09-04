<?php 
include('connection.php');
extract($_REQUEST);

if(isset($id))
{
$query=mysqli_query($con,"select * from assign_driver_route where vehicle_id='$id'");

if(mysqli_num_rows($query))
{
	echo "true";
}
}


if(isset($del_id))
{
	
	if(mysqli_query($con,"delete from vehicle where vehicle_id ='$del_id'"))
	{
		echo "deleted Successfully";
	}
	
}

?>