<?php 

include('connection.php');

extract($_REQUEST);?>
<!-- style="width:1000px" -->
<div id="right-panel"  >
<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <span class="breadcrumb-item active">Import CSV Staff</span>

</nav>
<?php

if (isset($_POST['upload'])) 

{

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



if(!$_FILES['csvfile']['name'] == "")   

{ 

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

	$count=0;
	$already=array();
	$not_upload=array();
	$success_upload=array();
	$error=0;
	$false_query=0;

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){				

	

	$staffname = $con->real_escape_string($data[0]);
	$staffname = trim($staffname," ");
	if(!empty($staffname)){
		$staffname=$staffname;
	}else{
		$staffname = '';
	}

	$staffid = $con->real_escape_string($data[1]);
	$staffid = trim($staffid," ");
	if(!empty($staffid)){
		$staffid=$staffid;
	}else{
		$staffid = '';
	}

	$gender = $con->real_escape_string($data[2]);
	$gender = trim($gender," ");
	if(!empty($gender)){
		$gender=$gender;
	}else{
		$gender = '';
	}

	$address = $con->real_escape_string($data[3]);
	if(!empty($address)){
		$address=$address;
	}else{
		$address = '';
	}

	$mobno = $con->real_escape_string($data[4]);
	$mobno = trim($mobno," ");
	if(!empty($mobno)){
		$mobno=$mobno;
	}else{
		$mobno = '';
	}

	$password = $con->real_escape_string($data[5]);
	$password = trim($password," ");
	if(!empty($password)){
		$password=$password;
	}else{
		$password = '';
	}

	$altmobno = $con->real_escape_string($data[6]);
	$altmobno = trim($altmobno," ");
	if(!empty($altmobno)){
		$altmobno=$altmobno;
	}else{
		$altmobno = '';
	}

	$qualification = $con->real_escape_string($data[7]);
	if(!empty($qualification)){
		$qualification=$qualification;
	}else{
		$qualification = '';
	}

	$teachingtype = $con->real_escape_string($data[8]);
	$teachingtype = trim($teachingtype," ");

	if(!empty($teachingtype)){
		// $teachingtype=$teachingtype;
		if($teachingtype=='Teaching'){
			$teachingtype='Teaching';
		}elseif($teachingtype=='Non-Teaching'){
			$teachingtype='Non-Teaching';
		}elseif($teachingtype=='Others'){
			$teachingtype='Others';
		}else{
			$teachingtype='';
		}
	}else{
		$teachingtype = '';
	}

	$teachingtypeother = $con->real_escape_string($data[9]);
	$teachingtypeother = trim($teachingtypeother," ");
	if(!empty($teachingtypeother)){
		$teachingtypeother=$teachingtypeother;
	}else{
		$teachingtypeother = 'N/A';
	}

	$skill = $con->real_escape_string($data[10]);
	if(!empty($skill)){
		$skill=$skill;
	}else{
		$skill = '';
	}

	$joindate=date("Y-m-d", strtotime(str_replace('/','-',$data[11])));

	$designation = $con->real_escape_string($data[12]);
	if(!empty($designation)){
		$designation=$designation;
	}else{
		$designation = '';
	}

	$msgtype = $con->real_escape_string(trim($data[13]));

	$msgtype = trim($msgtype," ");
	$qmsg=mysqli_query($con,"select * from message_type where msg_name='$msgtype'");
	if(mysqli_num_rows($qmsg) > 0){
		$rmsg=mysqli_fetch_array($qmsg);
		$msgtypeid=$rmsg['msg_type_id'];
	}else{
		$msgtypeid ='';
		$msgtype='';
	}

	

	$aadharno = $con->real_escape_string($data[14]);
	if(!empty($aadharno)){
		$aadharno = $aadharno;
	}else{
		$aadharno ='';
	}

	

	$caste = $con->real_escape_string($data[15]);
	if(!empty($caste)){
		$caste = $caste;
	}else{
		$caste ='';
	}

	$status = '1' ;

	$CheckQuery = $con->query("SELECT `staff_id` FROM `staff` WHERE `staff_id` = '".$staffid."' ");
	// echo $teachingtype; die;
	if(empty($staffid) || empty($staffname) ||  empty($joindate) ||  $joindate=='1970-01-01'  || empty($teachingtype) || empty($msgtypeid) ){
		$not_upload[]=$staffid;
		$error+=1;
		continue;

	}else if($CheckQuery->num_rows > 0){
		$already[]=$staffid;
		$error+=1;
		continue;

	}else{
		$create_date=date('Y-m-d H:i:s');
		$modify_date=$create_date;

		$import = $con->query("INSERT INTO `staff`(`staff_name`, `staff_id`, `gender`, `mobno`, `password`, `alt_mobno`, `address`, `qualification`, `teaching_type`, `teaching_type_other`, `skills`, `joining_date`, `designation`, `msg_type_id`, `aadharno`, `caste`, `status`,`create_date`,`modify_date`,`session`) VALUES ('".$staffname."', '".$staffid."', '".$gender."', '".$mobno."', '".$password."', '".$altmobno."', '".$address."', '".$qualification."', '".$teachingtype."', '".$teachingtypeother."', '".$skill."', '".$joindate."', '".$designation."', '".$msgtypeid."', '".$aadharno."', '".$caste."', '".$status."','".$create_date."','".$modify_date."','".$_SESSION['session']."' )");

		if(mysqli_error($con)){
			echo("Error description1: " . mysqli_error($con));
		}
		if($import){

			$success_upload[]=$staffid;
			$count+=1;

			$action = "Staff CSV Imported"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,	machine_name,browser,date,session)	values ('".$roles."', '".$panelid."', '".$menuid."', '".$submenuname."', '".$action."', '".$machinename."', '".$ExactBrowserNameBR."',now(),'".$_SESSION['session']."')");

			// if(mysqli_error($con)){
			// 	echo("Error description2: ". mysqli_error($con));
			// }
		}else{
			$false_query+=1;
			$not_upload[]=$staffid;
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
	$err_regisno=implode(', ', $not_upload);
	$err_already=implode(', ', $already);

	if(!empty($err_already) && !empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff uploaded successfully. This Staff id has not been uploaded ('.$err_already.' )due to already exist & This Staff id has not been uploaded ( '.$err_regisno.' ) please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff uploaded successfully. This Staff id not uploaded ('.$err_already.') due to already exist. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff uploaded successfully. This Staff id not uploaded ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}	
	// echo "<script>window.location='dashboard.php?option=view_staff&smid=18'</script>";
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

                                <strong class="card-title"><a href="csv/upload_staff.csv" class="btn btn-primary btn-sm"> 

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

				<label>Upload Staff</label>

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
                        <div >

						    <strong ><h5>Instructions for uploading Csv file:-</h5></strong>
							<span>
							
							<ol style="margin-left:20px">
								<li>Staff id must be unique of each Staff.</li>
								<li>Date of joining date format : (DD-MM-YYYY)</li>
								<li>Message type,Teaching Type  must be match from our given CSV Format.</li>
							</ol>
						    </span>

						</div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

