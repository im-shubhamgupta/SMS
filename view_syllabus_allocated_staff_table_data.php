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
	0 =>'assign_syllabus_id',
	1 =>'staff_id',
	2 =>'class_id',
	3 =>'section_id',
	4 =>'subject_id',
	5 =>'chapter',
	6 =>'from_dt',
	7 =>'to_dt',
	8 =>'days',
	9 =>'description',
	10 =>'status',
	11 =>'completion_date',
	12 =>'updated_dt',
	13 =>'updated_by',
	14 =>'comments',
	15 =>'creation_dt',
	
);



if(isset($_POST['custom'])){
    $faculty =  $_POST['custom']['faculty'];
    $class =  $_POST['custom']['class'];
    $section =  $_POST['custom']['search_sect'];
    $subject =  $_POST['custom']['search_subj'];
    $fromdt =  $_POST['custom']['fromdt'];
    $todt =  $_POST['custom']['todt'];
    $status =  $_POST['custom']['status'];
}
if(empty($faculty) || empty($class) || empty($section) || empty($subject) ){
	die;
}

 $sql = "SELECT * FROM `assign_syllabus_staff` WHERE 1  ";


$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  
 $sql = "SELECT * FROM `assign_syllabus_staff` WHERE 1  ";

	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`chapter` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `from_dt` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `to_dt` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `days` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `description` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `status` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `completion_date` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `updated_dt` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `caste` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `updated_by` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `comments` LIKE '%".$requestData['search']['value']."%' ";

	$sql.="  )";
	
}
if(!empty($faculty)){
		$sql.=" && staff_id='$faculty' ";
}
if(!empty($class) && !empty($section) ){
	$sql.=" AND `class_id`='$class'  AND section_id='$section' ";
}elseif(!empty($class) && empty($section)){
	$sql.=" AND `class_id`='$class'  ";
}
if(!empty($subject)){
	$sql.=" && subject_id='$subject' ";
}
if(!empty($status)){
	$sql.=" && status='$status' ";
}

if(!empty($fromdt) && !empty($todt)){
	$sql.=" && `from_dt`>='$fromdt' && `to_dt`<='$todt' ";
}
$sql.=" and session='".$_SESSION['session']."' ";

$query = $con->query($sql);
$totalFiltered = mysqli_num_rows($query);  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;

$query = $con->query($sql);

$data = array();
$count=1;
while($Row=mysqli_fetch_array($query) ) {  // preparing an array
		$id=$Row['assign_syllabus_id'];

		$staffid=$Row['staff_id'];

		$qst=mysqli_query($con,"select * from staff where st_id='$staffid'");

		$rst=mysqli_fetch_array($qst);

		$stname=$rst['staff_name'];

		$clid=$Row['class_id'];

		$qcls=mysqli_query($con,"select * from class where class_id='$clid'");

		$rcls=mysqli_fetch_array($qcls);

		$clsname=$rcls['class_name'];

		$secid=$Row['section_id'];

		$qsec=mysqli_query($con,"select * from section where section_id='$secid'");

		$rsec=mysqli_fetch_array($qsec);

		$secname=$rsec['section_name'];

		$subid=$Row['subject_id'];

		$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");

		$rsub=mysqli_fetch_array($qsub);

		$subname=$rsub['subject_name'];

		$sta = $Row['status'];

		if($sta==1){

			$st = "Done";

		}elseif($sta==2){

			$st = "In Progress";

		}elseif($sta==3){

			$st = "Not Started";

		}

	$nestedData=array();
	
	
	$nestedData[] =$count;
	$nestedData[] = $stname;
	$nestedData[] =  $clsname;
	$nestedData[] =$secname;
	$nestedData[] = $subname;
	$nestedData[] = $Row['chapter'];
	$nestedData[] =  date("d-m-Y",strtotime($Row['from_dt']));
	$nestedData[] = date("d-m-Y",strtotime($Row['to_dt']));
	$nestedData[] =  $Row['days'];
	$nestedData[] = $Row['description'];
	$nestedData[] = $st;
	if(!empty($Row['completion_date'])){
		$nestedData[] =date("d-m-Y",strtotime($Row['completion_date']));
	}else{
		$nestedData[] ="N/A";
	}
	if(!empty($Row['updated_dt'])){
		$nestedData[] = date("d-m-Y",strtotime($Row['updated_dt']));
	}else{
		$nestedData[] ="N/A";
	}
	
	
	$nestedData[] = ($Row['updated_by']) ? $Row['updated_by'] : "N/A" ;
	$nestedData[] =($Row['comments']) ? $Row['comments'] : "N/A" ;

	// $Action="<a href='dashboard.php?option=view_students_details&sid=".$id."' class='btn btn-success btn-sm' title='View all details of student.'>view Details</a>";
	$Action="<a href='dashboard.php?option=update_allocated_syllabus&id=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";
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
