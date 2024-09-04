<?php
// include('connection.php');
include('myfunction.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
$select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'register_no',
	1 =>'register_no',
	2 =>'student_name',
	3 =>'father_name',
	4 =>'mother_name',
	5 =>'admission_date',
	6 =>'sr.class_id',
	7 =>'sr.section_id',
	8 =>'sr.roll_no',
	9 =>'student_contact',
	10 =>'parent_no',
	11 =>'admin_rte',
	12 =>'caste',
	13 =>'blood_grp',
	14 =>'mother_tongue',
	15 =>'aadhar_card',
	16 =>'aadhar_card',
	17 =>'aadhar_card',
	18 =>'aadhar_card',
	19 =>'aadhar_card',
	20 =>'aadhar_card',
	21 =>'aadhar_card',
	22 =>'aadhar_card',
	23 =>'present_address',
);

if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){
    $classtype = $_POST['custom']['classtype'];
    $section = $_POST['custom']['section'];
}


 // $Xsql = "SELECT * FROM `student_records` where `status`='1' AND `session`= '".$_SESSION['session']."'  ";
 // $xquery=$con->query($Xsql);
 //    $Xrow=mysqli_num_rows($xquery); //if no any student found in the table

 //    if($Xrow>0){
    	
  $sql = "SELECT `student_id`, `register_no`, `student_name`, `father_name`, `mother_name`, `present_address`, `gender`, `dob`,`student_contact`, `admission_date`,`adm_type_id`,`admin_rte`,`msg_type_id`,`religion_id`,`password`, `soc_cat_id`,`sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`, `due`,  `parent_no`,`caste`,`blood_grp`,`mother_tongue`,  `stuaddress`,  `aadhar_card`, `sr`.`session`, `create_date`, `modify_date`FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where stu_status='0'  AND `sr`.`session`= '".$_SESSION['session']."' ";
  


$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

  $sql = "SELECT `student_id`, `register_no`, `student_name`, `father_name`,`mother_name`, `present_address`, `gender`, `dob`, `admission_date`,`student_contact`,`adm_type_id`,`admin_rte`,`msg_type_id`,`password`,`religion_id`, `soc_cat_id`, `sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`,`caste`,`blood_grp`,`mother_tongue`, `due`,  `parent_no`,  `stuaddress`,  `aadhar_card`, `sr`.`session`, `create_date`, `modify_date`FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where stu_status='0'  AND `sr`.`session`= '".$_SESSION['session']."' ";
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`register_no` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `student_name` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `father_name` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `admission_date` LIKE '%".$requestData['search']['value']."%' ";
		// $sql.=" OR `academic_year` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `student_contact` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `parent_no` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `admin_rte` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `caste` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `blood_grp` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `mother_tongue` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `aadhar_card` LIKE '%".$requestData['search']['value']."%'  )";
}
	

	if(!empty($classtype) && !empty($section) ){

		$sql.=" AND `sr`.`class_id`='$classtype'  AND `sr`.section_id='$section' ";
	}elseif(!empty($classtype) && empty($section) ){
		$sql.=" AND `sr`.`class_id`='$classtype'  ";
	}elseif(empty($classtype) && !empty($section) ){
		 $sql.="  AND `sr`.`section_id`='$section' ";
	}



$query = $con->query($sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;

$query = $con->query($sql);

$data = array();
$count=1;
while($Row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();
	$id=$Row['student_id'];
	$clid=$Row['class_id'];

	$seid=$Row['section_id'];

	$date=$Row['admission_date'];

	$admdate=date("d-M-Y", strtotime($date));

	$admid = $Row['adm_type_id'];

	$msgid=$Row['msg_type_id'];

	$regid = $Row['religion_id'];
	$scid = $Row['soc_cat_id'];
	$nestedData[] = $count;
	$nestedData[] = $Row["register_no"];
	$nestedData[] = $Row["student_name"];
	$nestedData[] = $Row["father_name"];
	$nestedData[] = $Row["mother_name"];
	$nestedData[] = $admdate;
	$nestedData[] = get_class_byid($clid)['class_name'];
	$nestedData[] = get_section_byid($seid)['section_name'];
	$nestedData[] = ($Row["roll_no"]) ? $Row["roll_no"] : "0";
	$nestedData[] = getSessionByid($Row['session'])['year'];
	$nestedData[] = $Row["student_contact"];
	$nestedData[] = $Row["parent_no"];
	$nestedData[] = $Row["password"];
	$nestedData[] = get_admission_type_byid($admid)['adm_type_name'];
	$nestedData[] = $Row["present_address"];
	$nestedData[] = get_message_type_byid($msgid)['msg_name'];
	$nestedData[] = $Row["admin_rte"];
	$nestedData[] =  get_religion_byid($regid)['religion_name'];
	$nestedData[] = ($Row["caste"]) ? $Row["caste"] : "N/A";
	$nestedData[] = get_social_category_byid($scid)['soc_cat_name'];
	$nestedData[] = ($Row["blood_grp"]) ? $Row["blood_grp"] : "N/A";
	$nestedData[] = ($Row["mother_tongue"]) ? $Row["mother_tongue"] : "N/A";
	$nestedData[] = ($Row["aadhar_card"]) ? $Row["aadhar_card"] : "N/A";

	$Action="<a href='dashboard.php?option=view_students_details&sid=".$id."' class='btn btn-success btn-sm' title='View all details of student.'>view Details</a>";
	$nestedData[] = $Action;

	
	// $Action = '<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true"><a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle"><i class="la la-plus m--hide"></i><i class="la la-ellipsis-h"></i></a>
	
	// 								<div class="m-dropdown__wrapper">
	// 									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
	// 									<div class="m-dropdown__inner">
	// 										<div class="m-dropdown__body">
	// 											<div class="m-dropdown__content">
	// 												<ul class="m-nav">
	// 													<li class="m-nav__item margin-top20">
	// 														<a title="View Item" class="view-item m-nav__link" href="view-enquiry.php?view='.$secureUrl->base64url_encode($Row["id"]).'">
	// 															<i class="m-nav__link-icon flaticon-visible"></i>
	// 															<span class="m-nav__link-text">View</span>
	// 														</a>
	// 													</li>';
													
												
	// 												$Action .= '</ul>
	// 											</div>
	// 										</div>
	// 									</div>
	// 								</div>
	// 							</div>';
	

	
	$data[] = $nestedData;
	$count ++;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
