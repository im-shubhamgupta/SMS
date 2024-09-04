<?php 

include('connection.php');

extract($_REQUEST);



if(isset($x))

{

	$q = mysqli_query($con,"select * from idcard where id='$x'");

	$r = mysqli_fetch_array($q);

	$clsid = $r['class_id'];

	$qcls = mysqli_query($con,"select * from class where class_id='$clsid'");

	$rcls = mysqli_fetch_array($qcls);

	$clsname = $rcls['class_name'];



	$secid = $r['section_id'];

	$qsec = mysqli_query($con,"select * from section where section_id='$secid'");

	$rsec = mysqli_fetch_array($qsec);

	$secname = $rsec['section_name'];

	

	$image = $r['pic'];



	unlink("gallery/idcard/$clsname/$secname/$image");

	if(mysqli_query($con,"delete from idcard where id='$x' and session='".$_SESSION['session']."'"))

	{

		echo "<script>window.location='dashboard.php?option=view_upload_student_image'</script>";	

	}	



	

	

}



?>