<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$query_trans=mysqli_query($con,"select * from students where trans_id='$id'");

if(mysqli_num_rows($query_trans))
{
	echo "true";
}
}


if(isset($del_id))
{
	
	if(mysqli_query($con,"delete from transports where trans_id='$del_id'"))
	{
		echo "deleted Successfully";
	}
	
}

?>