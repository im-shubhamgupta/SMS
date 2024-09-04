<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

        

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>
  <a class="breadcrumb-item" href="#">Route</a>

  <span class="breadcrumb-item active">Import CSV Route to Students</span>

</nav>
<?php
if (isset($_POST['upload'])) 

{
// 	echo "<pre>";
// 	print_r($_POST);
// 	print_r($_FILES);
// 	echo "</pre>";
// die;

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);  //extension

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



if(!$_FILES['csvfile']['name'] == "")   

{ 

if($ext == "csv")

{ 

 if(file_exists($base_name))

{

      echo "file already exist" . $base_name;
}
    else
{
// if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){
	// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

	// readfile($_FILES['csvfile']['tmp_name']);  //csv read karke output kardega

// }

     $handle = fopen($_FILES['csvfile']['tmp_name'], "r");

		$headerLine = true;

		$session=$_SESSION['session'];
		$route_assign_success=array();
		$already_register=array();
		$invalid_register_no=array();
		$invalid_route_name=array();
		$x=0;

while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){	
	date_default_timezone_set('Asia/Kolkata');

    $invalid_route=1;	

	$regno=mysqli_real_escape_string($con,$data[0]);

	// $qreg=mysqli_query($con,"select * from students where register_no='$regno' and `session` = '$session' ");
	$qreg=mysqli_query($con,"select `student_id`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where register_no='$regno' && stu_status='0'  && sr.session='".$_SESSION['session']."'") ;


	$row = mysqli_num_rows($qreg);

	if($row > 0){

		$rreg=mysqli_fetch_array($qreg);

		$studentid=$rreg['student_id'];

		$clsid=$rreg['class_id'];

		$secid=$rreg['section_id'];
		 // check unique
		$Squery=mysqli_query($con, "select * from `student_route` where `student_id`='$studentid' and `session` = '$session'" );
		if(!$srow=mysqli_num_rows($Squery)){
		
		
			$routename2=mysqli_real_escape_string($con,$data[4]);
			$routename=strtoupper($routename2);
			// lower(route_name) ='$routename' ||
			$q1=mysqli_query($con,"select * from transports where  upper(route_name) ='$routename' and session='".$_SESSION['session']."' ");
			if(mysqli_num_rows($q1)>0){
				$r1=mysqli_fetch_array($q1);

				$transid=$r1['trans_id'];

				$transamt = $r1['price'];

		    }else{
		    	$invalid_route_name[]=$routename;
		    	$invalid_register_no[]=$regno;
		    	$invalid_route=0;
		    }
			
		    if($invalid_route==1){
				$q2 = mysqli_query($con,"select * from student_wise_fees where student_id='$studentid'  AND `session` = '$session' ");

				$r2 = mysqli_fetch_array($q2);

				$olddue = $r2['due_amount'];

				$newdue = $olddue + $transamt;     //add old dues & transport amount fee

				$create_date=date('Y-m-d H:i:s');
				$modify_date=$create_date;
	            
			    $import="INSERT INTO student_route(student_id,class_id,section_id,trans_id,fee_mode_id,price,due_amount,status,session,create_date,modify_date)

				VALUES('$studentid','$clsid','$secid','$transid','1','$transamt','$transamt','1','$session','$create_date','$create_date')";		

				if(mysqli_query($con,$import)){
					//currently comment due to it,s create distrubance at fee structure
					
					// "update students set due=(`due`+'$transamt') ,modify_date='$modify_date' where student_id='$studentid'  AND `session` = '$session'";

					// "update student_wise_fees set due_amount=(`due_amount`+'$transamt') ,modify_date='$modify_date' where student_id='$studentid'  AND `session` = '$session' ";
					
				$route_assign_success[]=$regno;	
				}
			}

		}
		else{ 
			$already_register[]=$regno;

		}	
	}else{
		if($x>0){ //skip the header of csv
		  $invalid_register_no[]=$regno;
	    }
	

	}

$x++;

}
 fclose($handle);
 $a='';
 // $already_register=array_unique($already_register);
 // $invalid_register_no=array_unique($invalid_register_no);
 $err=array_unique(array_merge($already_register,$invalid_register_no));
 if(!empty($err)){
 	$a.='('.implode(', ',$err) .') This Register no has not been uploaded.';
 }
 $co=count(array_unique($route_assign_success));
 // print_r($route_assign_success);
// if(!empty($invalid_register_no)){
// 	// $a.="<br>Invalid Register : ".implode(', ',$invalid_register_no );
// }

if($co > 0){
	 echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
	  <h4><strong>('.$co.') Student Route Uploaded successfully.</strong> '.$a.'</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';

}else{
	 echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
	   		<h4>No Any Register No. Uploaded. '.$a.'</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';

}

	// echo "<script>window.location='dashboard.php?option=view_route_to_student'</script>";

}

 

}else{
 echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
	   		<h4> Check Extension. your extension is  .'.$ext.';</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';
}

}else{
	echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
	   		<h4>Please Upload File</h4>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>';


 }

}

?>







        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title"><a href="csv/upload_students_route.csv" class="btn btn-primary btn-sm">

								<i class="fa fa-download"></i> Download Format</a><br /><br /></strong>

                            </div>

                            <div class="card-body">

                                <form method="post" enctype="multipart/form-data">

<div class="row">

	<div class="col-md-12">

		<div class="panel-group">

			<div class="panel panel-default">

				

			<?php //echo @$err; ?>	





		<div class="row">

			<div class="col-md-5">

				<div class="panel-body">

				<label>Upload Students Route</label>

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



	<button type="submit" value="Upload" class="btn btn-info btn-sm" name="upload">

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

