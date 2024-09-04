<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

    

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Time Table</a>

  <span class="breadcrumb-item active"> Import CSV Time Table</span>

</nav>

<?php
if (isset($_POST['upload'])) 

{

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
			$already=array();
			$not_upload=array();
			$success_upload=array();
			$error=0;
			$false_query=0;
			

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	

	
    $sr_no=mysqli_real_escape_string($con,$data[0]);
	$clsname=mysqli_real_escape_string($con,$data[1]);
	if(!empty($clsname)){
		$qcls=mysqli_query($con,"select * from class where class_name='$clsname'");

	$rcls=mysqli_fetch_array($qcls);

	$clsid=$rcls['class_id'];

	}else{
		$clsid='';
	}
	

	

	$secname=mysqli_real_escape_string($con,$data[2]);
	if(!empty($secname) && !empty($clsid)){
	$qsec=mysqli_query($con,"select * from section where section_name='$secname' and class_id='$clsid'");

	$rsec=mysqli_fetch_array($qsec);

	$secid=$rsec['section_id'];
	}else{
		$secid='';
	}

	$tperiod=mysqli_real_escape_string($con,$data[3]);
	$tbreak=mysqli_real_escape_string($con,$data[4]);

	$day=mysqli_real_escape_string($con,$data[5]);
	if(!empty($day)){
	$day=strtoupper($day);
	$qday=mysqli_query($con,"select * from days where upper(day_name)='$day'");

	$rday=mysqli_fetch_array($qday);

	$dayid=$rday['day_id'];
	}else{
		$dayid='';
	}

	

	$period=mysqli_real_escape_string($con,$data[6]);

	

	$fromtime=mysqli_real_escape_string($con,$data[7]);

	$totime=mysqli_real_escape_string($con,$data[8]);

	

	$sub=mysqli_real_escape_string($con,$data[9]);
	if(!empty($sub) && !empty($clsid)){
		$sub=strtoupper($sub);
		$qsub=mysqli_query($con,"select * from subject where upper(subject_name)='$sub' && class_id='$clsid'");

		$rsub=mysqli_fetch_array($qsub);

		$subid=$rsub['subject_id'];
    }else{
    	$subid='';
    }

	if($sub=="Lunch")

	{

		$subject = "Lunch";

	}

	else if($sub=="Break")

	{

		$subject = "Break";

	}

	else

	{

		$subject = $subid;

	}

	

	/*$teacher=mysqli_real_escape_string($con,$data[10]);
	if(!empty($teacher)){
		$teacher=strtoupper($teacher);
		$qst=mysqli_query($con,"select * from staff where upper(staff_name)='$teacher'");

		$rst=mysqli_fetch_array($qst);

		$staffid=$rst['st_id'];	
	}else{
		$staffid='';
	}*/
	$staffid=mysqli_real_escape_string($con,$data[10]);
	if(!empty($staffid)){
		
		$qst=mysqli_query($con,"select * from staff where upper(staff_id)='$staffid'");

		$rst=mysqli_fetch_array($qst);

		$verified_staffid=$rst['st_id'];	
	}else{
		$staffid='';
		$verified_staffid='';
	}

	if($staffid=="Lunch")

	{

		$staff = "Lunch";

	}

	else if($staffid=="Break")

	{

		$staff = "Break";

	}

	else

	{

		$staff = $verified_staffid;

	}

	

	

	// if($headerLine) { $headerLine = false; }
	// echo "<br>id".$subid;
	if($clsid=="" || $secid=="" || $dayid=='' || $subid=='' || $verified_staffid=='' ){
		$not_upload[]=$sr_no;
		$error+=1;
		// echo "empty";
		continue;

	}else

	{

		$import=mysqli_query($con,"insert into time_table (class_id,section_id,tperiod,tbreak,day,period,start_period,end_period,subject_id,staff_id,session,create_date,modify_date)

		VALUES('$clsid','$secid','$tperiod','$tbreak','$dayid','$period','$fromtime','$totime','$subject','$staff','".$_SESSION['session']."',now(),now())");
		if($import){
			$success_upload[]=$sr_no;
			$count+=1;
		}else{

			$false_query+=1;
		    $not_upload[]=$sr_no;
		}
							

	}

 

}//while

foreach($not_upload as $k => $v){
		 if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}

	$err_regisno=implode(', ', $not_upload);

            if(!empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Time table uploaded successfully. This Sr no. not uploaded ('.$err_regisno.') please check the given data. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';
				}elseif($count > 0){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Time table successfully. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}

 

	// echo "<script>window.location='dashboard.php?option=upload_timetable'</script>";

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

                                <strong class="card-title"><a href="csv/upload_timetables.csv" class="btn btn-primary btn-sm">

								<i class="fa fa-download"></i> Download Format</a><br/><br/></strong>

                            </div>

                            <div class="card-body">

                                <form method="post" enctype="multipart/form-data">

<div class="row">

	<div class="col-md-12">

		<div class="panel-group">

			<div class="panel panel-default">

				

			<?php echo @$err; ?>



		<div class="row">

			<div class="col-md-12">

				<div class="panel-body">

				<label>Upload Time Table</label>

<input class="form-control" type="file" required name="csvfile">

			

				</div>

			</div>

		</div><br>

			

			<div>

			

			</div>

			

			

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

