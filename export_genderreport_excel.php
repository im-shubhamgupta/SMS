<?php

include('connection.php');

extract($_REQUEST);



	

$columnHeader ='';

$columnHeader = "Class".","."Section".","."Male".","."Female".","."Total";





$data='';



$qsec = mysqli_query($con,"select * from section");

while($rsec=mysqli_fetch_array($qsec))

{							

	$clid = $rsec['class_id'];

	$secid = $rsec['section_id'];

	$qcl = mysqli_query($con,"select * from class where class_id='$clid'");

	$rcl = mysqli_fetch_array($qcl);

	$clsname = $rcl['class_name'];

	$secname = $rsec['section_name'];

	 $sql1="select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' and sr.class_id='$clid' && sr.section_id='$secid' && gender='male' && sr.session='".$_SESSION['session']."' ";

	$qu = mysqli_query($con,$sql1);


	$mrow = mysqli_num_rows($qu);

	 $sql2="select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' and sr.class_id='$clid' && sr.section_id='$secid' && gender='female' && sr.session='".$_SESSION['session']."'  ";
	$qu = mysqli_query($con,$sql2);

	$frow = mysqli_num_rows($qu);

	$trow = $mrow + $frow;

						

$data .= $clsname.",".$secname.",".$mrow.",".$frow.",".$trow."\n";



$totalmale = $totalmale + $mrow;

$totalfemale = $totalfemale + $frow;

$gtotal = $gtotal + $trow;



}





$data .= "\t".",".Total.",".$totalmale.",".$totalfemale.",".$gtotal."\n";



	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Genderreport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

