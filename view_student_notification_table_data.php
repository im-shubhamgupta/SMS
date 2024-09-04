<?php
// include('connection.php');
include('myfunction.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
$select_table = 'student_notifications';
$columns = array( 
// datatable column index  => database column name
	0 =>'sn.student_id',
	1 =>'sn.notice_datetime',
	2 =>'sn.category',
	3 =>'class.class_id',
	4 =>'section.section_id',
	5 =>'sn.message',
	6 =>'sn.loginuser',
	// 7 =>'parent_no',
	// 8 =>'admin_rte',
	// 9 =>'caste',
	// 10 =>'blood_grp',
	// 11 =>'mother_tongue',
	// 12 =>'aadhar_card',
	// 13 =>'aadhar_card',
	// 14 =>'aadhar_card',
	// 15 =>'aadhar_card',
	// 16 =>'aadhar_card',
	// 17 =>'aadhar_card',
	// 18 =>'aadhar_card',
	// 19 =>'aadhar_card',
	// 20 =>'aadhar_card'
);



$sql="SELECT `sn`.`notice_datetime`,`sn`.`category`,`sn`.`message`, `sn`.`loginuser`, `class`.`class_name`,`section`.`section_name` "; 
$sql.=" FROM student_notifications as `sn` join `class` ON `sn`.`class_id`=`class`.`class_id` JOIN `section` ON `sn`.`section_id`=`section`.`section_id` "; 
$sql.=" where 1 and `sn`.`group_id` =0 ";
 // $sql.=" group by `sn`.`category`,`sn`.`class_id`,`sn`.`section_id`,`sn`.`message`,`sn`.`date`  " ;	
 // group by `sn`.`category`,`sn`.`class_id`,`sn`.`section_id`,`sn`.`message`,`sn`.`date`  " ;
// $sql.=" FROM `price_list` AS `pl` JOIN `price_list_category` AS `plc` ON `pl`.`category` = `plc`.`id` WHERE `pl`.`status`='0' AND `deletion_indicator`='0' ";
// order by notice_datetime DESC
// echo $sql;die;
// $query = $con->query($sql);
$query = mysqli_query($con,$sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

 // $sql = "SELECT * FROM student_notifications group by category,class_id,section_id,message,date having group_id =0 ";
$sql="SELECT `sn`.`notice_datetime`,`sn`.`category` ,`sn`.`message`, `sn`.`loginuser`,`class`.`class_name`,`section`.`section_name` "; 
$sql.=" FROM student_notifications as `sn` join `class` ON `sn`.`class_id`=`class`.`class_id` JOIN `section` ON `sn`.`section_id`=`section`.`section_id` "; 
$sql.=" where 1 and `sn`.`group_id` =0 ";
	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`sn`.`student_id` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `sn`.`notice_datetime` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `sn`.`category` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `class`.`class_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `section`.`section_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `sn`.`message` LIKE '%".$requestData['search']['value']."%' ";
	
	$sql.=" OR `sn`.`loginuser` LIKE '%".$requestData['search']['value']."%' "; 
	$sql.= " )";
	
}
 $sql.=" group by `sn`.`category`,`sn`.`class_id`,`sn`.`section_id`,`sn`.`message`,`sn`.`date`  " ;
 $sql.=" and `sn`.`session`='".$_SESSION['session']."'  " ;
// if(!empty($classtype) && !empty($section) ){

// 	$sql.=" AND `class_id`='$classtype'  AND section_id='$section' ";
// }elseif(!empty($classtype) && empty($section) ){
// 	$sql.=" AND `class_id`='$classtype'  ";
// }elseif(empty($classtype) && !empty($section) ){
// 	 $sql.="  AND section_id='$section' ";
// }


// echo "<br>".$sql; 
$query = mysqli_query($con,$sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql; 

// $query = $con->query($sql);
$query = mysqli_query($con,$sql);

$data = array();
$count=1;
while($Row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();
	
	$date=date('d-m-Y H:i:s ',strtotime($Row["notice_datetime"]));
	
	$nestedData[] = $count;
	$nestedData[] = $Row["notice_datetime"];
	$nestedData[] = (getCategoryName_byid($Row["category"])) ?? "NA";
	// $nestedData[] = (get_class_byid($Row["class_id"])["class_name"]) ??  "NA";
	$nestedData[] = $Row["class_name"] ;

	$nestedData[] = $Row['section_name'];
	// $nestedData[] = (get_section_byid($Row['section_id'])['section_name']) ?? "NA";
	// $nestedData[] = chunk_split($Row["message"], 70 , "<br>" );
	$nestedData[] = $Row["message"];
	$nestedData[] = $Row["loginuser"];
	// $nestedData[] = $Row["password"];

	

	// $Action="<a href='dashboard.php?option=view_students_details&sid=".$id."' class='btn btn-success btn-sm' title='View all details of student.'>view Details</a>";
	// $nestedData[] = $Action;

	
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
