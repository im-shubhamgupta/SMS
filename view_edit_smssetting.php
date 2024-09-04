<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

date_default_timezone_set("Asia/Kolkata");



// if(isset($update))
// 	{

// 		//$que=mysqli_query($con,"update sms_setting set user_name='$uname',password='$pass',api_key='$apikey',

// 		//secret_code='$scode',sender_id='$senderid',api_url='$apiurl' where sms_id='1'");
// 		$type='';
// 		if(!empty($Wsenderid)){
// 			  $sqlsms=" AND sms_id=2";
// 		    $aid=$Wsenderid;
// 		    $type=" Whatsapp ";
// 		}elseif(!empty($senderid)){
// 			  $sqlsms=" AND sms_id=1";
// 			  $aid=$senderid;
// 			  $type="Text ";
// 		}

// 		$que="update sms_setting set `sender_id`='$aid',`work_status`='1' , `modify_date`='".date('Y-m-d H:i:s')."' where 1 $sqlsms  ";
// 		$query= mysqli_query($con,$que);
// 		// if(mysqli_query($con,$que))
// 		 if($query)
// 			{
// 				$err= "<span style='color:green;'><strong>[".$type." SMS Setting Updated Successfully ]</strong></span>";

// 				$action = "Sender ID $aid is updated."; 

// 				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

// 				machine_name,browser,date) 

// 				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 			}else{
// 				$err= "<span style='color:red;'><strong>[ Something Wrong Please Try Again ]</strong></span>";
// 			}


// 	}
$query2=mysqli_query($con,"select * from sms_setting where sms_id='2' ");
$query1=mysqli_query($con,"select * from sms_setting where sms_id='1' ");

$res2=mysqli_fetch_array($query2);
$res=mysqli_fetch_array($query1);





?>

		  <!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Configuration Panel</a>

  <a class="breadcrumb-item" href="#">SMS Setting</a>

  <span class="breadcrumb-item active">View & Update SMS Setting</span>

