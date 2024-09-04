<?php

error_reporting(1);

extract($_REQUEST);

 date_default_timezone_set('Asis/Kolkata');

$id=$_REQUEST['id'];
$session=$_SESSION['session'];


$q1 = mysqli_query($con,"select * from student_route where sturoute_id='$id' AND session='$session' ");

$r1 = mysqli_fetch_array($q1);

$stuid = $r1['student_id'];

$tranid = $r1['trans_id'];

$fmodeid = $r1['fee_mode_id'];

$price = $r1['price'];

$reason1 = $r1['reason'];
$fee_start_month = $r1['fee_start_month'];



$q2 = mysqli_query($con,"select * from students where student_id='$stuid' ");

$r2 = mysqli_fetch_array($q2);

$stuname = $r2['student_name'];



$q = mysqli_query($con,"select * from transports where trans_id='$tranid'");

$r = mysqli_fetch_array($q);

$tramt = $r['price'];



$clsid = get_student_records_by_stuid($stuid)['class_id'];

$q3 = mysqli_query($con,"select * from class where class_id='$clsid'");

$r3 = mysqli_fetch_array($q3);

$clasname = $r3['class_name'];



$secid = get_student_records_by_stuid($stuid)['section_id'];

$q4 = mysqli_query($con,"select * from section where section_id='$secid'");

$r4 = mysqli_fetch_array($q4);

$secname = $r4['section_name'];



// if(isset($update))

// {	



// 	if($fmode=="1")

// 	{

// 		$routefee = $updatedfee;

// 		$discount = 0;

// 	}

// 	else

// 	{

// 		$routefee = $updatedfee;

// 		$discount = $tramt - $updatedfee;

// 	}



// 	$newdue = $routefee;
    
		
	
// 	$modify_date=date('Y-m-d H:i:s');
	

// 	$que = mysqli_query($con,"update student_route set trans_id='$route', fee_mode_id='$fmode', price='$routefee',

//  	discount='$discount', reason='$reason', due_amount='$newdue', `modify_date`='$modify_date' where sturoute_id='$id'  AND session='$session' ");

	

// 	echo "<script>window.location='dashboard.php?option=view_route_to_student'</script>";

// }



?>



	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



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

<nav class="breadcrumb"  style="width:1050px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_route_to_student">View Route to Student</a>

  <span class="breadcrumb-item active">Edit Assign Route to Student</span>

</nav>

