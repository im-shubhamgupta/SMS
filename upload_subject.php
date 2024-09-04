<?php 

include('connection.php');

extract($_REQUEST); ?>
<div id="right-panel"  style="width:100%">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a>

  <span class="breadcrumb-item active">Import CSV Subject</span>

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
	//echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

	

	// echo "<h1>" . " Uploaded Successfully " . "</h1>";

 

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

		$sr_no = $con->real_escape_string($data[0]);

		$clsname = $con->real_escape_string($data[1]);

		$clsname = trim($clsname," ");
		// echo "<br>class_name: ".$clsname;
		$qcls=mysqli_query($con,"select * from class where class_name Like '$clsname'");

		if(mysqli_num_rows($qcls) > 0){

			$rcls=mysqli_fetch_array($qcls);

			$clsid=$rcls['class_id'];

		}else{

			$clsid = '';
		}
		// echo "<br>class_id: ".$clsid;

		$subjectname = $con->real_escape_string($data[2]);

		$subjectname = trim($subjectname," ");

		if(!empty($subjectname)){

			$subjectname=$subjectname;

		}else{

			$subjectname = "";

		}

			
		$csql="SELECT * FROM `subject` WHERE `class_id` = '".$clsid."' && `subject_name` = '".$subjectname."' ";
		$CheckQuery = $con->query($csql);

	
		// echo '<br>clsid: '.$clsid;
		if($subjectname=="" || empty($clsid) ){
			// echo "empty"; die;
			$not_upload[]=$sr_no;
		    $error+=1;
			continue;

		}elseif($CheckQuery->num_rows > 0){
			$already[]=$sr_no;
			// $already_sub[]=$subjectname;
		    $error+=1;
			continue;

		}else{			
			$isql="insert into subject (subject_name,class_id,create_date,modify_date) VALUES('".$subjectname."', '".$clsid."',now(),now())";
			$import=$con->query($isql);

			if(mysqli_error($con)){
				echo('Error description: ' .mysqli_error($con));
			}
			if($import){
				$success_upload[]=$sr_no;
			    $count+=1;

			}else{
				$false_query+=1;
			    $not_upload[]=$sr_no;
			}
		

		}//else
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
	// 	echo "";
	// echo "<pre>";
	// print_r($already);	
	// echo "</pre>";	
	$err_regisno=implode(', ', $not_upload);
	$err_already=implode(', ', $already);

	if(!empty($err_already) && !empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject uploaded successfully. This Sr no. has not been Updated ('.$err_already.' ) due to subject is already exist  & This  Sr no. has not been Updated ( '.$err_regisno.' ) please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject uploaded  successfully. This  Sr no. not uploaded ('.$err_already.') due to subject is  already exist. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Subject uploaded successfully. This  Sr no. not Updated ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') All Subject uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}
 

	// echo "<script>window.location='dashboard.php?option=upload_subject'</script>";

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

                                <strong class="card-title"><a href="csv/upload_subjects.csv" class="btn btn-primary">

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
								
								<li>Class name  must be match from our given CSV Format.</li>
								<li>Subject should be unique of particular classes.</li>
							</ol>
						    </span>

						</div> -->

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

