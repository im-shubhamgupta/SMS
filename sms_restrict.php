 <?php
// include('myfunction.php');
	// //error_reporting(1);

	// extract($_REQUEST);

	// $q1=mysqli_query($con,"select * from student_restrict where id='1'");

	// $r1=mysqli_fetch_array($q1);

	// $tstu=$r1['total_students'];

	

	// if(isset($save))

	// {		

	// 	$query=mysqli_query($con,"update student_restrict set total_students='$tstudents'");	

	// 	//$err="<style='color:green;font-weight:bold'>[ Added Successfully ]</style>";

	// 	echo "<script>window.location='dashboard.php?option=student_restrict'</script>";

	// }

	

?>

<!-- <div class="card"  style="width:600px;"> -->

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Setting Panel</a>

  <span class="breadcrumb-item active">SMS Restriction</span>

</nav>

<!-- breadcrumb -->

<?php// echo @$err; ?>
<!-- breadcrumb -->
	<?php 	
	$query2=mysqli_query($con,"select * from `log_sms_count` where id='2' ");
  $query1=mysqli_query($con,"select * from `log_sms_count` where id='1' ");

  $Trow=mysqli_fetch_assoc($query2);
  $Wrow=mysqli_fetch_assoc($query1);

  $Wmonth=date('F' ,strtotime($Wrow['modify_date']));
  	$Tmonth=date('F' ,strtotime($Trow['modify_date']));
?>

<div class='container' style="margin-top:40px;">
	<div class="row">
		<div class="col-md-6 offset-0" >
			<div class="card">
				<table class="table table-bordered"  style="background-color: white;">
				  <thead>
				  	<tr>
				  		<th colspan="2" ><span><img src="images/sms_image/whatsapplogo.png" width="30px" height="30px" title="Whatsapp SMS"/></span>   Whatsapp SMS Limit</th>
				  	</tr>
				  </thead>
				</table>
				<!-- update whatsapp sms limit -->
				<form  name="WhatsappSms_limit">
					<div class="card-body card-block">

							<div class="form-group">

							<label for="nf-email" class=" form-control-label">Remaining SMS </label>

							<input type="text" name="count"  class="form-control" value="<?php echo $Wrow['count_sms']?>" realonly disabled >
							</div>
							<div class="form-group">

							<label for="nf-email" class=" form-control-label">Whatsapp SMS Limit</label>

							<input type="text" name="Wlimit" class="form-control" value="<?php echo $Wrow['limit']?>" autofocus >
							</div>

					</div>

					<div class="card-footer ">

						<!-- <button type="submit" name="WhatsappSms_limit" id="update_sms"  class="btn btn-primary col-3 ">Update				  -->

						<!-- </button> -->
								<!-- <input type="submit" name="WhatsappSms_limit" id="WhatsappSms_limit" class="btn btn-primary col-3 " value="Update"> -->
								<input type="submit" name="Sms_limit" onclick="return confirm('Do you want to Add his Whatsappsms Limit')" id="Sms_limit" class="btn btn-primary col-3 " value="Add limit">

					</div>
	      </form>   
	    </div> 
		</div>
		<div class="col-md-6 offset-0" >
			<div class="card">
				<table class="table table-bordered"  style="background-color: white;">
				  <thead>
				  	<tr>
				  		<th colspan="2" ><span><img src="images/sms_image/textsms.png" width="30px" height="30px" title="Text SMS"/></span>   Text SMS Details</th>
				  	</tr>
				  </thead>
				</table>

				<!-- update text sms limit -->
				
				<form  name="TextSms_limit">
					<div class="card-body card-block">

							<div class="form-group">

							<label for="nf-email" class=" form-control-label">Remaining SMS </label>

							<input type="number" name="count" class="form-control" value="<?php echo $Trow['count_sms']?>" readonly disabled >
						</div>
						<div class="form-group">

							<label for="nf-email" class=" form-control-label"> Text SMS Limit</label>

							<input type="number" name="Tlimit" class="form-control" value="<?php echo $Trow['limit']?>" autofocus >
						</div>

					</div>

					<div class="card-footer ">

						<input type="submit" name="Sms_limit" id="Sms_limit" onclick="return confirm('Do you want to Add his Textsms Limit')" class="btn btn-primary col-3 " value="Add limit">
						<!-- <input type="submit" name="TextSms_limit" id="TextSms_limit" class="btn btn-primary col-3 " value="Update"> -->
						<!-- <button type="submit" name="TextSms_limit" id="update_sms"  class="btn btn-primary col-3 " value="Update">Update</button> -->

					</div>
	      </form>   
	    </div> 
 		</div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  // var action = $('#Sms_limit').attr('name');
  var action = $(this).attr('name');  //take the form name 
	// var action = $('input[type=submit]').attr('name');
   // var action = $("#update_sms").attr("name");
  // alert(action);
  console.log(this);

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$('input[type=submit]').val("Sending, please wait...");  
	$('input[type=submit]').attr("disabled", true);
	$.ajax({
		url:"AjaxHandler.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse($.trim(responce)); 
			// alert(result.type);
			console.log(responce);
			if(result.type=="SUCCESS"){
				// alert('success');
				toastr.success(result.message); 
				
				
				$("input[type=submit]").val("Add limit");  
	      $("input[type=submit]").attr("disabled", false);
	      setInterval(function(){ 
				// window.location.href='dashboard.php?option=sms_restrict';
	      	location.reload();

				},2000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("input[type=submit]").val("Add limit");  
	      $("input[type=submit]").attr("disabled", false);

			}
		}
	})
});
});




</script>