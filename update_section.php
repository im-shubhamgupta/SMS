<?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$sid=$_REQUEST['sid'];

	$sql=mysqli_query($con,"select * from section where section_id='$sid'");

	$res=mysqli_fetch_array($sql);

	$classid=$res['class_id'];

	$section=$res['section_name'];

		

	

?>

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Section

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Class</label>

			

					<?php

						$sql = "SELECT * FROM class where class_id='$classid'";

						$resclass = mysqli_query($con, $sql);

						$rows  = mysqli_fetch_array($resclass); 	

					?>

						<input type="text" value="<?php echo $rows['class_name']; ?>" readonly class="form-control" name="nclass">

							

			</div>

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Enter Section</label>

			<input type="text" name="nsection" placeholder="Enter Section." value="<?php echo $section;?>" class="form-control" required></div>
			<input type="hidden" name="sid" value="<?=$_GET['sid']?>">
		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_section" class="btn btn-info btn-sm"> 

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
  var action = "Update_Section";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_section';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>