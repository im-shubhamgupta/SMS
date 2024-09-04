<?php 

include('connection.php');

extract($_REQUEST);
?>
<div id="right-panel"  style="width:100%">
<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Staff Panel</a>

  <a class="breadcrumb-item" href="#"> Staff Time Table</a>

  <span class="breadcrumb-item active"> Import Staff Time Table</span>

</nav>
<?php
if (isset($_POST['upload'])) 

{
	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";

	// $q1 = mysqli_query($con,"SELECT * FROM `staff_timetable` WHERE `class_id` = '".$clsid."' && `section_id` = '".$secid."' && `day` = '".$dayid."'  && `period` = '".$period."' && `subject_id` = '".$subid."'");

	

	// $row = mysqli_num_rows($q1);

	// if($row>0)

	// {

		// echo "<script>alert('Time Table Already Exists')</script>";

	// }

	// else

	// {

		

	$csvfile = $_FILES['csvfile']['name'];

	$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

	$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



	if(!$_FILES['csvfile']['name'] == ""){ 

	if($ext == "csv"){

	 

	 if(file_exists($base_name)){

		  echo "file already exist" . $base_name;
	}else{

	if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){
		//echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
		// echo "<h1>" . " uploaded successfully " . "</h1>";
		// readfile($_FILES['csvfile']['tmp_name']);
	}
			$handle = fopen($_FILES['csvfile']['tmp_name'], "r");

				

			$headerLine = true;

			fgetcsv($handle, 1000, ",");

			// $x=0;
			// $empty=0;
			// $already=0;
			// $false_query=0;
			// $serial_no=array();
			$count=0;
			$already=array();
			$not_upload=array();
			$success_upload=array();
			$error=0;
			$false_query=0;

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$subname ='';
		$subid = '';
		$clsname='';
		$srno=$con->real_escape_string($data[0]);

		$clsname = $con->real_escape_string($data[1]);

		$clsname = trim($clsname," ");

		if($clsname=="Leisure"){

			$clsid = "Leisure";

		}else{
			$csql="select * from class where class_name='$clsname'";
			$qcls=mysqli_query($con,$csql);

			if(mysqli_num_rows($qcls) > 0){

				$rcls=mysqli_fetch_array($qcls);

				$clsid=$rcls['class_id'];

			}

		}

		$secname=$con->real_escape_string($data[2]);

		$secname = trim($secname," ");

		if($secname=="Leisure"){

			$secid = "Leisure";

		}else{
			if($clsid=='Leisure'){
				$clsql="";
			}else{
				$clsql==" and class_id='$clsid' ";
			}

			$qsec=mysqli_query($con,"select * from section where section_name='$secname'  $clsql ");

			if(mysqli_num_rows($qsec) > 0){

				$rsec=mysqli_fetch_array($qsec);

				$secid=$rsec['class_id'];

			}
		}

		$day=$con->real_escape_string($data[3]);

		$day = strtoupper(trim($day," "));

		$qday=mysqli_query($con,"select * from days where upper(day_name)='$day'");

		if(mysqli_num_rows($qday) > 0){

		$rday=mysqli_fetch_array($qday);

			 $dayid=$rday['day_id'];

		}

		$period=$con->real_escape_string($data[4]);

		$period = trim($period," ");

		

		$subname=$con->real_escape_string($data[5]);

		$subname = trim($subname," ");

		if($subname=="Leisure"){

			$subid = "Leisure";

		}else{

			$sqll="select * from subject where subject_name='$subname' && class_id='$clsid'";

			$qsub=mysqli_query($con,$sqll);

			if(mysqli_num_rows($qsub) > 0){

				$rsub=mysqli_fetch_array($qsub);

				$subid=$rsub['subject_id'];

			}

		}
			 $csql="SELECT * FROM `staff_timetable` WHERE `class_id` = '".$clsid."' && `section_id` = '".$secid."' && `day` = '".$dayid."'  && `period` = '".$period."' && `subject_id` = '".$subid."' && `session`='".$_SESSION['session']."'";
			$CheckQuery = $con->query($csql);

		

			if($clsid=="" || $secid=="" || $dayid=="" || $period=="" || $subid==""){
				$not_upload[]=$srno;
				$error+=1;
				// $empty+=1;
				// $serial_no[]=$srno;
				continue;
			}else if($CheckQuery->num_rows > 0){
				// $already+=1;
				// $serial_no[]=$srno;
				$already[]=$srno;
				$error+=1;
				continue;
			}else{		
				$isql="insert into staff_timetable (class_id,section_id,tperiod,day,period,subject_id,staff_id,session,create_date,modify_date)
				VALUES('".$clsid."', '".$secid."', '".$tperiod."', '".$dayid."', '".$period."', '".$subid."', '".$staffid."','".$_SESSION['session']."',now(),now())";
				$import=mysqli_query($con,$isql);

				if($import){
					// $x+=1;
					$success_upload[]=$srno;
							$count+=1;
				}else{
					// $serial_no[]=$srno;
					// $false_query+=1;
					$false_query+=1;
						$not_upload[]=$srno;
				}
				// if(mysqli_error($con)){
				// 	echo ("Error description :" .mysqli_error($con));
				// }

			}
	} //while
	foreach($already as $k1 => $v1){
		 if(empty($v1)){
		  unset($already[$k1]);
		  }
		}
	foreach($not_upload as $k => $v){
		 if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}	
	$err_regisno=implode(', ', $not_upload);
	$err_already=implode(', ', $already);	
	// $total=$already+$empty+$false_query;
	// $sr_no=implode(', ',$serial_no);
	if(!empty($err_already) && !empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.')Data uploaded Sucessfully. This  SrNo. has not been uploaded ('.$err_already.' )due to already exist & This  SrNo. has not been uploaded ( '.$err_regisno.' ) please check the given data. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

	}elseif(!empty($err_already)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Data uploaded Successfully. This SrNo. not uploaded ('.$err_already.') due to already exist. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

			
	}elseif(!empty($err_regisno)){
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Data Uploaded, This SrNo. has not been uploaded : ('.$err_regisno.') please check the given data .</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

		}else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Data Uploaded Sucessfully</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

		}

		// echo "<script>window.location='dashboard.php?option=upload_staff_timetable'</script>";
	}
	}else{

		 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
	}
	}else{
	 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                                <strong class="card-title"><a href="csv/upload_staff_timetable.csv" class="btn btn-primary btn-sm">

								<i class="fa fa-download"></i> Download Format</a><br/><br/></strong>

                            </div>

                            <form method="post" enctype="multipart/form-data">

										

                            <div class="card-body">

                                

							<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px">Select Staff</div>

							<div class="col-md-2" style="margin-top:-10px;">

							<select name="staffid" class="form-control" autofocus required>

							<option value="" selected="selected" disabled>Select Staff</option>

							<?php

							$st = mysqli_query($con,"select * from staff where status='1'");

							while( $rst = mysqli_fetch_array($st) ) {

							?>

							<option <?php if($staffid==$rst['st_id']){echo "selected";}?> value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>					

							

							

							<div class="col-md-2" style="margin-left:50px;">No of Period </div>

							<div class="col-md-2" style="margin-top:-10px">

							<input type="number" name="tperiod" class="form-control" autofocus required/>	

							</div>

							</div><br>	

								

							<div class="row">

								<div class="col-md-12">

									<div class="panel-group">

									<div class="panel panel-default">

											

										<?php echo @$err; ?>	



									<div class="row">

										<div class="col-md-5" style="margin-left:20px">

											<div class="panel-body">

											<label>Upload Time Table</label>

											<input class="form-control" type="file" required name="csvfile">

											</div>

										</div>

									</div><br>

									<span><b>Note:</b> *Class, Section, Day of week, Subject name is case sensitive.</span>
									

										

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

