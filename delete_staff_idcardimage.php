<?php 
include('connection.php');
extract($_REQUEST);

if(isset($x))
{
	$q = mysqli_query($con,"select * from staff_idcard where id='$x'");
	$r = mysqli_fetch_array($q);
	
	$image = $r['pic'];

	unlink("gallery/staffidcard/$image");
	if(mysqli_query($con,"delete from staff_idcard where id='$x'"))
	{
		echo "<script>window.location='dashboard.php?option=view_upload_faculty_image'</script>";	
	}	

}

?>