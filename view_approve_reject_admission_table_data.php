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
	1 =>'reference_no`',
	2 =>'requested_date',
	3 =>'name',
	4 =>'fathername',
	5 =>'grade`',
	6 =>'previous_school`',
	7 =>'prev_grade',
	8 =>'previous_percentage',
	9 =>'address`',
	10 =>'city',
	11 =>'state',
	12 =>'requested_message',
	13 =>'apply_date',

	
);

// echo "<pre>";
// print_r($_POST['custom']);
// echo "</pre>"; die;
if(isset($_POST['custom'])){
    $reference_no=$_POST['custom']['reference_no'];
    $admission_grade=$_POST['custom']['admission_grade'];

}

$sql="SELECT * FROM admission WHERE  status='1' and session='".$_SESSION['session']."' ";

$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

$sql="SELECT * FROM admission WHERE  status='1' and session='".$_SESSION['session']."' ";
	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`admission_id` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `reference_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `requested_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `fathername` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `grade` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_school` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `prev_grade` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `previous_percentage` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `address` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `city` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `state` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `requested_message` LIKE '%".$requestData['search']['value']."%' ";
	$sql.= " )";
	
}
if(!empty($admission_grade)){
		$sql.=" and grade='$admission_grade' ";
}
if(!empty($reference_no)){
		$sql.=" and reference_no LIKE '%$reference_no%' ";
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

	// echo "<pre>";
	// print_r($Row);
	// echo "<pre>";

$nestedData[] =$count;
// $nestedData[] =$Row['admission_id'];

$nestedData[] =$Row['reference_no'];


$nestedData[] =date("d-M-y",strtotime($Row['requested_date']));

$nestedData[] =$Row['name'];

$nestedData[] =$Row['fathername'];

$nestedData[] =$Row['gender'];

$nestedData[] =$Row['phone'];

$nestedData[] =get_class_byid($Row['grade'])['class_name'] ?? "NA" ;
// = mysqli_query($con,"select * from class where class_id='$grade'");

// 	$re = mysqli_fetch_array($scls);

	// $class = $Rowcls['class_name'];
$nestedData[] =$Row['previous_school'];
// $nestedData[] =$Row['previous_grade'];

	// $scls1 = mysqli_query($con,"select * from class where class_id='$prev_grade'");

	// $Rowcls1 = mysqli_fetch_array($scls1);

$nestedData[] =get_grade_byid($Row['previous_grade'])['grade_name'] ?? "NA";

$nestedData[] =$Row['previous_percentage'];

$nestedData[] =$Row['address'];

$nestedData[] =$Row['city'];

$nestedData[] =$Row['state'];
// $nestedData[] =$Row['requested_message'];
$nestedData[] ='<a onclick="Approve('.$Row["admission_id"].')" href="javascript:void(0)" data-id='.$Row["admission_id"].' class="btn btn-success" style="width:100px;border-radius:20px">Accept</a>';

									

$nestedData[] ='<a href="javascript:void(0)" class="btn btn-danger" onclick="decline('.$Row["admission_id"].')" style="width:100px;border-radius:20px">Decline </a>';
// $nestedData[] =$Action;

	
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
