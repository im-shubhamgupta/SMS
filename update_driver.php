<?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$did=$_REQUEST['did'];

	$sql=mysqli_query($con,"select * from driver where id='$did'");

	$res=mysqli_fetch_array($sql);
	date_default_timezone_set('Asia/Kolkata');
	$modify_date=date('Y-m-d H:i:s');
	

	// if(isset($update))

	// {
	// 	$name=ucwords($name);
	// 	$query=mysqli_query($con,"update driver set name='$name', father_name='$fathername', gender='$gender', mobile='$mobno', 

	// 	alternate_no='$altmobno', address='$address', city='$city', designation='$designation', experience='$experience',

	// 	dlno='$dlno', aadhar_no='$aadharno', previous_exp='$preexp', description='$description', status='$status', modify_date='$modify_date' where id='$did'");	

	// 	if($query){	

	//         $messagetype="Update_driver";
  	// 	    $sset=mysqli_query($con,"select * from setting");
	// 		$rsset=mysqli_fetch_array($sset);

	// 		$sclname=$rsset['company_name'];
	// 		$set=mysqli_query($con,"select * from sms_setting where sms_id=2 ");

	// 		$rset=mysqli_fetch_array($set);

	// 		$wstatus=$rset['status'];
	// 			$msg="Dear ".$name.",%0aYour profile updated sucessfully.%0aRegards%0a".$sclname."  ";		
	// 			$nmsg="Dear ".$name.",<br>Your profile updated sucessfully.<br>Regards<br>".$sclname."  ";		

	// 		if($wstatus==1){
	// 				sendwhatsappMessage($mobno, $msg, $messagetype);
	// 		}else{
	// 				sendtextMessage($mobno, $nmsg, $messagetype);

	// 		}

	// 	    echo "<script>window.location='dashboard.php?option=view_driver'</script>";	

	// 	}else{
	// 		$err="<span id='err_successful' style='color:red;'>[ Something Wrong Please Try Again ]</span>";
	// 	}

	// }	

?>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>



<div class="card">

<form method="post">

	<div class="card-header">

		<strong>Update</strong> Driver Details

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:700px;">

		

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="name" pattern="[a-z A-Z]*" class="form-control" placeholder="Enter Name" value="<?php echo $res['name'];?>" required>
			<input type="hidden" name="did"  value="<?php echo $did;?>" >

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Father Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="fathername" pattern="[a-z A-Z]*" class="form-control" placeholder="Enter Father Name" value="<?php echo $res['father_name'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>

			<input type="radio" name="gender" value="MALE" <?php if($res['gender']=="Male"){echo "checked";}?>>&nbsp;MALE &nbsp;

			<input type="radio" name="gender" value="FEMALE" <?php if($res['gender']=="Female"){echo "checked";}?>>&nbsp;FEMALE

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="mobno" name="mobno" class="form-control" placeholder="Enter Mobile No" value="<?php echo $res['mobile'];?>" required>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Alternate Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="altmobno" name="altmobno" class="form-control" placeholder="Enter Alternate Mobile No" value="<?php echo $res['alternate_no'];?>" required>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="address" placeholder="Enter Address" required><?php echo $res['address'];?></textarea>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">City <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="city" class="form-control" placeholder="Enter City" value="<?php echo $res['city'];?>" required>	

			</div>

			</div>

			

			

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Designation <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="designation" id="teachtype" required selected="selected">

				<option value="">Select Teaching Type</option>

				<option value="Driver" <?php if($res['designation']=="Driver"){echo "selected";}?>>Driver</option>

				<option value="Cleaner" <?php if($res['designation']=="Cleaner"){echo "selected";}?>>Cleaner</option>

				<option value="Others" <?php if($res['designation']=="Others"){echo "selected";}?>>Others</option>

			</select>

			</div>

			</div>

											

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" name="experience" class="form-control" placeholder="Enter Experience" value="<?php echo $res['experience'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">DL Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="dlno" class="form-control" placeholder="Enter DL Number" value="<?php echo $res['dlno'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Aadhar No </label>

			<input type="text" class="form-control" id="aadharno" name="aadharno" placeholder="Enter Aadhar No" value="<?php echo $res['aadhar_no'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Previous Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="preexp" class="form-control" placeholder="Enter Previous Experience" value="<?php echo $res['previous_exp'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Him/Her <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="description" placeholder="Enter Description" required><?php echo $res['description'];?> </textarea>

			</div>

			</div>	
			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Status <span style="color:red;font-weight:bold;">*</span></label>
			<select name="status" class="form-control" required>
				<option value='0' <?php if( $res['status']==0)echo 'selected';?> >Active</option>
				<option value='1'  <?php if( $res['status']==1)echo 'selected';?>>Deactive</option>
			</select>
			
			

			</div>

			</div>	

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update_driver" id="update_driver" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_driver" class="btn btn-info btn-sm">

		<i class='fa fa-arrow-left'> </i> Back</a>

		

	</div>

	</form>

</div>



<script>

$("#mobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#altmobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#aadharno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12	) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = $("#update_driver").attr("name");

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#update_driver").text("Sending, please wait...");  
	$("#update_driver").attr("disabled", true);
	$.ajax({
		url:"AjaxHandler.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.type=="SUCCESS"){
				// alert('success');
				toastr.success(result.message); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_driver';
				},3000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("#update_driver").text("Update ");  
	      $("#update_driver").attr("disabled", false);

			}
		}
	})
});

});

</script>

