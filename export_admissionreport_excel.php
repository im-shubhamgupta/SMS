<?php

include('connection.php');

extract($_REQUEST);



	if($type=="Category")

	{

		$ntype="soc_cat_id";

	}

	else if($type=="Religion")

	{

		$ntype="religion_id";

	}

	else if($type=="Gender")

	{

		$ntype="gender";

	}

	

$cond = '';

	

	if($_REQUEST['class']!='') 

	{

		$cond.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_REQUEST['section']!='') 

	{

		$cond.=" && sr.section_id='$_REQUEST[section]'";

	}

	if($_REQUEST['type']!='') 

	{

		$cond.=" && $ntype='$_REQUEST[stype]'";

	}

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";
	
	
// $sql="SELECT * FROM students WHERE stu_status='0' and session='".$_SESSION['session']."'  $cond";
$sql="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' $cond  order by sr.roll_no asc";

$query =mysqli_query($con,$sql);

	

$columnHeader ='';

$columnHeader = "Register Number".","."Student Name".","."Father Name".","."Class".","."Section".","."Roll no".","."Gender".","."Parent Contact".","."Admin RTE".","."Religion".","."Caste".","."Social Category".","."Mother Tongue";



$data='';

if(mysqli_num_rows($query)>0){

while($res=mysqli_fetch_array($query)){


$id=$res['student_id'];

$clid=$res['class_id'];

$quec=mysqli_query($con,"select * from class where class_id='$clid'");

$resc=mysqli_fetch_array($quec);



$seid=$res['section_id'];

$qse=mysqli_query($con,"select * from section where section_id='$seid'");

$rsec=mysqli_fetch_array($qse);





$admid = $res['adm_type_id'];

$qadm = mysqli_query($con,"select * from admission_type where adm_type_id='$admid'");

$radm=mysqli_fetch_array($qadm);

$admname = $radm['adm_type_name'];



$msgid=$res['msg_type_id'];

$qmsg=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

$rmsg=mysqli_fetch_array($qmsg);

$msgname = $rmsg['msg_name'];



$regid = $res['religion_id'];

$qrl=mysqli_query($con,"select * from religion where religion_id ='$regid'");

$rrl=mysqli_fetch_array($qrl);

$regname = $rrl['religion_name'];



$scid = $res['soc_cat_id'];

$qsc=mysqli_query($con,"select * from social_category where soc_cat_id='$scid'");

$rsc=mysqli_fetch_array($qsc);

$scat_name = $rsc['soc_cat_name'];
$roll_no=($res['roll_no']) ? $res['roll_no'] : '0' ;
						

$data .= $res['register_no'].",".$res['student_name'].",".$res['father_name'].",".$resc['class_name'].

",".$rsec['section_name'].",".$roll_no.",".$res['gender'].",".$res['parent_no'].",".$res['admin_rte'].",".$regname.

",".$res['caste'].",".$scat_name.",".$res['mother_tongue']."\n";

}
}
// echo "<pre>";
// print_r($data);
// echo "</pre>";
	
	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Admissionreport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

