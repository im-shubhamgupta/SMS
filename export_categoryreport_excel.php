<?php

include('connection.php');

extract($_REQUEST);



	

$columnHeader ='';

$columnHeader = "Category".",";



$qcl = mysqli_query($con,"select * from class");

while($rcl = mysqli_fetch_array($qcl))

{

$clarr[] = $rcl['class_id'];

$clsname=$rcl['class_name'];

$columnHeader.="$clsname".",";

}



$columnHeader.="Total".",";



$data='';



$qsc = mysqli_query($con,"select * from social_category");

while($rsc=mysqli_fetch_array($qsc))

{

$catid = $rsc['soc_cat_id'];

$catname = $rsc['soc_cat_name'];

						

$data .= $catname.",";

$ctotal = 0;

foreach ($clarr as $k)

{

// $qu = mysqli_query($con,"select * from students where class_id='$k' && soc_cat_id='$catid' and session='".$_SESSION['session']."' ");
$qu=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' && sr.class_id='$k' && sr.session='".$_SESSION['session']."' && soc_cat_id='$catid' ");

$crow = mysqli_num_rows($qu);



$data.= $crow.","; 



$ctotal = $ctotal + $crow;

}		

$data.= $ctotal."\n"; 

}



$data .= Total.",";



foreach ($clarr as $k)

{

	// $q2 = mysqli_query($con,"select * from students where class_id='$k' and session='".$_SESSION['session']."' ");
	$q2=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' && sr.class_id='$k' && sr.session='".$_SESSION['session']."' ");


	$row2 = mysqli_num_rows($q2);

	$cgtotal = $cgtotal + $row2;

$data .= $row2.",";

}

$data .= $cgtotal."\n";



	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Categoryreport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

