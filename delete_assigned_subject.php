<?php 

include('connection.php');

extract($_REQUEST);

if(isset($id))

{

	$que = mysqli_query($con,"delete from assign_subject where assign_sub_id='$id'");

	if($que){
			echo "<script>alert('Delete Sucessfully')</script>";
	        echo "<script>window.location='dashboard.php?option=view_assign_subject'</script>";
	}else{	
			echo "<script>window.location='dashboard.php?option=view_assign_subject'</script>";

	}



}









?>