<!-- breadcrumb -->

   <form method="post" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

					<div class="card">

                    <div class="card-header">	

						

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="font-size:14px;">Class</div>

							<div class="col-md-3" style="margin-top:-10px">

							<input class="form-control" type="text" name="class" value="<?php echo $clasname;?>" 

							style="width:175px;" readonly>

							</div>

							 

							<div class="col-md-2" style="font-size:14px;margin-left:-20px;">Section </div>

							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">

							<input class="form-control" type="text" name="class" value="<?php echo $secname;?>" 

							style="width:175px;" readonly>

							</div>

						</div><br>

						

												

                        <div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="font-size:14px;">Student Name </div>

							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">

							<input class="form-control" type="text" name="class" value="<?php echo $stuname;?>" 

							style="width:175px;" readonly>	

							<input type="hidden" name="sid" value="<?php echo $stuid;?>">
							<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
							<!-- <input type="hidden" name="fee_start_month" value="<?php// echo $_POST['fee_start_month'];?>"> -->

							</div>	
							 <div class="col-md-2" style="font-size:14px;margin-left:10px;">Fee Affect Month </div>

							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">
								<select data-placeholder="Choose Month ..."  class="form-select" id="month" name="fee_start_month"  required >	
									<option value="" selected disabled>Select month</option>	
									<?php
									foreach(get_general_year() as $key=>$value){
										$selected=($fee_start_month==$key)? 'selected' : '' ;
										echo "<option value='".$key."' $selected >".$value."</option>";
									}
									?>   
								</select>	

							

							</div>				

						</div><br>

						

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

							$("#price").val(xmlhttp.responseText);

							//$("#orgprice").val(xmlhttp.responseText);

							$("#updfee").val(xmlhttp.responseText);

							$('#fmode').prop('selectedIndex',0);

							}

							} 

							}

						</script>

					</div>

						

						

						<!--table starts from here-->

						    <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

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

											<select name="route" class="form-control" onchange="routeamt(this.value)" autofocus required>

											<option value="">Select Route</option>

											<?php

											$qroute = mysqli_query($con,"select * from transports where 1 order by route_name ");

											while($rrou = mysqli_fetch_array($qroute))

											{

												$routeid = $rrou['trans_id'];

												$routename = $rrou['route_name'];

											?>

											<option <?php if($tranid == $routeid){echo "selected";}?> value="<?php echo $routeid;?>"><?php echo $routename;?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td style="width:150px;"> 

											<select class="form-control" name="fmode" id="fmode" onchange="test(this.value)">

											<?php

											$qfeemode = mysqli_query($con,"select * from fee_mode where fee_mode_id!='2' && fee_mode_id!='4'");

											while($rfeemode = mysqli_fetch_array($qfeemode))

											{										

											$modeid = $rfeemode['fee_mode_id'];

											$modename = $rfeemode['fee_mode_name'];

											?>

											<option <?php if($fmodeid == $modeid){echo "selected";}?> value="<?php echo $modeid;?>"><?php echo $modename;?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td><input type="text" name="actual_fee" value="<?php echo $price;?>" id="price" 

											class="form-control" style="width:150px;" readonly></td>

											<input type="hidden" name="orgprice" id="orgprice" value="<?php echo $tramt;?>">

											

											<td><input type="number" name="updatedfee" id="updfee" style="width:150px;"

											value="<?php echo $price;?>" class="form-control" readonly></td>

											

											<td><input type="text" name="reason" id="reason" class="form-control"

											value="<?php echo $reason1;?>" readonly></td>

										</tr>																

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

							

								<button type="submit" name="update" class="btn btn-secondary btn-sm">

								<i class="fa fa-edit"></i> Update

			

								</button>

								

								<input type="reset" class="btn btn-info btn-sm" value="Cancel">

								

							</div>

                    </div>

					

	<div class="row">

	<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

	

		<div class="row" style="margin-top:20px;">

			<div class="col-md-2">

			</div>

		

		</div>

	

	</div>						

	</div><br>

						

<script>



function test(fid)

{

	$amt = $("#orgprice").val();

	

	if(fid=="3")

	{

		$("#updfee").css("display","block");

		$("#updfee").removeAttr("readonly");

		$("#updfee").prop('required',true);

		$("#updfee").val(0);

		$("#reason").css("display","block");

		$("#reason").removeAttr("readonly");		

		$("#reason").prop('required',true);

	}

	else

	{

		$("#updfee").val($amt);

		$("#updfee").attr('readonly','readonly');

		$("#reason").css("display","none");

		$("#reason").val('');

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

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php');?>
 <script>
 $(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// console.log(this);
  var action ="Update_Assign_Route_to_Student";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	// $("button[type='submit']").html("Please wait...");  
	// $("button[type='submit']").attr("disabled", true);
	
    $('button[type="submit"],input[type="submit"]').html("please wait...").val("please wait...");
	$('button[type="submit"],input[type="submit"]').attr("disabled", true);

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
				window.location.href='dashboard.php?option=view_route_to_student';
					// $('form')[0].reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			//   $("button[type='submit']").html('<i class="fa fa-plus"></i> Save');  
	        // $("button[type='submit']").attr("disabled", false);
		    $('button[type="submit"],input[type="submit"]').html('<i class="fa fa-plus"></i> Save').val("Save");
	        $('button[type="submit"],input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>


 