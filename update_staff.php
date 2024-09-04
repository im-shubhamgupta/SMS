<?php

extract($_REQUEST);


$stid=$_REQUEST['id'];



$query=mysqli_query($con,"select * from staff where st_id='$stid'");

$res=mysqli_fetch_array($query);

$gen=$res['gender'];

$teachtype=$res['teaching_type'];

$msgid=$res['msg_type_id'];

$img=$res['image'];

$staffid=$res['staff_id'];



// if(isset($update))

// {

// 	if($nteachtype=="Others")

// 	{

// 		$query="update staff set staff_name='$nname',gender='$ngender',

// 		mobno='$nmobno',password='$npassword',alt_mobno='$naltmobno',address='$naddress',qualification='$nqualification',

// 		skills='$nskills',teaching_type='$nteachtype',teaching_type_other='$nothers',joining_date='$njoindate',

// 		designation='$ndesignation',msg_type_id='$msg_type',aadharno='$naadharno',caste='$ncaste' where st_id='$stid'";

		

// 	}		

// 	else

// 	{

// 		$query="update staff set staff_name='$nname',gender='$ngender',

// 		mobno='$nmobno',password='$npassword',alt_mobno='$naltmobno',address='$naddress',qualification='$nqualification',

// 		skills='$nskills',teaching_type='$nteachtype',teaching_type_other='',joining_date='$njoindate',

// 		designation='$ndesignation',msg_type_id='$msg_type',aadharno='$naadharno',caste='$ncaste' where st_id='$stid'";

		

			

// 	}

	

// 		if(mysqli_query($con,$query))

// 		{

// 			$action = "Staff ".$nname." Details is edited"; 

// 			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

// 			machine_name,browser,date) 

// 			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 		}

		

// 		echo "<script>window.location='dashboard.php?option=view_staff&smid=15'</script>";	

// }



?>



<div class="card">



