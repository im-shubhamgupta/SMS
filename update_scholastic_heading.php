<?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$id=$_REQUEST['id'];

	

	$sql=mysqli_query($con,"select * from co_scholastic where scholastic_id='$id'");

	$res=mysqli_fetch_array($sql);

	$head_name=$res['scholastic_name'];

	

		if(isset($update))

		{

			// $sql1=mysqli_query($con,"select * from co_scholastic where scholastic_name='$sch_name'");

			// $res1=mysqli_num_rows($sql1);

			// if($res1)

			// {

			// 	$err="<span id='err_notsuccessful'>[ This Header is Already Exists. ]</span>";	

			// }

			// else

			// {

			// 	mysqli_query($con,"update co_scholastic set scholastic_name='$sch_name' where scholastic_id='$id'");		

			// 	echo "<script>window.location='dashboard.php?option=view_scholastic'</script>";	

			// }	

			

		}

	

?>

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Scholastic Heading

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Scholastic Name</label>

			<input type="text" name="sch_name" value="<?php echo $head_name; ?>" class="form-control" placeholder="Enter Heading" required>
			<input type="hidden" name="scholastic_id" value="<?php echo $id; ?>"  >

			</div>

		

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

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
		"timeOut": "3000",	
		"extendedTimeOut": "1000",	
		"showEasing": "swing",	
		"hideEasing": "linear",
		"showMethod": "fadeIn",	
		"hideMethod": "fadeOut"	
		};	
		
   
   $('form').on('submit', function (e) {
   	// alert(1);
	 // if( !confirm('Do You Assign This Test ') ){ 
		e.preventDefault(); 
	  // }else{ 
	  
	  var action = 'UpdateScholasticHeader'; 
	  $(this).append('<input type="hidden" name="'+ action+'"/>'); 
	   $("button[type='submit']").text("Sending please wait...");        
	  $("button[type='submit']").attr("disabled", true);   
	  // $("input[type='submit']").attr("value", "Sending, please wait...");        
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
		 	setInterval(function(){
		 		window.location.href='dashboard.php?option=view_scholastic';
		 	},3000)
			

	     }else if(response.type=='already'){
			 
			toastr.error(response.message); 
			
		}else{
		  toastr.error(response.message);	
		}
			$("button[type='submit']").text("Update");        
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