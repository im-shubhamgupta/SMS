	<?php	

	//error_reporting(1);

	// if(isset($add))

	// {		



	// 	$sql=mysqli_query($con,"select * from subject where subject_name='$subject' && class_id='$class'");

	// 	$res1=mysqli_num_rows($sql);

	// 	if($res1)

	// 	{

	// 		$err="<span id='err_notsuccessful'>[ This Subject Is Already Exists ]</span>";	

	// 	}

	// 	else

	// 	{

	// 		$query1="insert into subject(subject_name,class_id) values('$subject','$class')";	

	// 		mysqli_query($con,$query1);

	// 		$err="<span id='err_successful'>[ Subject Added Successfully ]</span>";

	// 	}

		

	// }

	

?>

<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a>  

  <a class="breadcrumb-item" href="dashboard.php?option=view_subject">View Subject</a>  

  <span class="breadcrumb-item active">Add Subject</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Subject

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Class</label>

			<select class="form-control" name="class" required>

					<option value="" selected disabled>---Select Class--</option>

					<?php

						$sql = "SELECT * FROM class";

						$resultset = mysqli_query($con, $sql);

						while( $rows = mysqli_fetch_array($resultset) ) {

						?>

						<option value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>

						</option>

						<?php } ?>	

			</select>

			</div>

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Enter Subject</label>

			<input type="text" name="subject" placeholder="Enter Subject" class="form-control" required>

			</div>

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add Subject

		</button>

	

		<a href="dashboard.php?option=view_subject" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

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
  var action ="AddSubject";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StaffController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=add_subject';
				// },3000);
			}
			else if(result.type=="error"){
				toastr.error(result.msg); 
				
	    }
	    $("button[type='submit']").html("<i class='fa fa-plus'> Add Subject"); 
	    $("button[type='submit']").attr("disabled", false);   
	    $('form')[0].reset();     
		}
	})
});

});

</script>