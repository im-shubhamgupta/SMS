

 <?php

	//error_reporting(1);

	// extract($_REQUEST);

	// if(isset($add))

	// {		



	// 	$sql=mysqli_query($con,"select * from co_scholastic where scholastic_name='$schhead'");

	// 	$res=mysqli_num_rows($sql);

	// 	if($res)

	// 	{

	// 		$err="<span id='err_notsuccessful'>[ This Header is Already Exists. ]</span>";	

	// 	}

	// 	else

	// 	{

	// 		$query=mysqli_query($con,"insert into co_scholastic(scholastic_name) values('$schhead')");	

						

	// 		$err="<span id='err_successful'>[ Scholstic Heading Added Successfully ]</span>";

	// 	}

		

	// }

	

?>

<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Report Card Panel</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_scholastic">Scholastic Header </a>

  <span class="breadcrumb-item active">Add Scholastic Header</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post" id="devel-generate-content-form">

	<div class="card-header">

		<strong>Add</strong> Header

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Scholastic Heading</label>

			<input type="text" name="schhead" class="form-control" placeholder="Enter Heading" required>

			</div>

			

			

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

		<i class="fa fa-plus"></i> Add Header

		</button>

		

		<a href="dashboard.php?option=view_scholastic" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script> -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
	<script>
	
	$(document).ready(function(){
		toastr.options = {
		"closeButton": true, 
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",	
		"hideDuration": "1000",	
		"timeOut": "4000",	
		"extendedTimeOut": "1000",	
		"showEasing": "swing",	
		"hideEasing": "linear",
		"showMethod": "fadeIn",	
		"hideMethod": "fadeOut"	
		};	
   
   $('form').on('submit', function (e) {

	 // if( !confirm('Do You Assign This Test ') ){ 
		e.preventDefault(); 
	  // }else{ 
	  
	  var action = 'AddScholasticHeader'; 
	  $(this).append('<input type="hidden" name="'+ action+'"/>'); 
	  $("button[type='submit']").text("Sending please wait...");        
	  $("button[type='submit']").attr("disabled", true);        
	  // $("input[type='submit']").attr("disabled", true);
	  $.ajax({ 
		type: "POST",
		url : 'AjaxHandler.php',               
		data : new FormData(this),  
		contentType: false, 
		cache: false, 
		processData:false, 
		success: function (result) {
		var response = JSON.parse(result); 
		console.log(response);
		 if(response.type=='success') { 
		 	toastr.success(response.message);  
		 	// setInterval(function(){
		 	// 	window.location.href='dashboard.php?option=add_scholastic_header&smid=5';
		 	// },4000)
		 		setTimeout(function(){
		 		   $('#devel-generate-content-form')[0].reset();	
		 	  },3000)

		 	 
			

	     }else if(response.type=='already'){
			 
			toastr.error(response.message); 
			
		}else{
		  toastr.error(response.message);	
		}
			 $("button[type='submit']").text(" Add Header");        
	     $("button[type='submit']").attr("disabled", false); 
       //   $("input[type='submit']").attr("value", "Assign");        
	     // $("input[type='submit']").attr("disabled", false);
         // $('#devel-generate-content-form')[0].reset();		 

		}		 
	  
		});
		
		e.preventDefault(); 
	  // }
	});
   	});	     
		
	

	</script>