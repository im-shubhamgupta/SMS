<?php 

include('connection.php');

extract($_REQUEST);?>
<div id="right-panel"  >

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <span class="breadcrumb-item active">Import CSV Partial Staff Detail</span>

</nav>
<?php

if (isset($_POST['upload'])){

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

if(!$_FILES['csvfile']['name'] == "")
{ 

if($ext == "csv"){

 

 if(file_exists($base_name)){

      echo "file already exist" . $base_name;
                                               

}else{
    

if(is_uploaded_file($_FILES['csvfile']['tmp_name'])){

	// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
	// readfile($_FILES['csvfile']['tmp_name']);
}

    $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
	$headerLine = true;
	fgetcsv($handle, 1000, ",");

	$count=0;
	$wrong_id=array();
	$not_upload=array();
	$success_upload=array();
	$error=0;
	$false_query=0;		

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
// echo "hello4885";
	$check_staffid=false;
	$staffname = $con->real_escape_string($data[0]);
	$staffname = trim($staffname," ");
	if(!empty($staffname)){
		$staffname=$staffname;
	}else{
		$staffname = '';
	}

	$staffid = $con->real_escape_string(trim($data[1]));
	/*$staffid = trim($staffid," ");
	if(!empty($staffid)){
		$CheckQuery = $con->query("SELECT `staff_id` FROM `staff` WHERE `staff_id` = '".$staffid."' ");
		if($CheckQuery->num_rows > 0){
			$verified_staffid =$staffid;
			$check_staffid=true;
		}else{
			$verified_staffid ='';
			$check_staffid=false;
		}
	}else{
		$staffid = '';
	}*/
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
	$gender = $con->real_escape_string($data[2]);
	$gender = trim($gender," ");
	if(!empty($gender)){
		$gender=$gender;
	}else{
		$gender = '';
	}
	$mobno = $con->real_escape_string($data[3]);
	$mobno = trim($mobno," ");
	if(!empty($mobno)){
		$mobno=$mobno;
	}else{
		$mobno = '';
	}
	// echo "<br>mobno : ".$mobno;
	$altmobno = $con->real_escape_string($data[4]);
	$altmobno = trim($altmobno," ");
	if(!empty($altmobno)){
		$altmobno=$altmobno;
	}else{
		$altmobno = '';
	}

	$address = $con->real_escape_string($data[5]);
	if(!empty($address)){
		$address=$address;
	}else{
		$address = '';
	}

	$qualification = $con->real_escape_string($data[6]);
	if(!empty($qualification)){
		$qualification=$qualification;
	}else{
		$qualification = '';
	}


	$teachingtype = $con->real_escape_string($data[7]);
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
	// echo "teacheing type:".$teachingtype;

	$teachingtypeother = $con->real_escape_string($data[8]);
	$teachingtypeother = trim($teachingtypeother," ");
	if(!empty($teachingtypeother)){
		$teachingtypeother=$teachingtypeother;
	}else{
		$teachingtypeother = 'N/A';
	}

	$skill = $con->real_escape_string($data[9]);
	if(!empty($skill)){
		$skill=$skill;
	}else{
		$skill = '';
	}

	$joindate=date("Y-m-d", strtotime(str_replace('/','-',$data[10])));
	$designation = $con->real_escape_string($data[11]);
	if(!empty($designation)){
		$designation=$designation;
	}else{
		$designation = '';
	}

	$msgtype = $con->real_escape_string(trim($data[12]));

	$msgtype = trim($msgtype," ");
	$qmsg=mysqli_query($con,"select * from message_type where msg_name='$msgtype'");
	if(mysqli_num_rows($qmsg) > 0){
		$rmsg=mysqli_fetch_array($qmsg);
		$msgtypeid=$rmsg['msg_type_id'];
	}else{
		$msgtypeid ='';
		$msgtype='';
	}

	

	$aadharno = $con->real_escape_string($data[13]);
	if(!empty($aadharno)){
		$aadharno = $aadharno;
	}else{
		$aadharno ='';
	}

	$caste = $con->real_escape_string($data[14]);
	if(!empty($caste)){
		$caste = $caste;
	}else{
		$caste ='';
	}

	// echo $check_staffid;
	if(!$check_staffid){
		// echo "<br>check staffid";
		$wrong_id[]=$staffid;
		$error+=1;
		continue;
	}elseif(empty($staffid) || empty($staffname) ||  empty($joindate) ||  $joindate=='1970-01-01'  || empty($teachingtype)   || empty($msgtypeid) || empty($verified_staffid)){
		// echo "not data".$staffid; 
		$not_upload[]=$staffid;
		$error+=1;
		continue;

	}else{
		$create_date=date('Y-m-d H:i:s');
		$modify_date=$create_date;
		$usql="UPDATE `staff` SET `staff_name`='$staffname',`gender`='$gender',`mobno`='$mobno',`alt_mobno`='$altmobno',`address`='$address',`qualification`='$qualification',`teaching_type`='$teachingtype',`teaching_type_other`='$teachingtypeother',`skills`='$skill',`joining_date`='$joindate',`designation`='$designation',`msg_type_id`='$msgtypeid',`aadharno`='$aadharno',`caste`='$caste',`modify_date`='$modify_date' WHERE `st_id`='".$verified_staffid."' ";
		$import=mysqli_query($con,$usql);

		// 	"update staff set staff_name='$data[0]',gender='$data[2]',mobno='$data[3]',alt_mobno='$data[4]',/ address='$data[5]',qualification='$data[6]',teaching_type='$data[7]',teaching_type_other='$data[8]',skills='$data[9]', joining_date='$joindate',designation='$data[11]',msg_type_id='$msgtypeid',aadharno='$data[13]',caste='$data[14]' where staff_id='$data[1]'");

		if($import){

			$action = "Staff CSV Imported - update partial details "; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,	machine_name,browser,date,session)values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$create_date','".$_SESSION['session']."')");

			$success_upload[]=$verified_staffid;
			$count+=1;
		 }else{
		 	$false_query+=1;
			$not_upload[]=$staffid;

		 }

	}//else

}//while

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
   		<h4>('.$count.') Staff Updated successfully. This Staff id has not been Updated ('.$err_already.' )due to staffid not matched & This Staff id has not been Updated ( '.$err_regisno.' ) please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_already)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff Updated successfully. This Staff id not uploaded ('.$err_already.') due to staffid not matched </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}elseif(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff Updated successfully. This Staff id not Updated ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Staff Updated successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';

	}

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

                                <strong class="card-title">

								<a href="export_viewstaff_excel.php" class="btn btn-primary btn-sm"> 

								<i class="fa fa-download"></i> Download Staff Detail</a>

								<br /><br />

								</strong>

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
								<li>Staff id can't be update</li>
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

