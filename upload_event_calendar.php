<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

        

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Event Calendar</a>

  <span class="breadcrumb-item active"> Import CSV Event Calendar</span>

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

	    

if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){

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
			

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 

{	

	$sr_no=mysqli_real_escape_string($con,$data[0]);
	

	$creationdt = mysqli_real_escape_string($con,$data[1]);
	if(!empty($creationdt)){
		$creationdate=date("Y-m-d", strtotime(str_replace('/','-',$creationdt)));
	}else{
	
		$creationdate = '';
	}
		



	$clsname=mysqli_real_escape_string($con,$data[2]);
	if(!empty($clsname)){
		$qcls=mysqli_query($con,"select * from class where class_name='$clsname'");

		$rcls=mysqli_fetch_array($qcls);

		$clsid=$rcls['class_id'];
    }else{
    	$clsid='';
    }

	
	$secname=mysqli_real_escape_string($con,$data[3]);
	if(!empty($secname) && !empty($clsid)){
	$qsec=mysqli_query($con,"select * from section where section_name='$secname' and class_id='$clsid'");

	$rsec=mysqli_fetch_array($qsec);

	$secid=$rsec['section_id'];
    }else{
    	$secid='';
    }

	

	$fromdt=date("Y-m-d",strtotime(str_replace('/','-',$data[4])));

	$todt=date("Y-m-d", strtotime(str_replace('/','-',$data[5])));

	

	$eventname=mysqli_real_escape_string($con,$data[6]);
	if(!empty($eventname)){
		$eventname=strtoupper($eventname);
	$qeve=mysqli_query($con,"select * from event_type where upper(event_name)='$eventname'");

	$reve=mysqli_fetch_array($qeve);

	$eventid=$reve['event_id'];
	}else{
		$eventid='';
	}

	$day=mysqli_real_escape_string($con,$data[7]);
	$head=mysqli_real_escape_string($con,$data[8]);
	$desc=mysqli_real_escape_string($con,$data[9]);

	// if($headerLine) { $headerLine = false; }
	// echo "<br>id".$creationdate;
	if($clsid=="" || $secid=="" || $creationdate=='' ||  $creationdate=='1970-01-01' ||  $fromdt=='1970-01-01' || $fromdt=='' || $eventid=='' || $todt=='' || $todt=='1970-01-01' ){
		$not_upload[]=$sr_no;
		$error+=1;
		// echo "empty";
		continue;

	}else{

		$import=mysqli_query($con,"insert into events (class_id,section_id,creation_date,from_date,to_date,event_for,no_of_days,event_heading,description,status,session,create_date,modify_date)
		VALUES('$clsid','$secid','$creationdate','$fromdt','$todt','$eventid','$day','$head','$desc','0','".$_SESSION['session']."',now(),now())");
		if($import){
			$success_upload[]=$sr_no;
			$count+=1;
		}else{

			$false_query+=1;
		    $not_upload[]=$sr_no;
		}
			 
						// if(mysqli_error($con)){
						// echo("Error description: " . mysqli_error($con));
						// }
							

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
			   		<h4>('.$count.') Events uploaded successfully. This Sr no. not uploaded ('.$err_regisno.') please check the given data. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';
				}elseif($count > 0){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Events uploaded successfully. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}
 

	// echo "<script>window.location='dashboard.php?option=view_event_calendar'</script>";

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

                                <strong class="card-title"><a href="csv/upload_event_calendars.csv" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> Download Format</a><br/><br/></strong>

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

				<label>Upload Students</label>

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

