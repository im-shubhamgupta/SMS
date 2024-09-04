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
	1 =>'student_name',
	2 =>'student_name',
	3 =>'student_name',
	4 =>'student_name',
	5 =>'student_name',
	6 =>'student_name',
	7 =>'student_name',
	
);

if(isset($_POST['custom'])){
    $class_id = $_POST['custom']['class_id'];
    $section_id = $_POST['custom']['section_id'];
    $testname = $_POST['custom']['testname'];
}


 $sql = "SELECT * FROM `students` where stu_status='0'  AND `session`= '".$_SESSION['session']."'  ";



$query = $con->query($sql);

$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

 $que = mysqli_query($con,"select * from test where class_id='$class_id' && section_id='$section_id' && test_name='$testname'");

	 while($rque = mysqli_fetch_array($que)){

		 $subid = $rque['subject_id'];

		 $subidarr[] = $rque['subject_id'];
	 }




if( !empty($requestData['search']['value']) ) {  

 $sql = "SELECT * FROM `students` where stu_status='0' AND `session`= '".$_SESSION['session']."'  ";
	
// ORDER BY `admission_date` DESC
	$sql.=" AND (`register_no` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `student_name` LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR `father_name` LIKE '%".$requestData['search']['value']."%' ";
	

	$sql.="  )";
	
}
if(!empty($class_id) && !empty($section_id) ){

	$sql.=" AND `class_id`='$class_id'  AND section_id='$section_id' ";
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
	// $nestedData[] = $Row["student_id"];
	$nestedData[] = $Row["student_name"];

	// $nestedData[] = '<input type="hidden" name="studid[]" value="$Row[Student_id]">';


		$total = 0;

		$totalmarks = 0;

		$percent = 0;
		$gr=0;


		foreach($subidarr as $v){
		

			$que3 = mysqli_query($con,"select * from marks where class_id='$class_id' && section_id='$section_id' && test_name='$testname' && subject_id='$v' && student_id='".$Row['student_id']."' ");

			$res3 = mysqli_fetch_array($que3);

			$stumarks = $res3['marks'];

			if($stumarks){

				$marks = $stumarks;

			}else{

				$marks = 0;

			}

			$tmarks = $res3['max_mark'];

	

		
			$nestedData[] = $marks;

		

			$total = $total+$marks;

			$totalmarks = $totalmarks+$tmarks;
			if($totalmarks > 0){
				$totalmarks=$totalmarks;
			}else{
				$totalmarks=1;  //remove error
			}

			$per = round($total/$totalmarks*100,2);

			if(is_nan($percent)){

				$percent = 0;

			}else{

				$percent = $per;

			}
	}		

			$nestedData[] = $total." / ".$totalmarks;
			$nestedData[] = $percent." %";

			$nestedData[] = get_grade_by_percent($percent,$percent)['grade_name'];	
			// $nestedData[] =2;
			// $nestedData[] =3;
			// $nestedData[] =	4;					
			// $nestedData[] =	5;					
			// $nestedData[] =	6;					

	    
	// $Action="<a href='dashboard.php?option=view_students_details&sid=".$id."' class='btn btn-success btn-sm' title='View all details of student.'>view Details</a>";
	// $nestedData[] = $Action;

	

	
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
