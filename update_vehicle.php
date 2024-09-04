<?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$vid=$_REQUEST['vid'];

	$sql=mysqli_query($con,"select * from vehicle where vehicle_id='$vid'");

	$res=mysqli_fetch_array($sql);

	

	// if(isset($update))

	// {
	// 	date_default_timezone_set('Asia/Kolkata');
	// 	$modify_date=date('Y-m-d H:i:s');
	  


	// 	$uquery=mysqli_query($con,"update vehicle set vehicle_name='$name', vehicle_type='$vehicletype', vehicle_number='$vehicleno', 

	// 	chassis_no='$chassisno',purchased_year='$purchasedyear', vehicle_status='$vehicle_status', about_vehicle='$aboutvehicle', 

	// 	prev_exp='$preexp', description='$description', modify_date='$modify_date' where vehicle_id ='$vid'");		

	// 	if($uquery){
	// 	   echo "<script>window.location='dashboard.php?option=view_vehicle'</script>";	
	// 	}else{
	// 		$err="<span id='err_successful' style='color:red'>[ Something Wrong Please Try Again ]</span>";
	// 	}   
		

	// }	

	

?>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>



<div class="card">

<form method="post">

	<div class="card-header">

		<strong>Update</strong> Vehicle Details

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:700px;">

		

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="name" class="form-control" placeholder="Enter Vehicle Name" value="<?php echo $res['vehicle_name'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Type <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="vehicletype" class="form-control" placeholder="Enter Vehicle Type" value="<?php echo $res['vehicle_type'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="vehicleno" class="form-control" placeholder="Enter Vehicle Number" value="<?php echo $res['vehicle_number'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Chassis Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="chassisno" class="form-control" placeholder="Enter Chassis Number" value="<?php echo $res['chassis_no'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Purchased Year <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" name="purchasedyear" class="form-control" placeholder="Enter Purchased Year" value="<?php echo $res['purchased_year'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Status <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="vehicle_status" required>

				<option selected="selected" disabled value="">Select Vehicle Status</option>

				<option value="Running" <?php if($res['vehicle_status']=="Running"){echo "selected";} ?>>Running</option>

				<option value="Maintenance" <?php if($res['vehicle_status']=="Maintenance"){echo "selected";} ?>>Maintenance</option>

				<option value="Non Working" <?php if($res['vehicle_status']=="Non Working"){echo "selected";} ?>>Non Working</option>

			</select>

			</div>

			</div>

				

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Previous Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="preexp" class="form-control" placeholder="Enter Previous Experience" value="<?php echo $res['prev_exp'];?>" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Vehicle <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="aboutvehicle" placeholder="About Vehicle" required><?php echo $res['about_vehicle'];?></textarea>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Him/Her <span style="color:red;font-weight:bold;">*</span></label>
			<input type="hidden" name="vid" value="<?=$_GET['vid']?>">
 			<textarea class="form-control" name="description" placeholder="Enter Description" required><?php echo $res['description'];?></textarea>

			</div>

			</div>		

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class="fa fa-edit"></i> Update

		</button>

		

		<a href="dashboard.php?option=view_vehicle" class="btn btn-info btn-sm">

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
	// console.log(this);
  var action ="Update_Vechicle";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/TransportController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			// console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_vehicle';
					// $('form')[0].reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-edit"></i> Update');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>

