<?php

include('connection.php');

extract($_REQUEST);



$q1 = mysqli_query($con,"select * from class where class_id='$classid'");

$rcid = mysqli_fetch_array($q1);

$clsname = $rcid['class_name'];



$q2 = mysqli_query($con,"select * from section where section_id='$sec_id'");

$rsec = mysqli_fetch_array($q2);

$secname = $rsec['section_name'];



$q1 = mysqli_query($con,"select * from assign_clsteacher where class_id='$classid' && section_id='$sec_id' and session='".$_SESSION['session']."'");

if(mysqli_num_rows($q1))

{

	echo $clsname." Section ".$secname.".";

}

?>