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
	0 =>'`sdt`.`register_no`',
	1 =>'`sdt`.`register_no`',
	2 =>'`st`.`student_name`',
	3 =>'`sdt`.`date`',
	4 =>'`att`.`att_type_name`',
	5 =>'`sdt`.`reason`',
	6 =>'`sr`.`roll_no`',
	
);

// echo "<pre>";
// print_r($_POST['custom']);
// echo "</pre>"; die;
if(isset($_POST['custom'])){
$classid=$_POST['custom']['classid'];
$sectionid=$_POST['custom']['sectionid'];
$fromdt=$_POST['custom']['fromdt'];
$todt=$_POST['custom']['todt'];
}
// if(!empty($_POST['custom']['to_date'])){
//     $to_date =  date('Y-m-d', strtotime($_POST['custom']['to_date']));
// }else{
//     // $to_date = date('Y-m-d', strtotime("+1 days"));
// }

$sql=" select `sdt`.`student_id`,`sdt`.`register_no`,`sdt`.`reason`,`sdt`.`date`,`sdt`.`class_id`,`sdt`.`section_id`,`st`.`student_name` ,`att`.`att_type_name`,sr.roll_no ";
$sql.= " from `student_daily_attendance` as `sdt` JOIN  `students` as `st` ON `sdt`.`student_id`= `st`.`student_id` JOIN `attendance_type` as `att` ON `sdt`.`type_of_attend`=`att`.`att_type_id`  ";
$sql.=" join student_records as sr  ON `sdt`.`student_id`= `sr`.`stu_id` ";
 // JOIN `student_records` as `sr` ON `st`.`student_id`=`sr`.`stu_id` 


$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

$sql=" select `sdt`.`student_id`,`sdt`.`register_no`,`sdt`.`reason`,`sdt`.`date`,`sdt`.`class_id`,`sdt`.`section_id`,`st`.`student_name` ,`att`.`att_type_name`,sr.roll_no ";
$sql.= " from `student_daily_attendance` as `sdt` JOIN  `students` as `st` ON `sdt`.`student_id`= `st`.`student_id` JOIN `attendance_type` as `att` ON `sdt`.`type_of_attend`=`att`.`att_type_id`   ";
$sql.=" join student_records as sr  ON `sdt`.`student_id`= `sr`.`stu_id` where 1";
	// JOIN `student_records` as `sr` ON `st`.`student_id`=`sr`.`stu_id`
// ORDER BY `admission_date` DESC
	$sql.=" AND (`sdt`.`register_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `st`.`student_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `sdt`.`date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `att`.`att_type_name` LIKE '%".$requestData['search']['value']."%' ";
	// $sql.=" OR `sdt`.`reason` LIKE '%".$requestData['search']['value']."%' ";
	$sql.= " )";
	
}
$sql.=" AND `sdt`.`session`= '".$_SESSION['session']."' AND `sr`.`session`= '".$_SESSION['session']."'  ";
if(!empty($_POST['custom']['classid']) && !empty($_POST['custom']['sectionid']) ){

 $sql.=" AND `sdt`.`class_id` ='".$classid."' AND `sdt`.`section_id`='".$sectionid."'  ";
 $sql.=" AND `sr`.`class_id` ='".$classid."' AND `sr`.`section_id`='".$sectionid."'  ";

}else{
	  $sql.=" AND `sdt`.`class_id` ='".$classid."' ";	
	  $sql.=" AND `sr`.`class_id` ='".$classid."' ";	
}
// elseif(!empty($_POST['custom']['classid']) && empty($_POST['custom']['sectionid'])){
//  $sql.=" AND `sdt`.`class_id` ='".$classid."' ";	
// }

if(!empty($_POST['custom']['fromdt']) &&  !empty($_POST['custom']['todt'])){
	$sql.=" AND date between '".$fromdt."' and '".$todt."' ";
}

if(!empty($_POST['custom']['fromdt']) && empty($_POST['custom']['todt'])){
	$sql.=" AND date='$fromdt' ";

}


// if(!empty($classtype) && !empty($section) ){

// 	$sql.=" AND `class_id`='$classtype'  AND section_id='$section' ";
// }elseif(!empty($classtype) && empty($section) ){
// 	$sql.=" AND `class_id`='$classtype'  ";
// }elseif(empty($classtype) && !empty($section) ){
// 	 $sql.="  AND section_id='$section' ";
// }

// echo "<br>".$sql;
$query = $con->query($sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."    ".$requestData['order'][0]['dir']."  ";
$sql.=" , ". $columns[$requestData['order'][1]['column']]."   ".$requestData['order'][1]['dir']." ";
$sql.= " LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;

	$query = $con->query($sql);



$data = array();
$count=1;
while($Row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();
	
	$nestedData[] = $count;
	$nestedData[] = $Row["register_no"];
	$nestedData[] = $Row["student_name"];
	$nestedData[] = get_class_byid($Row["class_id"])['class_name'];
	// $nestedData[] = get_student_records_by_stuid($Row["student_id"])['roll_no'] ?? '0' ;
	$nestedData[] = $Row["roll_no"];
	$nestedData[] = $Row["date"];


	$nestedData[] = $Row['att_type_name'];
	$nestedData[] = $Row["reason"];
	// $nestedData[] = $Row["parent_no"];

	// $nestedData[] = ($Row["blood_grp"]) ? $Row["blood_grp"] : "N/A";
	// $nestedData[] = ($Row["mother_tongue"]) ? $Row["mother_tongue"] : "N/A";
	// $nestedData[] = ($Row["aadhar_card"]) ? $Row["aadhar_card"] : "N/A";

	
	
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
