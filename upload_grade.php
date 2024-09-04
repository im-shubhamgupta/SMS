<?php 

include('connection.php');

extract($_REQUEST);?>

<div id="right-panel"  style="width:100%">

         

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Import CSV Grade</span>

</nav>



<?php
if (isset($_POST['upload'])) 

{

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

if(!$_FILES['csvfile']['name'] == ""){ 

if($ext == "csv"){

 

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


while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	

	$grade_name=mysqli_real_escape_string($con,trim($data[0]));			
	$condition1=mysqli_real_escape_string($con,trim($data[1]));			
	$condition2=mysqli_real_escape_string($con,trim($data[2]));			
	$colors=mysqli_real_escape_string($con,trim($data[3]));			

	// if($headerLine) { $headerLine = false; }

	    $csql="SELECT * FROM `grade` WHERE `grade_name` = '".$grade_name."' ";
		$CheckQuery = $con->query($csql);

		if($grade_name=="" || empty($condition1) || empty($condition2) ){
			$not_upload[]=$grade_name;
		    $error+=1;
			continue;

		}elseif($CheckQuery->num_rows > 0){
			$already[]=$grade_name;
		    $error+=1;
			continue;

		}else{	
			$import=mysqli_query($con,"INSERT INTO grade(grade_name,condition1,condition2,colors,create_date,modify_date) VALUES('$grade_name','$condition1','$condition2','$colors',now(),now())");
			if(mysqli_error($con)){
				echo('Error description: ' .mysqli_error($con));
			}	

			if($import){
				$success_upload[]=$grade_name;
				$count+=1;

			}else{
				$false_query+=1;
			    $not_upload[]=$grade_name;
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
   		<h4>('.$count.') Grade uploaded successfully. This Grade has not been Uploaded ('.$err_already.' ) due to  already exist  & This  Grade has not been Uploaded ( '.$err_regisno.' ) can,t empty Grade, Min, Max. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Grade uploaded  successfully. This Grade has not uploaded ('.$err_already.') due to  already exist. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Grade uploaded successfully. This Grade not Updated ('.$err_regisno.')  can,t empty Grade, Min, Max. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count =='1'){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') All Grade uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif($count > '0'){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') All Grades uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}



 

	// echo "<script>window.location='dashboard.php?option=view_grade'</script>";

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

                                <strong class="card-title"><a href="csv/upload_grade.csv" class="btn btn-primary btn-sm">

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

			<div class="col-md-5">

				<div class="panel-body">

				<label>Upload Grade</label>

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

