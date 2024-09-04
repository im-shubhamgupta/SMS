<?php 

include('connection.php');

// extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

         

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Import CSV Marks</span>

</nav>
<?php

if (isset($_POST['upload'])){
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

	$option=$_POST['option'];
	$class=$_POST['class'];
	$section=$_POST['section'];
	$test=$_POST['test'];
	$subject=$_POST['subject'];


	$q1 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$subject' and session='".$_SESSION['session']."'");

	$row = mysqli_num_rows($q1);

	

	$c1=mysqli_query($con,"select * from class where class_id='$class'");

	$rc1=mysqli_fetch_array($c1);

	$cname=$rc1['class_name'];

	

	$s1=mysqli_query($con,"select * from section where section_id='$section'");

	$rs1=mysqli_fetch_array($s1);

	$sname=$rs1['section_name'];

	

	$su1=mysqli_query($con,"select * from subject where subject_id='$subject'");

	$rsu1=mysqli_fetch_array($su1);

	$suname=$rsu1['subject_name'];

	

	if($row){

		echo "<script>alert('Marks Already Uploaded');</script>";

	}else{

				

	$csvfile = $_FILES['csvfile']['name'];

	$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

	$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



	if(!$_FILES['csvfile']['name'] == "")   

	{ 

		

	if($_FILES['csvfile']['name'] == $cname.'_'.$sname.'_'.$test.'_'.$suname.'.csv') 

	{

			

	if($ext == "csv")

	{

		

	 if(file_exists($base_name)){

		  echo "file already exist" . $base_name;

													  

	}else{

			

	if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){

		

		// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

	 

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
				

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	

		$clsname=mysqli_real_escape_string($con,trim($data[0]));
		if(!empty($clsname)){
			$qcls=mysqli_query($con,"select * from class where class_name='$clsname'");

			$rcls=mysqli_fetch_array($qcls);

			$clsid=$rcls['class_id'];
		}else{
			$clsid='';

		}


		$secname=mysqli_real_escape_string($con,trim($data[1]));
		if(!empty($secname) && !empty($clsid)){
			$qsec=mysqli_query($con,"select * from section where section_name='$secname' and class_id='$clsid'");

			$rsec=mysqli_fetch_array($qsec);

			$secid=$rsec['section_id'];
		}else{
			$secid='';	
		}	
		

		$regno=mysqli_real_escape_string($con,trim($data[2]));
		if(!empty($regno)){
			// $q2 = mysqli_query($con,"select * from students where register_no='$regno' and session='".$_SESSION['session']."'");
			$q2 = mysqli_query($con,"select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.register_no='$regno' && sr.session='".$_SESSION['session']."' ");
			$r2 = mysqli_fetch_array($q2);

			$stuid = $r2['student_id'];
		}else{
			$stuid = '';
		}	

		$subject_m=mysqli_real_escape_string($con,trim($data[4]));
		if(is_numeric($subject_m)){
			$subject_marks=$subject_m;
		}else{
			$subject_marks='';
		}
		
		

		$q1 = mysqli_query($con,"select max_marks from test where test_name='$test' and class_id='$clsid' and section_id='$secid' and subject_id='$subject' and session='".$_SESSION['session']."'");

		$r1 = mysqli_fetch_array($q1);

		$maxmark = $r1['max_marks'];

			

		// if($headerLine) { $headerLine = false; }

		// echo $subject_marks;
		if(empty($clsid) || empty($secid) || empty($subject) || empty($test) || empty($stuid) || empty($maxmark) || empty($subject_marks) ){
			// echo 'empty_ ';
			$not_upload[]=$regno;
		    $error+=1;
			continue;

		}else{

			$import=mysqli_query($con,"INSERT INTO marks(class_id,section_id,subject_id,test_name,student_id,marks,max_mark,date,modify_date,session)
			VALUES('$clsid','$secid','$subject','$test','$stuid','$subject_marks','$maxmark',now(),now(),'".$_SESSION['session']."')");	

			if($import){
				$success_upload[]=$regno;
				$count+=1;

			}else{
				$false_query+=1;
			    $not_upload[]=$regno;
			}			

		}
	}//while


	
	foreach($not_upload as $k => $v){
		if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}	
	$err_regisno=implode(', ', $not_upload);
	// $err_already=implode(', ', $already);

	if(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Marks uploaded successfully. This Register no marks  ('.$err_regisno.') not uploaded. </h4>  
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > '0'){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Marks uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}



		// echo "<script>window.location='dashboard.php?option=upload_marks'</script>";

	}

			

	}else{
	echo " Check Extension. your extension is ." . $ext;
	}

	

	}else{

		echo "<script>alert('Please upload a proper file.')</script>";

	}

	

	}else{
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	   		<h4>Please Upload File</h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}

	}//marks already

}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	





        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">Upload Marks<br/></strong>

                            </div>

							<form method="post" enctype="multipart/form-data">

										

                            <div class="card-body">

                                

							<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px">Class</div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" autofocus required>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = "select * from class";

							$rcls = mysqli_query($con, $scls);

							while( $rescls = mysqli_fetch_array($rcls) ) {

							?>

							<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>					

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>

							

							<div class="col-md-2" style="margin-left:20px">Section </div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select class="form-control" name="section" id="search_sect" style="width:150px;" onchange="searchtest(this.value)" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

							<?php

							$qsec=mysqli_query($con,"select * from section where class_id='$class'");

							while($rsec=mysqli_fetch_array($qsec))

							{

							$secname=$rsec['section_name'];

							?>

							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							</option>

							<?php 

							}

							?>							

							</select>	

							</div>

							<script>

							function searchtest(str)

							{

							var clsid = $('#class').val();

							//alert(clsid);

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_test").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>	

							</div><br>	

								

							<div class="row" style="margin-top:20px;">		

							<div class="col-md-2" style="margin-left:20px">Test Name </div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select class="form-control" name="test" id="search_test" onchange="searchsub(this.value)"

							autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							<?php

							$quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");

							while( $rtest= mysqli_fetch_array($quet) ) {

							?>

							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>



							<script>

							function searchsub(str)

							{

							var clsid = $('#class').val();

							var secid = $('#search_sect').val();

							//alert(secid);

							var xmlhttp = new XMLHttpRequest();

							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200 && xmlhttp.readyState==4)

							{

							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	

							}									

							}

							}

							</script>

							

							<div class="col-md-2" style="margin-left:20px;">Subject </div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">

							<select class="form-control" name="subject" id="search_sub" style="width:150px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Subject</option>

							<?php

							$qsub = mysqli_query($con,"select test.subject_id, subject.subject_name from test INNER JOIN subject ON test.subject_id = subject.subject_id where test.class_id='$class' && test.section_id='$section' && test.test_name='$test'");

							while( $rsub= mysqli_fetch_array($qsub) ) {

							?>

							<option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>

							</div>	

							

<br/>							

								

							<div class="row">

								<div class="col-md-12">

									<div class="panel-group">

									<div class="panel panel-default">

											

										<?php echo @$err; ?>	



									<div class="row">

										<div class="col-md-5" style="margin-left:20px">

											<div class="panel-body">

											<label>Upload Marks</label>

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
                        <div >

						    <strong ><h5>Instructions for uploading Csv file:-</h5></strong>
							<span>
							
							<ol style="margin-left:20px;margin-top:10px;">
								
								<li>At first Download the CSV format of particular subject. <a href='dashboard.php?option=create_download_format'><u>Click Here</u></a></li>
								<!-- <li>Choose the same.</li> -->
							</ol>
						    </span>

						</div>

                    </div>

                </div>

			</div><!-- .animated -->

        </div><!-- .content -->

</div><!-- /#right-panel -->

