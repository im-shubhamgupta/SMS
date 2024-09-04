<?php

include('connection.php');

extract($_REQUEST);



$q1 = mysqli_query($con,"select class_id from assign_fee_class where class_id='$clsid' and session='".$_SESSION['session']."'");



if(mysqli_num_rows($q1))

{

	echo 1;

}





?>