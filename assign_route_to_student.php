<?php

error_reporting(1);



?>



	<style>
/* 
	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}
 */


	</style>

	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>



<div id="right-panel" class="right-panel">

<!-- breadcrumb-->

<nav class="breadcrumb" style="width:1050px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>
  <a class="breadcrumb-item" href="#">Route</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_route_to_student">View Route to Student</a>
  <span class="breadcrumb-item active">Assign Route to Student</span>


</nav>

<!-- breadcrumb -->
  <h6><label><?php echo @$err ?></label></h6>

   <form method="post" action="dashboard.php?option=assign_route_to_student" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">



						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:50px">Class</div>

							<div class="col-md-2" style="margin-top:-10px">

							<select name="class" class="form-select" style="width:175px;" 

							onchange="searchstudent(this.value);search_sec(this.value);"  autofocus required>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = "select * from class";

							$rcls = mysqli_query($con, $scls);

							while( $rescls = mysqli_fetch_array($rcls) ) {

							?>

							<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<div class="col-md-2" style="font-size:14px;margin-left:80px;">Section </div>

							<div class="col-md-2" style="margin-left:-10px;margin-top:-10px">

							<select class="form-select" name="section" id="search_sect" style="width:175px;" 

							onchange="searchstudent(this.value);" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

							<?php

							$qsec=mysqli_query($con,"select * from section where class_id='$class'");

							while($rsec=mysqli_fetch_array($qsec))

							{

							$secname=$rsec['section_name'];

							?>

							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							</option>

							<?php 

							}

							?>							

							</select>	

													

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>

							

							</div>

							

							<script>

							function searchstudent(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							// xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);
							xmlhttp.open("get","search_data.php?sec_id="+str +"&search_assign_route_students="+1,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("student").innerHTML=xmlhttp.responseText;

							}

							}

							}

							</script>

									

							<script>

							function checkstuassign(str)

							{

								$.ajax({

									url:'get_ajax_assign_students_route_detail.php?stu_id='+str,

									type:'get',

									success:function(res) {
										var responce=JSON.parse(res);
										// alert(data);
										if(responce.status=='1'){
											alert('Already Assigned Route to '+responce.stuname);
											$('#student').prop('selectedIndex',0);
										}else if(responce.bus_facility!='Yes'){

											alert('This Student is not taken transport facility at Admission time');
											$('#student').prop('selectedIndex',0);
										}
										// if(!$.trim(data)==''){

										

										

										// }

									}

									

								});

							}

							</script>
						</div><br>
                        <div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Student Name </div>

							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">

							<select class="form-select" name="student" id="student" onchange="checkstuassign(this.value)"  style="width:175px;" autofocus required>

							<option value="" selected="selected" disabled>Select Student</option>

							<?php

							$qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' AND bus_facility='Yes'   and session='".$_SESSION['session']."' ");

							while($rstu=mysqli_fetch_array($qstu)){

							?>

							<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>

							</option>

							<?php 

							}

							?>							

							</select>	

							</div>								
                          <?php  
						     $months = array(1=> 'April', 2 => 'May',  3=> 'June', 4 => 'July', 5 => 'August', 6 => 'September', 7 => 'October', 8 => 'November', 9=> 'December',10 => 'January', 11=> 'February', 12 => 'March', ); 
                           ?>
						      <div class="col-md-2" style="font-size:14px;margin-left:80px;">Fee Affect Month </div>
						  	 <div class="col-md-2" style="margin-left:0px;margin-top:-10px">
								<select data-placeholder="Choose Month ..."  class="form-select" id="month" name="fee_start_month"  required >	
									<option value="" selected disabled>Select month</option>	
									<?php
									foreach($months as $key=>$value){
										$selected=($fee_start_month==$key)? 'selected' : '' ;
										echo "<option value='".$key."' $selected >".$value."</option>";
									}
									?>   
								</select>	

							

							</div>
							

						</div>
						
						
					
						
						
						
						
						<br>

						

						<script>

							function routeamt(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_route_amount.php?r_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("ramount").innerHTML=xmlhttp.responseText;

							$("#amt").val(xmlhttp.responseText);

							$("#updfee").val(xmlhttp.responseText);

							$('#fmode').prop('selectedIndex',0);

							}

							} 

							}

						</script>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

										<th>Route Name</th>

										<th>Mode</th>

										<th>Actual Fees</th>

										<th>Updated Fees</th>

										<th>Reason</th>

                                    </thead>

                                    <tbody>

										<tr>

											<td style="width:200px;">

											<select name="route" class="form-select" onchange="routeamt(this.value)" autofocus required>

											<option value="" selected="selected" disabled>Select Route</option>

											<?php

											$qroute = mysqli_query($con,"select * from transports where session = '".$_SESSION['session']."'");

											while($rrou = mysqli_fetch_array($qroute))

											{

												$routeid = $rrou['trans_id'];

												$routename = $rrou['route_name'];

											?>

											<option value="<?php echo $routeid;?>"><?php echo $routename;?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td style="width:150px;"> 

											<select class="form-select" name="fmode" id="fmode" onchange="test(this.value)">

											<?php

											$qfeemode = mysqli_query($con,"select * from fee_mode where fee_mode_id!='2' && fee_mode_id!='4'");

											while($rfeemode = mysqli_fetch_array($qfeemode))

											{										

											$modeid = $rfeemode['fee_mode_id'];

											$modename = $rfeemode['fee_mode_name'];

											?>

											<option value="<?php echo $modeid;?>"><?php echo $modename;?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td id="ramount" style="font-size:14px;text-align:center;width:150px"></td>

											<input type="hidden" name="ramt" id="amt">

											

											<td><input type="number" name="updatedfee" id="updfee"  

											class="form-control" style="width:150px;" readonly></td>

											

											<td><input type="text" name="reason" id="reason" class="form-control" 

											style="font-size:14px;width:150px;text-align:center;display:<?php if(!empty($reason)){echo 'block';} else {echo 'none';}?>"></td>

										</tr>																

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

								<button type="submit" name="save" class="btn btn-primary btn-sm">

								<i class="fa fa-plus"></i> Save

															

								</button>

								

								<input type="reset" class="btn btn-info btn-sm" value="Reset">

								

							</div>

                        </div>

					



						

<script>

function test(fid)

{

	$amt = $("#amt").val();

	

	if(fid=="3")

	{

		$("#updfee").css("display","block");

		$("#updfee").removeAttr("readonly");

		$("#updfee").prop('required',true);

		$("#updfee").val(0);

		$("#reason").css("display","block");

		$("#reason").prop('required',true);

	}

	else

	{

		$("#updfee").val($amt);

		$("#updfee").attr('readonly','readonly');

		$("#reason").css("display","none");

		$("#reason").prop("required",false);

	}

}



</script>

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>	

    </div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
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
  var action ="Assign_Route_to_Student";
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
				window.location.href='dashboard.php?option=assign_route_to_student';
					// $('form')[0].reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Save');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>

 