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
	0 =>'admission_id',
	1 =>'reference_no',
	2 =>'requested_date',
	3 =>'name',
	4 =>'fathername',
	5 =>'gender',
	6 =>'phone',
	7 =>'grade',
	8 =>'previous_school',
	9 =>'previous_grade',
	10 =>'previous_percentage',
	11 =>'address',
	12 =>'city',
	13 =>'state',
	14 =>'accept_decline_date',

);

// if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){

//     $classtype = $_POST['custom']['classtype'];
//     $section = $_POST['custom']['section'];

// }

 $sql = "SELECT * FROM `admission` where ( `status`='2' || `status`='4' ) and `session`='".$_SESSION['session']."'  ";



$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  


 $sql = "SELECT * FROM `admission` where ( `status`='2' || `status`='4' )  and `session`='".$_SESSION['session']."'    ";
	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`reference_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `requested_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `fathername` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `gender` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `phone` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `grade` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_school` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_grade` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_school` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_percentage` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `address` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `city` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `state` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `accept_decline_date` LIKE '%".$requestData['search']['value']."%' ";
	
	$sql.=" )";
	
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
	
	$nestedData[] = $count;
	if($Row["status"]=='2'){
		$nestedData[] ='<a href="dashboard.php?option=add_students&ref_stu='.$Row["admission_id"].'"  class="btn btn-primary" style="width:140px;border-radius:20px" >Add Student</a>';
		//onclick="window.location.reload()"
	}else{
		$nestedData[] ='<a href="javascript:void(0)"" class="btn btn-success" style="width:140px;border-radius:20px;background-color:#cccccc;">Admission taken</a>';
	}
	
	$nestedData[] = $Row["reference_no"];
	
	$nestedData[] = date("d-M-Y",strtotime($Row["requested_date"]));

	$nestedData[] = $Row['name'];
	$nestedData[] = $Row["fathername"];
	$nestedData[] = $Row["gender"];
	$nestedData[] = $Row["phone"];
	$nestedData[] = get_class_byid($Row["grade"])['class_name'] ?? 0;	


	$nestedData[] = $Row["previous_school"];
	
	$nestedData[] = get_class_byid($Row["previous_grade"])['class_name'] ?? "NA";

	$nestedData[] = $Row["previous_percentage"] ? $Row["previous_percentage"] : "N/A";
	
	$nestedData[] = $Row["address"] ? $Row["address"] : "N/A";
	$nestedData[] = $Row["city"] ? $Row["city"] : "N/A";
	$nestedData[] = ($Row["state"]) ? $Row["state"] : "N/A";

	$nestedData[] = date("d-M-Y",strtotime($Row['accept_decline_date']));

	
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
