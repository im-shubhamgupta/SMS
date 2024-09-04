<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

 

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Previous Fees Management</a>

  <span class="breadcrumb-item active">Import CSV Previous Fees</span>

</nav>

<?php 


if (isset($_POST['upload'])) 

{

	date_default_timezone_set("Asia/Kolkata");

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



if(!$_FILES['csvfile']['name'] == "")   

{ 

if($ext == "csv"){ 

 if(file_exists($base_name)){

      echo "file already exist" . $base_name;
}
 else
{

	    

// if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 

// {

// 	echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

 

// 	readfile($_FILES['csvfile']['tmp_name']);

// }

          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");

		  $headerLine = true;
		  $invalid_register_no=array();
		  $success=array();
		  
          $x=0;

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
{	
	// echo "<pre>";	
// 	print_r($data);
// 	echo "</pre>";
	$already_register='0';
	$regno=$data[0];

	$session=$_SESSION['session'];
	$create_date=date("Y-m-d H:i:s");
	$modify_date=$create_date;
	// $sqli="select * from students where register_no='$regno' and `session`='$session' ";
	$sqli="select `student_id`,`due`,`student_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where register_no='$regno' and stu_status='0'  && `sr`.`session`='$session' ";
	$q1 = mysqli_query($con,$sqli);

	$row = mysqli_num_rows($q1);

	if($row){

		$r1=mysqli_fetch_array($q1);
		// echo "<pre>";
		// print_r($r1);
		// echo "</pre>";
		$studentid=$r1['student_id'];
		$clsid=$r1['class_id'];
		$secid=$r1['section_id'];

		$prevfee = $data[5];

		$olddue = $r1['due'];

		$newdue = $olddue + $prevfee;

		$clsname=$data[3];


		// $qcls=mysqli_query($con,"select * from class where class_name='$clsname'");

		// $rcls=mysqli_fetch_array($qcls);

		// $clsid=$rcls['class_id'];

		// $secname=$data[4];		


		// $qsec=mysqli_query($con,"select * from section where section_name='$secname' and class_id='$clsid'");

		// $rsec=mysqli_fetch_array($qsec);

		// $secid=$rsec['section_id'];
		$que1 = mysqli_query($con,"select * from student_wise_fees where student_id='$studentid' and `session`='$session' ");

		$res1 = mysqli_fetch_array($que1);

		$oldfee1 = $res1['due_amount'];

		$newdue1 = $oldfee1 + $prevfee;

		// echo "<br>studentid: ".$studentid;
		if(!$studentid==''){
			// echo "hello";
		    $sql="select * from `previous_fees` where `student_id`='$studentid' and `session`='$session'  ";
			$a1=mysqli_query($con, $sql);
			$arow=mysqli_num_rows($a1);
			if($arow >0){
				$already_register='0';
				$invalid_register_no[]=$regno;

			}else{
				$already_register='1';
			}

		if($already_register=='1'){


		$import=mysqli_query($con,"INSERT INTO previous_fees(student_id,class_id,section_id,previous_fees,remarks,session,create_date,modify_date)
		VALUES('$studentid','$clsid','$secid','$data[5]','$data[6]','$session','$create_date','$create_date')");		

		if($import){

		// ($con,"update students set due='$newdue' where student_id='$studentid' and `session`='$session' ");

		// ($con,"update student_due_fees set due_amount='$newdue' where student_id='$studentid'  and `session`='$session' ");


		// ($con,"update student_wise_fees set due_amount='$newdue1' where student_id='$studentid' and `session`='$session' ");

			$success[]=$regno;

		}else{
			$invalid_register_no[]=$regno;
		}

	}else{

		$invalid_register_no[]=$regno;
		// echo "Invalid Register Number.";

	}
    }else{
    	$invalid_register_no[]=$regno;
    }
    }else{
    	if($x>0){
    	   $invalid_register_no[]=$regno;
        }
    }

	$x++;

}//while close 
 fclose($handle);
 $a='';
 // $err=array_unique(array_merge($already_register,$invalid_register_no));
 $err=array_unique($invalid_register_no);
 // print_r($err);
 if(!empty($err)){
 	$a.='('.implode(', ',$err) .') This Register no. has not been uploaded.';
 }
 $co=count(array_unique($success));


if($co > 0){
	 echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
	  <h4><strong>('.$co.') Previous dues Uploaded successfully.</strong> '.$a.'</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';

}else{
	 echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
	   		<h4>No Any Previous dues  Uploaded. '.$a.'</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';

}

 

	// echo "<script>window.location='dashboard.php?option=view_previous_fees'</script>";

}//else close

 

}else{

  // echo " Check Extension. your extension is ." . $ext;
  echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
	   		<h4>.'.$ext.' extension is not valid. </h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';

}
}  

else

 {

 echo "Please Upload File";

 }

}

?>







        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title"><a href="csv/upload_previous_fees.csv" class="btn btn-primary">

								<i class="fa fa-download"></i> Download Format</a><br /><br /></strong>

                            </div>

                            <div class="card-body">

                                <form method="post" enctype="multipart/form-data">

<div class="row">

	<div class="col-md-12">

		<div class="panel-group">

			<div class="panel panel-default">

				

	





		<div class="row">

			<div class="col-md-12">

				<div class="panel-body">

				<label>Upload Students Previous Fees</label>

				<input class="form-control" type="file" required name="csvfile">

			

				</div>

			</div>

		</div><br>

						

		</div> <!-- End of section 1 row-->

			

													</div>

												</div>

											</div>

										</div>



	<div class="card-footer">

	<button type="submit" name="upload" value="Upload" class="btn btn-info btn-sm">

	<i class="fa fa-upload"></i> Upload

	</button>

	</div>

										

							</section>			

						</form>		

					</div>

				</div>

			</div>

		</div>

	</div><!-- .animated -->

</div><!-- .content -->

</div><!-- /#right-panel -->

