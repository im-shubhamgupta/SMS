<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
	$query_fee=mysqli_query($con,"select * from assign_fee_class where assign_fee_id='$id'");
	$rfee=mysqli_fetch_array($query_fee);
	$clsid=$rfee['class_id'];

	$q = mysqli_query($con,"select * from students where class_id='$clsid'");
	$r = mysqli_num_rows($q);
		if($r)	
		{
			echo "true";
			
		}

}


if(isset($del_id))
{
	if(mysqli_query($con,"delete from assign_fee_class where assign_fee_id='$del_id'"))
	{
		
		echo "deleted Successfully";

	}	 
}

?>