<?php

include('connection.php');

extract($_REQUEST);


$sql="select * from assign_subject where subject_id='$subid'";
$q1 = mysqli_query($con,$sql);

if(mysqli_num_rows($q1)>0)

{

echo json_encode('1');

}else{
	echo json_encode('0');
}

?>