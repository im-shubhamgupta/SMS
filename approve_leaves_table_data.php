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
	0 =>'student_id',
	1 =>'`st`.`register_no`',
	2 =>'`st`.`student_name`',
	3 =>'class_id',
	4 =>'section_id',
	5 =>'leave_id',
	6 =>'submission_date',
	7 =>'from_date',
	8 =>'to_date',
	9 =>'total_days',
	10 =>'reason',
	11 =>'note',
	12 =>'submission_date',
	13 =>'`sl`.`create_date`',
	14 =>'submission_date',
);

// echo "<pre>";
// print_r($_POST['custom']);
// echo "</pre>"; die;
// if(isset($_POST['custom'])){
//     $reference_no=$_POST['custom']['reference_no'];
//     $admission_grade=$_POST['custom']['admission_grade'];

// }

// $sql="select * from student_leave 
$sql="SELECT `sl`.`stu_leave_id`,`sl`.`student_id`,`submission_date`,`from_date`, `to_date`,`leave_id`, `total_days`,`reason`,`note`,`attachment`,`sl`.`status`,`sl`.`class_id`,`sl`.`section_id`,`st`.`student_name`,`st`.`register_no` "; 
$sql.=" FROM student_leave as `sl` join `students` as `st` ON `sl`.`student_id`=`st`.`student_id`  "; 
$sql.=" where status='0' and `sl`.`session`='".$_SESSION['session']."' ";

$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

// $sql="select * from student_leave where status='0' and `session`='".$_SESSION['session']."' ";
	$sql="SELECT `sl`.`stu_leave_id`,`sl`.`student_id`,`submission_date`,`from_date`, `to_date`,`leave_id`, `total_days`,`reason`,`note`,`attachment`,`sl`.`status`,`sl`.`class_id`,`sl`.`section_id`,`st`.`student_name`,`st`.`register_no` "; 
$sql.=" FROM student_leave as `sl` join `students` as `st` ON `sl`.`student_id`=`st`.`student_id`  "; 
$sql.=" where status='0' and `sl`.`session`='".$_SESSION['session']."' ";

	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`sl`.`student_id` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `submission_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `from_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `to_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `leave_id` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `total_days` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `reason` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `note` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `st`.`student_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `st`.`register_no` LIKE '%".$requestData['search']['value']."%' ";
	
	$sql.= " )";
	
}
// if(!empty($admission_grade)){
// 		$sql.=" and grade='$admission_grade' ";
// }
// if(!empty($reference_no)){
// 		$sql.=" and reference_no LIKE '%$reference_no%' ";
// }


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

	// echo "<pre>";
	// print_r($Row);
	// echo "<pre>";

$id=$Row["stu_leave_id "];
$nestedData[] =$count;

// $nestedData[] =getStudent_byStudent_id($Row['student_id'])['register_no'] ?? "NA";
$nestedData[] =$Row['register_no'] ?? "NA";
$nestedData[] =$Row['student_name'] ?? "NA";



$nestedData[] =get_class_byid($Row['class_id'])['class_name'] ?? "NA" ;
$nestedData[] =get_section_byid($Row['section_id'])['section_name'] ?? "NA" ;

$nestedData[] =get_leave_type_byid($Row['leave_id'])['leave_name'] ?? "NA";


$nestedData[] =date("d-m-Y",strtotime($Row['submission_date']));

$nestedData[] =date("d-m-Y",strtotime($Row['from_date']));

$nestedData[] =date("d-m-Y",strtotime($Row['to_date']));

$nestedData[] =$Row['total_days'];

$nestedData[] =$Row['reason'];
$nestedData[] =$Row['note'];
if(!empty($Row['attachment'])){
	$nestedData[] ='<a href="images/leave/'.$Row['student_id'].'/'.$Row['attachment'].'" target="blank" title="click to full view"><img src="images/leave/'.$Row['student_id'].'/'.$Row['attachment'].' " 	style="width:100px;height:80px;">';
}else{
	$nestedData[] ='<img src="images/leave/'.$Row['student_id'].'/'.$Row['attachment'].' " 	style="width:100px;height:80px;">';
}


$nestedData[] ='<a onclick="Approve('.$Row["stu_leave_id"].')" href="javascript:void(0)" data-id="'.$Row["stu_leave_id"].'" class="btn btn-success" style="width:100px;border-radius:20px">Accept</a>';

$nestedData[] ='<a href="javascript:void(0)" class="btn btn-danger" onclick="decline('.$Row["stu_leave_id"].')" style="width:100px;border-radius:20px">Decline </a>';


	
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