</nav>
<?php echo @$err; ?>
<!-- breadcrumb -->


		 <div class="content mt-3">	

		 	  	<!-- //update whatsapp sms setting       -->    
		 	  	<?php 
		 	  	// echo "<pre>";
		 	  	// print_r($res2);
		 	  	// echo "</pre>"; 
		 	  	?>           

      <div class="col-lg-12">

                    <div class="card"  style="width:500px;">

                      <div class="card-header">

                        <strong>Update  Whatsapp </strong>SMS Setting

                      </div>

                      <div class="card-body card-block">

                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
                        	<input type="hidden" name="roles" value="<?php echo $roles;?>" >
													<input type="hidden" name="panelid" value="<?php echo $panelid;?>" >
													<input type="hidden" name="menuid" value="<?php echo $menuid;?>" >
													<input type="hidden" name="submenuname" value="<?php echo $submenuname;?>" >
													<input type="hidden" name="machinename" value="<?php echo $machinename;?>" >
													<input type="hidden" name="ExactBrowserNameBR" value="<?php echo $ExactBrowserNameBR;?>" >
													<input type="hidden" name="currdt" value="<?php echo $currdt;?>" >

											<div class="row form-group">

				              <div class="col col-md-3">

											<label for="email-input" class=" form-control-label">Instance ID : </label></div>

				              <div class="col-12 col-md-9">

											<input type="text" name="Wsenderid" id="Wsenderid" value="<?php echo $res2['sender_id']; ?>" class="form-control" autofocus required></div>

											</div>
										

				              </div>
				              <div >
				              		<div style="display:block; text-align:center;" >
				              	<?php  if($res2['work_status']=='0'){
				              			echo "<h4><span style='color:red;'> !!! Instance Id Expired !!!</span></h4>";

				              		  }else{
				              		  	// echo "<span style='color:green;'> Sms Working </span";
				              		  }

				              	  ?>
				              	
				              	</div>
				              </div><br>

					<?php
					if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
					{	?>
            <div class="card-footer">

              <button type="submit" name="update_sms_setting"  id="update_sms" class="btn btn-primary btn-sm update_sms">

                <i class="fa fa-edit"></i> Update

              </button>

            </div>
					<?php } ?>  

            </div>

           </form>

          </div>

	      </div>            

	      </div>
	<!-- // end update whatsapp sms setting       -->

	 <div class="content mt-3 text_sms" style="margin-left:15px;">	
		 <div class="col-lg-12">

                    <div class="card"  style="width:500px;">

                      <div class="card-header">

                        <strong>Update Text</strong> SMS Setting

                      </div>

                      <div class="card-body card-block">

                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="Text_form">

                        	<input type="hidden" name="roles" value="<?php echo $roles;?>" >
													<input type="hidden" name="panelid" value="<?php echo $panelid;?>" >
													<input type="hidden" name="menuid" value="<?php echo $menuid;?>" >
													<input type="hidden" name="submenuname" value="<?php echo $submenuname;?>" >
													<input type="hidden" name="machinename" value="<?php echo $machinename;?>" >
													<input type="hidden" name="ExactBrowserNameBR" value="<?php echo $ExactBrowserNameBR;?>" >
													<input type="hidden" name="currdt" value="<?php echo $currdt;?>" >

                         

                          

						<!--<div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">API User Name</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="uname" value="<?php echo $res['user_name']; ?>" class="form-control"></div>

							</div>

                         

							<div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">Password</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="pass" class="form-control" value="<?php echo $res['password'];?>"/></div>

							</div>

						  

						    <div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">API Key</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="apikey" value="<?php echo $res['api_key']; ?>"  class="form-control"></div>

							</div>

							

							<div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">Secret Code</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="scode" value="<?php echo $res['secret_code']; ?>" class="form-control"></div>

							</div>-->

							

							<div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">Sender ID :</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="senderid" id="senderid" value="<?php echo $res['sender_id']; ?>" onblur="limit(this)" class="form-control"  required></div>

							</div>

							 

							<!--

							onkeydown="limit(this);" onkeyup="limit(this);"

							<div class="row form-group">

                            <div class="col col-md-3">

							<label for="email-input" class=" form-control-label">API URL</label></div>

                            <div class="col-12 col-md-9">

							<input type="text" name="apiurl" value="<?php echo $res['api_url']; ?>"  class="form-control"></div>

							</div>-->

						

                      </div><br>

					  

					<?php

					if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

					{

					?>

                      <div class="card-footer">

                        <button type="submit" name="update_sms_setting" id="update_text_sms" class="btn btn-primary btn-sm update_sms">

                          <i class="fa fa-edit"></i> Update

                        </button>

                      </div>

					<?php

					}

					?>  

					  

                    </div>

                   </form>

                  </div>
                </div>



<script>

$("#senderid").keydown(function(event) { k = event.which; if ((k >= 65 && k <= 90) || (k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 6) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>





<script>

function limit(element)

{

    if(element.value.length < 6) {

        alert("Pls enter six character(alphanumeric) sender id.");

    }

}

</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	"use strict";
$(document).ready(function(){
// $('form').on('submit', function (e) {
$('#update_sms').on('click', function (e) {
	e.preventDefault();
  // var action = $('#update_sms').attr("name");
  // alert(action);
	// $(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData($('#formElem')[0]);
		data_string.append('update_sms_setting','1');
	
	$(this).text("Updating, please wait...");  
	$(this).attr("disabled", true);
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
				window.location.href='dashboard.php?option=view_edit_smssetting&smid=10';
				},2000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$(this).text("Update ");  
	      $(this).attr("disabled", false);

			}
		}
	})
});

});

</script>
<script>
	"use strict";
$(document).ready(function(){
// $('form').on('submit', function (e) {
$('#update_text_sms').on('click', function (e) {
	// alert(this);
	e.preventDefault();
  // var action = $('#update_text_sms').attr("name");

	// $(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData($('#Text_form')[0]);
	data_string.append('update_sms_setting','1');
	$(this).text("Updating, please wait...");  
	$(this).attr("disabled", true);
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
				window.location.href='dashboard.php?option=view_edit_smssetting&smid=10';
				},2000);
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$(this).text("Update ");  
	      $(this).attr("disabled", false);

			}
		}
	})
});

});

</script>


