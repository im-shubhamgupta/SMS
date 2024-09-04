<?php	

	//error_reporting(1);


	

?>

<div class="card">

<!-- breadcrumb-->

<style>

.breadcrumb {

    display: -ms-flexbox;

    display: flex;

    -ms-flex-wrap: wrap;

    flex-wrap: wrap;

    padding: .75rem 1rem;

    margin-bottom: 1rem;

    list-style: none;

	margin-left:-18px;

	margin-top:-17px;

    background-color: #237791;

    border-radius: .25rem;

	font-size:19px;

}

.breadcrumb-item{

	color:#fff;

}

.breadcrumb-item .fa fa-home{

	color:#fff;

}

.breadcrumb-item.active {

    color: #eff7ff;

}

.breadcrumb-item+.breadcrumb-item::before {

    display: inline-block;

    padding-right: .5rem;

    color: #eff4f9;

    content: "/";

} 



</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Section</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_section">View Section</a>

  

  <span class="breadcrumb-item active">Add Section</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Section

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

			<label for="nf-email" class="form-control-label">Enter Section</label>

			<input type="text" name="section" placeholder="Enter Section." class="form-control" required>

			</div>

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add Section

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
  var action = "Add_Section";
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
				window.location.href='dashboard.php?option=add_section&smid=4';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add Section');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>