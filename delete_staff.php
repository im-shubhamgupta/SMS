<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$query_classteacher=mysqli_query($con,"select * from assign_clsteacher where st_id='$id'");
$query_subject=mysqli_query($con,"select * from assign_subject where st_id='$id'");
if(mysqli_num_rows($query_classteacher) or mysqli_num_rows($query_subject))
{
	echo "true";
}
}


if(isset($del_id))
{
	$q = mysqli_query($con,"select * from staff where st_id='$del_id'");
	$r = mysqli_fetch_array($q);
	$staffid = $r['staff_id'];
	$img = $r['image'];
	$res = $r['resume'];
	
	unlink("staff/$staffid/$img");
	unlink("staff/$staffid/$res");
	rmdir("staff/$staffid");
	if(mysqli_query($con,"delete from staff where st_id='$del_id'"))
	{
		echo "deleted Successfully";
	}	 
}

?>