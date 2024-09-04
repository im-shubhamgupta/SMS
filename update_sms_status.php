<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$query=mysqli_query($con,"select * from sms_setting where sms_id = 1");

$res=mysqli_fetch_array($query);
$Wquery=mysqli_query($con,"select * from sms_setting where sms_id = 2");

$Wres=mysqli_fetch_array($Wquery);



?>

	<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Setting Panel</a>

  <span class="breadcrumb-item active">Update SMS Status

</span>

</nav>

<!-- breadcrumb -->	

		

		 <div class="content mt-3" style="width:1000px;">	

		<!-- Whatsapp sms setting -->	

		 <div class="col-md-7">

      <div class="card">

        <div class="card-header"><span><img src="images/sms_image/whatsapplogo.png" width="30px" height="30px" title="Whatsapp SMS"/></span>  

          <strong>Update</strong> SMS Status

        </div>

				<div class="card-body card-block">

          <form method="post" enctype="multipart/form-data" class="form-horizontal" id="Whatsappsms">

                          						

					<div class="row form-group">

          <div class="col-md-3">

							<label for="email-input" class=" form-control-label">Whatsapp SMS Status</label>

							</div>

                            <div class="col-md-9">

							<?php

							$Wque=mysqli_query($con,"select * from sms_setting where sms_id = 2");

							$Wres=mysqli_fetch_array($Wque);

							$Wid=$Wres['sms_id'];

							$Wsta=$Wres['status'];

							if($Wsta==1){

							?>
							<input type="hidden" name="whatsapp" value="0" >
							<input type="submit" onclick="return confirm('Are you sure want to Deactivate sms status ')" name="update_sms_status" value="ON" class="btn btn-success" style="width:100px;border-radius:20px">

							<!-- <a href='dashboard.php?option=edit_sms_setting&sid=<?php echo $id;?>&status=<?php echo $sta;?>&type="whatsapp"'><button type="button" class="btn btn-danger" style="width:100px;border-radius:20px">OFF</button></a>-->

							<span style="color:red;font-weight:bold;margin-left:20px">Click To Deactivate SMS Status</span>

						

							<?php

							}else{						

							?>

							<input type="hidden" name="whatsapp" value="1" >
							<input type="submit" onclick="return confirm('Are you sure want to Activate sms status ')" name="update_sms_status" value="OFF" class="btn btn-danger" style="width:100px;border-radius:20px">

							<!-- <a href='dashboard.php?option=edit_sms_setting&sid=<?php echo $id;?>&status=<?php echo $sta;?>'><button type="button" class="btn btn-success" style="width:100px;border-radius:20px">ON</button></a> -->

							<span style="color:green;font-weight:bold;margin-left:20px">Click To Activate SMS Status</span>

							<?php

							}

							?>

							</div>

							</div><br>

					  					  

						</div>

						</form>

         </div>

	      </div>



	   
	    <!-- text sms setting -->
	     <div class="col-md-7">

                    <div class="card">

                      <div class="card-header"><span><img src="images/sms_image/textsms.png" width="30px" height="30px" title="Text SMS"/></span>   

                        <strong>Update</strong> SMS Status

                      </div>

						<div class="card-body card-block">

                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="TextSms">

                          						

							<div class="row form-group">

                            <div class="col-md-3">

							<label for="email-input" class=" form-control-label">Text SMS Status</label>

							</div>

                            <div class="col-md-9">

							<?php

							$que=mysqli_query($con,"select * from sms_setting where sms_id = 1");

							$res=mysqli_fetch_array($que);

							$id=$res['sms_id'];

							$sta=$res['status'];

							if($sta==1)

							{

							?>
							<input type="hidden" name="text" value="0" >
							<!-- <a href='dashboard.php?option=edit_sms_setting&sid=<?php echo $id;?>&status=<?php echo $sta;?>'><button type="button" class="btn btn-danger" style="width:100px;border-radius:20px">OFF</button></a> -->
					
							<input type="submit" onclick="return confirm('Are you sure want to Deactivate sms status ')" name="update_sms_status" value="ON" class="btn btn-success" style="width:100px;border-radius:20px">


							<span style="color:red;font-weight:bold;margin-left:20px">Click To Deactivate SMS Status</span>

						

							<?php

							}else{						

							?>
							<input type="hidden" name="text" value="1" >
							<input type="submit" onclick="return confirm('Are you sure want to Activate sms status ')" name="update_sms_status" value="OFF" class="btn btn-danger" style="width:100px;border-radius:20px">

							<!-- <a href='dashboard.php?option=edit_sms_setting&sid=<?php echo $id;?>&status=<?php echo $sta;?>'>
								<button type="button" class="btn btn-success" style="width:100px;border-radius:20px">ON</button>
							</a>
 -->
							<span style="color:green;font-weight:bold;margin-left:20px">Click To Activate SMS Status</span>

							<?php

							}

							?>

							</div>

							</div><br>

					  					  

						</div>

						</form>

         </div>

	      </div>



	    </div>

	  </div>

 </div>

<script>

function limit(element)

{

    var max_chars = 6;



    if(element.value.length > max_chars) {

        element.value = element.value.substr(0, max_chars);

    }

}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
	toastr.options = {		
	 		"closeButton": true, 
			"debug": false,"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",	
			"preventDuplicates": false,	

			"onclick": null,	
			"showDuration": "300",
			"hideDuration": "1000",	
			"timeOut": "2000",		
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

 
  // var action = $(this).attr('name');  //take the form name 
	var action = $('input[type=submit]').attr('name');
   // var action = $("#update_sms").attr("name");
  // alert(action);
  console.log(this);

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	// $('input[type=submit]').val("Sending, please wait...");  
	// $('input[type=submit]').attr("disabled", true);
	$.ajax({
		url:"Controllers/SMSController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse($.trim(responce)); 
			// alert(result.type);
			console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.message); 
				
				// $("input[type=submit]").val("Update");  
	      $("input[type=submit]").attr("disabled", false);
	      setInterval(function(){ 
				// window.location.href='dashboard.php?option=sms_restrict';
	      	location.reload();

				},2000);
			}
			else if(result.type=="error"){
				toastr.error(result.message); 
				// $("input[type=submit]").val("Update");  
	      $("input[type=submit]").attr("disabled", false);

			}
		}
	})
});
});




</script>