<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

	

		<strong>Update</strong> Staff

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:750px;">

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="nname" pattern="[a-z A-Z]*" class="form-control" value="<?php echo $res['staff_name'];?>" placeholder="Enter Name" required>
			<input type="hidden" name="stid" value="<?php echo $stid;?>" >
			<!-- activity history -->
			<input type="hidden" name="roles" value="<?php echo $roles;?>" >
			<input type="hidden" name="panelid" value="<?php echo $panelid;?>" >
			<input type="hidden" name="menuid" value="<?php echo $menuid;?>" >
			<input type="hidden" name="submenuname" value="<?php echo $submenuname;?>" >
			<input type="hidden" name="machinename" value="<?php echo $machinename;?>" >
			<input type="hidden" name="ExactBrowserNameBR" value="<?php echo $ExactBrowserNameBR;?>" >
			<input type="hidden" name="currdt" value="<?php echo $currdt;?>" >
			

			<!-- //activity history -->

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Staff ID <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" onchange="chkstafid()" name="nstaffid" id="staffid" class="form-control" 

			value="<?php echo $staffid;?>" placeholder="Enter Staff Id" autocomplete="off" readonly><span id="res1" ></span>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>

			<input type="radio" name="ngender" <?php if($gen=="MALE"){echo "checked";}?> value="MALE" checked>&nbsp;MALE &nbsp;

			<input type="radio" name="ngender" <?php if($gen=="FEMALE"){echo "checked";}?> value="FEMALE">&nbsp;FEMALE

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="naddress" placeholder="Enter Address" required><?php echo $res['address'];?> </textarea>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="mobno" name="nmobno" class="form-control mobile" value="<?php echo $res['mobno'];?>" 

			placeholder="Enter Mobile No" required><span class="mobile_error"></span>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Password <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" id="password" name="npassword" class="form-control" value="<?php echo $res['password'];?>" required><span id="wm2"></span>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Alternate Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="altmobno" name="naltmobno" class="form-control mobile" value="<?php echo $res['alt_mobno'];?>" placeholder="Enter Alternate Number" required><span class="mobile_error"></span>

			</div>

			</div>

						

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Qualification <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="nqualification" value="<?php echo $res['qualification'];?>" 

			placeholder="Enter Qualification" required>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Skills <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="nskills" value="<?php echo $res['skills'];?>" required>

			</div>

			</div>

			

			<script>

			$(document).ready(function(){		

			$("#teachtype").change(function(){

			var ttype=document.getElementById("teachtype").value;

			//alert (ntotalpaid);

			if(ttype!="Others")

			{

				//alert("Paid amount should not be greater than amount to pay");

				document.getElementById("others").disabled = true;

				document.getElementById("others").value = "";

			}

			else

			{

				document.getElementById("others").disabled = false;

				//document.getElementById("others").required = true;

			}

			});

			});

			</script>

			

			

			<?php

			if($teachtype=="Others")	

			{

			?>

			<div class="col-md-6">	

			<div class="form-group">

				<div class="row">

				<div class="col-md-6">

				<label class=" form-control-label">Teaching Type <span style="color:red;font-weight:bold;">*</span></label>

				<select class="form-control" name="nteachtype" id="teachtype">

				<option <?php if($teachtype=="Teaching"){echo "selected";}?> value="Teaching">Teaching</option>

				<option <?php if($teachtype=="Non-Teaching"){echo "selected";}?> value="Non-Teaching">Non-Teaching</option>

				<option <?php if($teachtype=="Others"){echo "selected";}?> value="Others">Others</option>

				</select>

				</div>

				<div class="col-md-6">

				<label class=" form-control-label"></label>

				<input class="form-control" type="text" name="nothers" id="others" value="<?php echo $res['teaching_type_other'];?>" style="margin-top:9px;">

				</div>

				</div>

			</div>

			</div>

			<?php

			}

			else

			{

			?>

			<div class="col-md-6">	

			<div class="form-group">

				<div class="row">

				<div class="col-md-6">

				<label class=" form-control-label">Teaching Type <span style="color:red;font-weight:bold;">*</span></label>

				<select class="form-control" name="nteachtype" id="teachtype">

				<option <?php if($teachtype=="Teaching"){echo "selected";}?> value="Teaching">Teaching</option>

				<option <?php if($teachtype=="Non-Teaching"){echo "selected";}?> value="Non-Teaching">Non-Teaching</option>

				<option <?php if($teachtype=="Others"){echo "selected";}?> value="Others">Others</option>

				</select>

				</div>

				<div class="col-md-6">

				<label class=" form-control-label"></label>

				<input class="form-control" type="text" name="nothers" id="others" value="<?php echo $res['teaching_type_other'];?>" disabled style="margin-top:9px;">

				</div>

				</div>

			</div>

			</div>

			<?php	

			}

			?>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Date of Joining <span style="color:red;font-weight:bold;">*</span></label>

			<input type="date" class="form-control" name="njoindate" value="<?php echo $res['joining_date'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Designation <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="ndesignation" value="<?php echo $res['designation'];?>" 

			placeholder="Enter Designation" required>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Message Type <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="msg_type" required>

			<?php

			$qmsg = mysqli_query($con,"select * from message_type");

			while($rmsg = mysqli_fetch_array($qmsg))

			{

			?>	

			<option <?php if($msgid==$rmsg['msg_type_id']){echo "selected";}?> value="<?php echo $rmsg['msg_type_id'];?>"><?php echo $rmsg['msg_name'];?></option>

			<?php

			}

			?>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Aadhar No <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" class="form-control aadhar" id="aadharno" name="naadharno" value="<?php echo $res['aadharno'];?>" placeholder="Enter Aadhar No" required><span class="aadhar_error"></span>

			</div>

			</div>

			</div>

			

			<div class="row">

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Caste </label>

			<input type="text" class="form-control" name="ncaste" value="<?php echo $res['caste'];?>" placeholder="Enter Caste">

			</div>

			</div>

			</div>

			

			<!--

			<div class="col-md-3">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Image Upload</label>

			<input type="file" name="file1" class="form-control">

			</div>

			</div>

			

			<div class="col-md-3">	

			<div class="form-group">

			<img src="staff/<?php echo $staffid;?>/<?php echo $img;?>" width='90px' height='90px' style="border-radius:50%; margin-left:25px;border:2px solid grey;"/>

			</div>

			</div>

				

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Resume Upload</label>

			<input type="file" name="file2" class="form-control">

			</div>

			</div>-->

		

	</div>

	

	<div class="card-footer">

		<button type="submit" name="update_staff" id="update_staff" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update Staff

		</button>

		<a href="dashboard.php?option=view_staff" class="btn btn-info btn-sm" style="margin-left:10px;">

		<i class='fa fa-arrow-left'> </i> Back</a>

	</div>
	</form>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){	
  toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					});

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = $("#update_staff").attr("name");
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#update_staff").text("Updating, please wait...");  
	$("#update_staff").attr("disabled", true);

	// alert(name);

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
				window.location.href='dashboard.php?option=view_staff&smid=15';
				},3000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("#update_staff").text("Update Staff");  
	            $("#update_staff").attr("disabled", false);

			}
			else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#update_staff").text("Update Staff");  
	            $("#update_staff").attr("disabled", false);

			}else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#update_staff").text("Update Staff");  
	            $("#update_staff").attr("disabled", false);
			}
		}
	})
});

});

</script>



