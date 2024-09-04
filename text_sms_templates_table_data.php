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
	0 =>'id',
	1 =>'msg_type',
	2 =>'temp_id',
	3 =>'title',
	4 =>'description',
	5 =>'dummy_sms',
	6 =>'create_date',


);

if(!empty($_POST['custom']['language']) ){
    $lang = $_POST['custom']['language'];
   
}


 $sql = "SELECT * FROM `textsms_templates` where 1 ";


$con->set_charset('utf8');
$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

 $sql = "SELECT * FROM `textsms_templates` where 1 ";
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`msg_type` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `temp_id` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `title` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `description` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `dummy_sms` LIKE '%".$requestData['search']['value']."%' ";

		$sql.="  )";
}
	

	if(!empty($lang) ){

		$sql.=" AND `lang_type`='$lang' ";
	}
	


$query = $con->query($sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;
$con->set_charset('utf8');
$query = $con->query($sql);

$data = array();
$count=1;
while($Row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();


	$nestedData[] = $count;
	$nestedData[] =$Row['msg_type'];
	$nestedData[] = $Row['temp_id'];
	$nestedData[] = $Row['title'];
	$nestedData[] = $Row['description'];
	$nestedData[] = $Row['dummy_sms'];

	$nestedData[] = date("d-M-Y", strtotime($Row['modify_date']));


	$Action="<a href='dashboard.php?option=add_text_sms_template&id=".$Row['id']."' class='btn btn-success btn-sm' title='Edit'>Edit</a>";
	$nestedData[] = $Action;

	
	
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
