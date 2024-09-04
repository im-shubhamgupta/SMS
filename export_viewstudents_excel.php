<?php

include('connection.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];



	if($class=="" and $section=="")

	{

		$query = "SELECT * FROM `students` where stu_status='0' and session='".$_SESSION['session']."'";

		$search_result = filterTable($query);	

	}

	else if($class!="" and $section!="")

	{

    // search in all table columns



		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and section_id='$section' and stu_status='0' and session='".$_SESSION['session']."'";

		$search_result = filterTable($query);

    }

	else if($class!="" and $section=="")

	{

		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and stu_status='0' and session='".$_SESSION['session']."'";

		$search_result = filterTable($query);

	}	

	



function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Register Number".","."Student Name".","."Father Name".","."Mother Name".","."Gender".","."DOB".","."Admission Date".","."Student Contact".","."Class".","."Section".","."Parent Contact".","."Password".","."Student Address".","."Admission Type".","."Message Type".","."Academic Year".","."Admin RTE".","."Religion".","."Caste".","."Social Category".","."Blood group".","."Mother Tongue".","."Aadhar No".","."Birth Place".","."Village".","."Father Qualification".","."Mother Qualification".","."Father Occupation".","."Mother Occupation".","."Father Annual Income".","."No. of Dependents".","."Guardian Detail".","."Nationality".","."Subcaste".","."Other Language Spoken".","."Present Address".","."Previous School".","."Father Aadhar Card".","."Mother Aadhar Card".","."Student Bank A/c".","."IFSC Code".","."Branch".","."Bus Facility";





$data='';





while($res=mysqli_fetch_array($search_result))

{

	

$clid=$res['class_id'];

$quec=mysqli_query($con,"select * from class where class_id='$clid'");

$resc=mysqli_fetch_array($quec);



$seid=$res['section_id'];

$qse=mysqli_query($con,"select * from section where section_id='$seid'");

$rsec=mysqli_fetch_array($qse);



$date=$res['dob'];

$dob=date("d-M-Y", strtotime($date));



$date=$res['admission_date'];

$admdate=date("d-M-Y", strtotime($date));



$address = $res['stuaddress'];

$add = '"'.$address.'"';



$admid=$res['adm_type_id'];

$qadm=mysqli_query($con,"select * from admission_type where adm_type_id='$admid'");

$radm=mysqli_fetch_array($qadm);

$admname = $radm['adm_type_name'];

						

$msgid=$res['msg_type_id'];

$qmsg=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

$rmsg=mysqli_fetch_array($qmsg);

$msgname = $rmsg['msg_name'];



$regid = $res['religion_id'];

$qreg=mysqli_query($con,"select * from religion where religion_id='$regid'");

$rreg=mysqli_fetch_array($qreg);

$religion=$rreg['religion_name'];



$soccatid = $res['soc_cat_id'];

$qscat=mysqli_query($con,"select * from social_category where soc_cat_id='$soccatid'");

$rscat=mysqli_fetch_array($qscat);

$socialcat=$rscat['soc_cat_name'];



$village = $res['village'];

$nvillage = '"'.$village.'"';				

						

$guardian = $res['guardians'];

$nguardian = '"'.$guardian.'"';	



$presentadd = $res['present_address'];

$npresentadd = '"'.$presentadd.'"';



						

$data .= $res['register_no'].",".$res['student_name'].",".$res['father_name'].",".$res['mother_name'].",".$res['gender'].","

.$dob.",".$admdate.",".$res['student_contact'].",".$resc['class_name'].",".$rsec['section_name'].",".$res['parent_no'].

",".$res['password'].",".$add.",".$admname.",".$msgname.",".$res['academic_year'].",".$res['admin_rte'].

",".$religion.",".$res['caste'].",".$socialcat.",".$res['blood_grp'].",".$res['mother_tongue'].",".$res['aadhar_card'].",".$res['birth_place']

.",".$nvillage.",".$res['fqualification'].",".$res['mqualification'].",".$res['foccupation'].",".$res['moccupation'].",".

$res['fannual_income'].",".$res['dependents'].",".$nguardian.",".$res['nationality'].",".$res['subcaste'].","

.$res['other_language'].",".$npresentadd.",".$res['previous_school'].",".$res['father_aadhar'].",".$res['mother_aadhar'].","

.$res['student_bankacc'].",".$res['ifsc_code'].",".$res['branch'].",".$res['bus_facility']."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Studentdetail_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

