<?php
// ini_set('display_errors', 1);
// 	    ini_set('display_startup_errors', 1);
// 	    error_reporting(E_ALL);
include('myfunction.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
$select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'student_id',
	1 =>'register_no`',
	2 =>'student_name',
	3 =>'father_name',
	4 =>'gender',
	5 =>'dob',
	6 =>'sr.class_id',
	7 =>'sr.section_id',
	8 =>'sr.roll_no',
	9 =>'parent_no',
	10 =>'aadhar_card',
	11 =>'session',
	12 => 'stuaddress',
	// 12 =>'city',
	// 13 =>'state',
	// 14 =>'state',
	// 12 =>'requested_message',


	  
);

if(isset($_POST['custom'])){
 
    $class_id=$_POST['custom']['class_id'];
    $section_id=$_POST['custom']['section_id'];
}

// $qsql="SELECT `id` FROM `student_records` where `session`>'".$_SESSION['session']."' ";
// $cuery = $con->query($qsql);
// if($cuery->num_rows>0){
// 	while()
// }


// $sql="SELECT * FROM `students` WHERE  `stu_status`='0' and `session`='".$_SESSION['session']."' ";
  $sql = "SELECT `student_id`, `register_no`, `student_name`, `father_name`,  `gender`, `dob`, `admission_date`, `sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`, `due`,  `parent_no`,  `stuaddress`,  `aadhar_card`, `sr`.`session`, `create_date`, `modify_date`FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where stu_status='0'  AND `sr`.`session`= '".$_SESSION['session']."'  AND `promote_status`= '0' ";

$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

// $sql="SELECT * FROM `students` WHERE  `stu_status`='0'  and `session`='".$_SESSION['session']."' ";
	 $sql = "SELECT `student_id`, `register_no`, `student_name`, `father_name`,  `gender`, `dob`, `admission_date`, `sr`.`class_id` ,`sr`.`section_id`, `sr`.`roll_no`, `due`,  `parent_no`,  `stuaddress`,  `aadhar_card`, `sr`.`session`, `create_date`, `modify_date`FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where stu_status='0'  AND `sr`.`session`= '".$_SESSION['session']."'  AND `promote_status`= '0' ";
	  // EXISTS (    SELECT `stu_id`   FROM  student_records    WHERE `session`> '".$_SESSION['session']."')"; 

	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`student_id` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `register_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `student_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `father_name` LIKE '%".$requestData['search']['value']."%' ";
	
	$sql.=" OR `dob` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `parent_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `aadhar_card` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `sr`.`session` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `stuaddress` LIKE '%".$requestData['search']['value']."%' ";
	
	
	$sql.= " )";
	
}

if(!empty($class_id) && !empty($section_id)){
	$sql.=" and sr.class_id='$class_id' and `sr`.section_id='$section_id' ";
}elseif(!empty($class_id)){

	$sql.=" and sr.class_id='$class_id' ";
}else{
	die;
}


// echo "<br>".$sql;
$query = $con->query($sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."    ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;

$query = $con->query($sql);



$data = array();
$count=1;
while($Row=mysqli_fetch_assoc($query) ) {  // preparing an array
	$nestedData=array();


$nestedData[] ='<input type="checkbox" class="checkboxall ht" id="checkrow" name="chk[]"  value='.$Row['student_id'].'  style="height:20px;width:20px;margin-left:18px;margin-top:10px;">';


// $nestedData[] =Date('d-m-Y',strtotime($Row['apply_date']));

$nestedData[] =$Row['register_no'];

$nestedData[] =$Row['student_name'];

$nestedData[] =$Row['father_name'];

$nestedData[] =$Row['gender'];

$nestedData[] =$Row['dob'];

$nestedData[] =get_class_byid($Row['class_id'])['class_name'] ?? "NA" ;

$nestedData[] =get_section_byid($Row['section_id'])['section_name'] ?? "NA" ;
$nestedData[] = ($Row['roll_no']) ? $Row['roll_no'] : '0' ;
$nestedData[] =$Row['parent_no'];


$nestedData[] =($Row['aadhar_card']) ? $Row['aadhar_card'] : "NA";

$nestedData[] =getSessionByid($Row['session'])['year'] ?? "NA" ;

$nestedData[] =$Row['stuaddress'];



	
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
