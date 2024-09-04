<?php 

include('connection.php');

extract($_REQUEST);



$query = "delete from assign_clsteacher where assign_clst_id ='$id'";

if(mysqli_query($con,$query))

{

	echo "<script>alert('Deleted Successfully')</script>";

	echo "<script>window.location='dashboard.php?option=view_assign_classteacher'</script>";	

}



?>