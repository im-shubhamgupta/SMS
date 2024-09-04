<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a> 

  <span class="breadcrumb-item active">Import CSV Assign Subject</span>

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
	//echo "<h1> uploaded successfully </h1>";

 

	// readfile($_FILES['csvfile']['tmp_name']);

}

          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");

			

		  $headerLine = true;

		  fgetcsv($handle, 1000, ",");
		    $count=0;
		$already=array();
		$not_upload=array();
		$success_upload=array();
		$error=0;
		$false_query=0;	


		  

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 

{				
	$check_staffid=false;
	$sr_no=$con->real_escape_string($data[0]);
	// $stname=$con->real_escape_string($data[1]);
	// $stname = trim($stname," ");

	/*if(!empty($stname)){
		$stname=strtoupper($stname);
		$qst=mysqli_query($con,"select * from staff where upper(staff_name)='$stname'");

		$rst=mysqli_fetch_array($qst);

		$staffid=$rst['st_id'];
	}else{
		$staffid = '';
	}*/
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
	if(!empty($subname)){
		$subname=strtoupper($subname);
		$qsub=mysqli_query($con,"select * from subject where upper(subject_name)='$subname'");

		$rsub=mysqli_fetch_array($qsub);

		$subjectid=$rsub['subject_id'];
	}else{
		$subjectid='';
	}
	
	

	$CheckQuery = $con->query("select * from assign_subject where class_id='$clsid' && section_id='$secid' && subject_id='$subjectid'");
	// echo "<br>staffid: ".$verified_staffid;
    if(!$check_staffid){
		// $wrong_id[]=$sr_no;
		$not_upload[]=$sr_no;
		$error+=1;
		continue;

	}elseif($verified_staffid=='' || $sr_no=='' || $staffid=="" || $clsid=="" || $secid=="" || $subjectid==""){
		$not_upload[]=$sr_no;
		$error+=1;
		continue;

	}else if($CheckQuery->num_rows > 0){
		$already[]=$sr_no;
		 $error+=1;
		continue;

	}else{

			

		$import=mysqli_query($con,"insert into assign_subject (st_id,class_id,section_id,subject_id,create_date,modify_date) VALUES('$verified_staffid','$clsid','$secid','$subjectid',now(),now())");
		if(mysqli_error($con)){
			echo("Error description2: ". mysqli_error($con));
			}
			if($import){
				$success_upload[]=$sr_no;
			    $count+=1;

			}else{
				$false_query+=1;
			    $not_upload[]=$sr_no;
			}
	}

 

}//while
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
	
	if(!empty($err_already) && !empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Assign subject uploaded successfully. This Sr no. has not been Uploaded ('.$err_already.' ) due to already exist  & This  Sr no. has not been uploaded ( '.$err_regisno.' ) please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Assign subject uploaded  successfully. This  Sr no. not uploaded ('.$err_already.') due to  already exist </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Assign subject uploaded successfully. This  Sr no. not Updated ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Assign subject uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}	

 

	// echo "<script>window.location='dashboard.php?option=upload_assign_subject'</script>";

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

                                <strong class="card-title"><a href="csv/upload_assign_subjects.csv" class="btn btn-primary">

								<i class="fa fa-download"></i> Download Format</a><br /><br /></strong>

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

				<label>Upload Subject</label>

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
                             <!-- <div >

						    <strong ><h5>Instructions for uploading Csv file:-</h5></strong>
							<span>
							
							<ol style="margin-left:20px">
								
								<li>Faculty name is Staff name.</li>
								<li>Faculty, Class, Section, Subject name  must be match from our given CSV Format.</li>
							</ol>
						    </span>

						</div> -->

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

