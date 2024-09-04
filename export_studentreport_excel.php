<?php

include('myfunction.php');

extract($_REQUEST);



$cond = '';

	

	if($_REQUEST['class']!='') 

	{

		$cond.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_REQUEST['section']!='') 

	{

		$cond.=" && sr.section_id='$_REQUEST[section]'";

	}

	

// $query =mysqli_query($con,"SELECT * FROM students WHERE stu_status='0'  and session='".$_SESSION['session']."' $cond");
 $sql="select `student_id`, `register_no`, `student_name`, `father_name`, `mother_name`, `gender`, `dob`, `admission_date`, `student_contact`,  `due`, `month`, `parent_no`, `password`, `stuaddress`, `adm_type_id`, `msg_type_id`,  `admin_rte`, `religion_id`, `caste`, `soc_cat_id`, `blood_grp`, `mother_tongue`, `aadhar_card`, `stu_image`, `birth_place`, `village`, `fqualification`, `mqualification`, `foccupation`, `moccupation`, `fannual_income`, `dependents`, `guardians`, `nationality`, `subcaste`, `other_language`, `present_address`, `previous_school`, `father_aadhar`, `mother_aadhar`, `student_bankacc`, `ifsc_code`, `branch`, `bus_facility`, `stu_status`, `create_date`, `modify_date`, sr.class_id,sr.section_id,sr.session,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' $cond  order by roll_no asc ";	
$query=mysqli_query($con,$sql);
	

$columnHeader ='';

$columnHeader = "Register Number".","."Student Name".","."Father Name".","."Mother Name".","."Gender".","."DOB".","."Admission Date".","."Student Contact".","."Class".","."Section".","."Roll No.".","."Parent Contact".","."Student Address".","."Admission Type".","."Message Type".","."Academic Year".","."Admin RTE".","."Religion".","."Caste".","."Social Category".","."Blood group".","."Mother Tongue".","."Aadhar No".","."Birth Place".","."Village".","."Father Qualification".","."Mother Qualification".","."Father Occupation".","."Mother Occupation".","."Father Annual Income".","."No. of Dependents".","."Guardian Detail".","."Nationality".","."Subcaste".","."Other Language Spoken".","."Present Address".","."Previous School".","."Father Aadhar Card".","."Mother Aadhar Card".","."Student Bank A/c".","."IFSC Code".","."Branch".","."Bus Facility";



$data='';

if(mysqli_num_rows($query)>0){

while($res=mysqli_fetch_array($query)){

	// echo "<pre>";
	// print_r($res);
	// echo "</pre>" ; die;

	

$id=$res['student_id'];

$clid=$res['class_id'];

$quec=mysqli_query($con,"select * from class where class_id='$clid'");

$resc=mysqli_fetch_array($quec);



$seid=$res['section_id'];

$qse=mysqli_query($con,"select * from section where section_id='$seid'");

$rsec=mysqli_fetch_array($qse);


$date=$res['dob'];

$dob=date("d-M-Y", strtotime($date));



$adate=$res['admission_date'];

$admdate=date("d-M-Y", strtotime($adate));



$address = $res['stuaddress'];

$add = '"'.$address.'"';



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

						

$village = $res['village'];

$nvillage = '"'.$village.'"';				

						

$guardian = $res['guardians'];

$nguardian = '"'.$guardian.'"';	



$presentadd = $res['present_address'];

$npresentadd = '"'.$presentadd.'"';

		
$session_year=getSessionByid($res['session'])['year'];
$roll_no=($res['roll_no']) ? $res['roll_no'] : '0' ;						

$data .= $res['register_no'].",".$res['student_name'].",".$res['father_name'].",".$res['mother_name'].",".$res['gender'].","

.$dob.",".$admdate.",".$res['student_contact'].",".$resc['class_name'].",".$rsec['section_name'].",".$roll_no.","

.$res['parent_no'].",".$add.",".$admname.",".$msgname.",".$session_year.",".$res['admin_rte'].",".$regname.","

.$res['caste'].",".$scat_name.",".$res['blood_grp'].",".$res['mother_tongue'].",".$res['aadhar_card'].",".$res['birth_place']

.",".$nvillage.",".$res['fqualification'].",".$res['mqualification'].",".$res['foccupation'].",".$res['moccupation'].",".

$res['fannual_income'].",".$res['dependents'].",".$nguardian.",".$res['nationality'].",".$res['subcaste'].","

.$res['other_language'].",".$npresentadd.",".$res['previous_school'].",".$res['father_aadhar'].",".$res['mother_aadhar'].","

.$res['student_bankacc'].",".$res['ifsc_code'].",".$res['branch'].",".$res['bus_facility']."\n";

}
}
	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Studentreport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

// echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

