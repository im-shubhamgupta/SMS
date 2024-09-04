<?php 

include('connection.php');

extract($_REQUEST);?>

<div id="right-panel"  style="width:100%">

    
<!-- style="width:1000px;" -->
<nav class="breadcrumb" >

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Syllabus Management</a>  

  <span class="breadcrumb-item active">Import Allocated Syllabus to Staff</span>

</nav>

<?php
if (isset($_POST['upload'])){

	$csvfile = $_FILES['csvfile']['name'];

	$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

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

			

	if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 

	 

	{

		

		// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

	 

		// readfile($_FILES['csvfile']['tmp_name']);

	}

			  $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
			   fgetcsv($handle, 1000, ",");
				

			  $headerLine = true;
	  $count=0;
		$wrong_id=array();
		$not_upload=array();
		$success_upload=array();
		$error=0;
		$false_query=0;	

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	

	$check_staffid=false;		
	$sr_no=$con->real_escape_string($data[0]);
	$staffid=$con->real_escape_string(trim($data[1]));
		
    if(!empty($staffid)){
		$CheckQuery = $con->query("SELECT `st_id` FROM `staff` WHERE `staff_id`='".$staffid."' ");
		if($CheckQuery->num_rows > 0){
			$sta=$CheckQuery->fetch_assoc();
			$verified_staffid =$sta['st_id'];
			if(!empty($verified_staffid)){
				$check_staffid=true;
			}
		}else{
			$check_staffid=false;
			$verified_staffid ='';
		}
	}else{
		$staffid = '';
	}

	$clsname=$con->real_escape_string($data[2]);
	$clsname = trim($clsname," ");
	if(!empty($clsname)){
		$clsname=strtoupper($clsname);
		$qcls=mysqli_query($con,"select * from class where upper(class_name)='$clsname'");

		$rcls=mysqli_fetch_array($qcls);

		$clsid=$rcls['class_id'];
	}else{
		$clsid = '';
	}	

	$secname=$con->real_escape_string($data[3]);

	$secname = trim($secname," ");
	if(!empty($clsname) && !empty($clsid)){
		$secname=strtoupper($secname);
		$qsec=mysqli_query($con,"select * from section where upper(section_name)='$secname' and class_id='$clsid'");

		$rsec=mysqli_fetch_array($qsec);

		$secid=$rsec['section_id'];
	}else{
		$secid='';
	}	
	

	$subname=$con->real_escape_string($data[4]);

	$subname = trim($subname," ");
	if(!empty($subname) &&  !empty($clsid) ){
		$subname=strtoupper($subname);
		$qsub=mysqli_query($con,"select * from subject where upper(subject_name)='$subname' and class_id='$clsid' ");

		$rsub=mysqli_fetch_array($qsub);

		$subjectid=$rsub['subject_id'];
	}else{
		$subjectid='';
	}

	$chapter=$con->real_escape_string(trim($data[5]));

	$frmdt=date("Y-m-d", strtotime(str_replace('/','-',$data[6])));

	$nfrmdt = $frmdt;

	// $todt = $data[6];
	$todt=date("Y-m-d", strtotime(str_replace('/','-',$data[7])));

	$ntodt = $todt;

	$days=$con->real_escape_string(trim($data[8]));
	$description=$con->real_escape_string(trim($data[9]));	

	// if($headerLine) { $headerLine = false; }
	// echo 'verified_staffid'.$verified_staffid;
	if(!$check_staffid){
		$wrong_id[]=$sr_no;
		$error+=1;
		continue;

	}elseif($verified_staffid=='' || $staffid=="" || $clsid=="" || $secid=="" || $subjectid=="" || $frmdt=='' || $frmdt=='1970-01-01' || $todt=='' || $todt=='1970-01-01' ){
	    $not_upload[]=$sr_no;
		$error+=1;
		continue;
		
	}else{

		$import=mysqli_query($con,"insert into assign_syllabus_staff (staff_id,class_id,section_id,subject_id,chapter,from_dt,

		to_dt,days,description,status,session,creation_dt) 

		values('$verified_staffid','$clsid','$secid','$subjectid','$chapter','$frmdt','$todt','$days','$description','3','".$_SESSION['session']."',now())");

		if($import){
			$success_upload[]=$sr_no;
		    $count+=1;
		}else{
			$false_query+=1;
		    $not_upload[]=$sr_no;
		}
	}
}//while
	// echo "<pre>";
	// print_r($wrong_id);
	// echo "</pre>";
	foreach($wrong_id as $k1 => $v1){
		if(empty($v1)){
		  unset($wrong_id[$k1]);
		  }
		}
	
	foreach($not_upload as $k => $v){
		if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}	
	$err_regisno=implode(', ', $not_upload);
	$err_already=implode(', ', $wrong_id);
	
	if(!empty($err_already) && !empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject assigned successfully. This  Sr no. is not uploaded  ('.$err_already.' )due to staffid not matched & This  Sr no. is not uploaded ( '.$err_regisno.' ) please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject assigned successfully. This Sr no. is not uploaded ('.$err_already.') due to staffid not matched. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.')Subject assigned successfully. This  Sr no. not uploaded ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject assigned successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}	


	 

		// echo "<script>window.location='dashboard.php?option=upload_assign_syllabus_staff'</script>";

	}

	 

	}

	 

	else

	{

echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

	}

	 

	}  

	 

	else

	{

	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>Please Upload File </h4>
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

                                <strong class="card-title"><a href="csv/upload_assign_syllabus_staffs.csv" class="btn btn-primary btn-sm">

								<i class="fa fa-download"></i> Download Format</a><br/><br/></strong>

                            </div>

                            <form method="post" enctype="multipart/form-data">

										

                            <div class="card-body">

								

							<div class="row">

								<div class="col-md-12">

									<div class="panel-group">

									<div class="panel panel-default">

											

										<?php echo @$err; ?>	



									<div class="row">

										<div class="col-md-5" style="margin-left:20px">

											<div class="panel-body">

											<label>Upload Syllabus Details</label>

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

							</form>

									</section>			

									

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

