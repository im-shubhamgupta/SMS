<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');

date_default_timezone_set('Asia/Kolkata');

// if(isset($_REQUEST['search']))

// {

//     $cond = '';
//     // echo "<pre>";
//     // print_r($_REQUEST);
//     // echo "</pre>";

	

// 	if($_REQUEST['admission_grade']!='')

// 	{

// 		$cond.=" && grade='$_REQUEST[admission_grade]'";

// 	}

// 	if($_REQUEST['previous_grade']!='')

// 	{

// 		$cond.=" && previous_grade='$_REQUEST[previous_grade]'";

// 	}

// 	if($_REQUEST['previous_result']!='')

// 	{

// 		$cond.=" && previous_result='$_REQUEST[previous_result]'";

// 	}

// 	if($_REQUEST['per1']!='' && $_REQUEST['per2']!='')

// 	{

// 		$cond.=" && previous_percentage between $_REQUEST[per1] AND $_REQUEST[per2]";

// 	}
// //echo $query ="SELECT * FROM admission WHERE $cond";	

//  $sql1="SELECT * FROM admission WHERE status='0' $cond";

// $query =mysqli_query($con,$sql1);	

// }

// if(isset($request))

// {

// 	foreach($chk as $k)

// 	{

// 		if($q1 = mysqli_query($con,"update admission set status='1', requested_message='$message', requested_date=now() where admission_id='$k'"))

// 		{

			

// 			$q2 = mysqli_query($con,"select * from admission where admission_id='$k'");

// 			$r2 = mysqli_fetch_array($q2);

// 			$phone = $r2['phone'];

			
// 		$messagetype='request_addmission';
// 		$encod=urlencode($message);
// 	    $msg=$encod;

// 		sendwhatsappMessage($phone, $msg, $messagetype);

// 			//Send sms to sender and reciever

// 			$set=mysqli_query($con,"select * from sms_setting");

// 			$rset=mysqli_fetch_array($set);

// 			$senderid=$rset['sender_id'];

// 			$apiurl=$rset['api_url'];

// 			$apikey=$rset['api_key'];

// 			$senderId = "$senderid";

// 			$route = 4;

// 			$campaign = "OTP";

// 			$sms = array(

// 				'message' => "$message",

// 				'to' => array($phone)

// 			);

// 			//Prepare you post parameters

// 			$postData = array(

// 				'sender' => $senderId,

// 				'campaign' => $campaign,

// 				'route' => $route,

// 				'sms' => array($sms)

// 			);

// 			$postDataJson = json_encode($postData);



// 			$url="$apiurl";



// 			$curl = curl_init();

// 			curl_setopt_array($curl, array(

// 				CURLOPT_URL => "$url",

// 				CURLOPT_RETURNTRANSFER => true,

// 				CURLOPT_CUSTOMREQUEST => "POST",

// 				CURLOPT_POSTFIELDS => $postDataJson,

// 				CURLOPT_HTTPHEADER => array(

// 					"authkey:"."$apikey",

// 					"content-type: application/json"

// 				),

// 			));

// 			$response = curl_exec($curl);

// 			$err = curl_error($curl);

// 			curl_close($curl);

							

// 		}

	

// 	}



// 	echo "<script>window.location='dashboard.php?option=view_online_admission'</script>";



// }





?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}



</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <span class="breadcrumb-item ">Admission Panel</span>
  <span class="breadcrumb-item active">View Online Addmission</span>
  <!-- <span class="breadcrumb-item active">Admission Panel</span> -->

</nav>



	<form method="post" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:30px;">Admission for Grade</div>

								<div class="col-md-3">
									<!-- onchange="search_sec(this.value)" -->
								<select name="admission_grade" id="admission_grade" class="form-select"  autofocus >

								<option value="" selected="selected"  >All Grades</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option <?php if($admission_grade==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								<div class="col-md-2 offset-1">
									<input type="submit" name="search" id="search" class="btn btn-primary btn-sm col-8" value="Search"><br>

								</div>
								<div class="col-md-2 ">
									<input type="reset" name="reset" id='reset' class="btn btn-info btn-sm col-8" value="Reset"><br>

								</div>
								<!-- <div class="col-md-2 ">
									<input type="reset" name="reset" class="btn btn-info btn-sm col-8" value="Reset"><br>

								</div> -->

							</div>	

							<div class="row">
								<div class="col-md-12" style="margin-left:30px; margin-top:10px;">
								<span ><u>(Optional Filters)</u></span>
							    </div>
							</div>

							<div class="row" style="margin-top:5px;">

								<div class="col-md-2 " style="margin-left:30px;">Previous Grade</div>

								<div class="col-md-3">

								<select name="previous_grade"  id="previous_grade" class="form-select reset" autofocus >

									<option value="" selected >All</option>

									<?php

									$qrl = mysqli_query($con,"select * from grade");

									while($rrl = mysqli_fetch_array($qrl))

									{

									?>	

									<option <?php if($previous_grade==$rrl['grade_id']){echo "selected";}?> value="<?php echo $rrl['grade_id'];?>"><?php echo $rrl['grade_name'];?></option>

									<?php

									}

									?>

								</select>

								</div>

								

								<div class="col-md-3" style="margin-left:30px;">Previous Grade Result</div>

								<div class="col-md-3">

								<select name="previous_result" id="previous_result" class="form-select reset" autofocus >

								  <option value="" selected >All</option>

								  <option <?php if($previous_result=="Pass"){echo "selected";}?> value="Pass">Pass</option>

								  <option <?php if($previous_result=="Fail"){echo "selected";}?> value="Fail">Fail</option>

								</select>

								</div>

							</div>	

							

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3 " style="margin-left:30px;">Percentage between</div>

								<div class="col-md-3">

								<input type="text" name="per1" id="per1"  class="form-control reset" autofocus />

								</div>

								

								<div class="col-md-1" style="margin-left:5px;">to</div>

								<div class="col-md-3">

								<input type="text" name="per2"  id="per2"  class="form-control reset" autofocus />

								</div>

							</div>

								

							<!-- <div class="row" style="margin-top:20px;">

							<div class="col-md-12" style="margin-left:350px;">

							<input type="submit" name="search" class="btn btn-primary btn-sm" value="Search"><br><br>

							</div>

							</div> -->

							

                            </div>
                        <form method="post" >    	
                            <div class="card-body">
<!-- bootstrap-data-table-export                  table-responsive -->
								
                                <table id="table-grid" class="table table-striped table-bordered ">

                                    <thead>

                                        <tr>

                                             <th>Select All

											 <span><input type="checkbox" name="selectall" id="selectall"></span>

											 </th>
                                             <th>Reference No.</th>
                                             <th>Apply Date</th>

											 <th>Name</th>

											 <th>Father's Name</th>

											 <th>Gender</th>

											 <th>Mobile No.</th>
											 <th>Admission for</th>

											 <th>Previous School</th>

											 <th>Previous Grade</th>

											 <th>Previous Grade Percentage</th>

											 <th>Address</th>

											 <th>City</th>

											 <th>State</th>

											 

                                        </tr>

                                    </thead>

                                    

                                </table>


                            </div>

							

							<div class="card-footer">
								<!-- <script>
									alert(document.getElementById('admission_grade').value);
								</script> -->

								<?php 

								

									// echo "clsid: ".$clsid = "<script>document.getElementById('admission_grade').value;</script>";
									// // $clsid = echo "<script>alert(12)</script>";

									// $scls = mysqli_query($con,"select * from class where class_id='$clsid'");

									// $rcls = mysqli_fetch_array($scls);

									// $clsname = $rcls['class_name'];

									

									$sl = mysqli_query($con,"select * from setting");

									$rsl = mysqli_fetch_array($sl);

									$slname = $rsl['company_name'];

									

								?>
								<!-- <?//date('d-M-Y',strtotime('1days'))?> -->

<textarea name="message" class="form-control" style="width:780px;height:200px;margin-left:50px;margin-top:10px;margin-bottom:20px;">Dear Student,

Congratulations, We have shortlisted you for the admission of <?php echo $clsname;?> as per your interest. Kindly Come for an admission on next working days. Kindly carry the reference number for the admission and necessary documents.

Regards,

<?php echo $slname;?>
</textarea>



<input type="submit" name="request" id='RequestAdmisssion' value="Request for Admission" class="btn btn-success btn-sm" style="margin-left:300px;margin-right:20px"/>

							

<input type="reset" value="Cancel" class="btn btn-primary btn-sm">

		</div>												

								
</form>
							</div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	<!-- </form> -->

</div><!-- /#right-panel -->

 <!-- <?php 
 //include('bootstrap_datatable_javascript_library.php'); ?> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

   <?php include('datatable_links.php'); ?>


 <script>
 	"use strict";
$(document).ready(function(){

 			function custom_params() {
                let new_form_data = {
	                admission_grade : $("#admission_grade").val(),
	                previous_grade : $("#previous_grade").val(),

	                previous_result : $('#previous_result').val(),
	                
	                per1 : $("#per1").val(),
	                per2 : $("#per2").val(),
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[2,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: ['copy', 'csv', 'excel', 'print' ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
                    // dom: "rtiS",
					// "columns": [
					// {"name": "first", "orderable": "false"}],

					"ajax":{
						'url' :"view_online_admission_table_data.php", // json datasource
						'type': "post",  // method  , by default get
						'data': function(d){
						// ClassType: classtype,
                        d.custom = custom_params() 

						},
						error: function(response){  // error handling
							$(".grid-error").html("");
							$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#grid_processing").css("display","none");
							
						}
						
					},
					"columnDefs": [ { orderable: false, targets: [0] }]
			});
			$('#search').on('click',function(e){
				e.preventDefault();
				$('#table-grid').DataTable().ajax.reload();
			});
			$('#reset').on('click',function(){
				$('#table-grid').DataTable().ajax.reload();
			});

			// $('#RequestAdmisssion').on('click',function(e){
			// $(document).on('submit','#RequestAdmisssion',function(e){
			$('form').on('submit',function(e){
				e.preventDefault();
				if($('.checkboxall:checked').serialize() !=''){
				
				if(confirm("Please check the message. which you want to send.")){

				console.log($('.checkboxall:checked').serialize());
				var msg=$('textarea[name=message]').text();
				var datastring=$('.checkboxall:checked').serialize() +'&message='+msg +'&Request_for_Admission=' + 1;

				$('#RequestAdmisssion').attr('disabled',true);
				$('#RequestAdmisssion').val('Please wait...');
				
				// $('input[name="chk"]:checked').each(function() {
				// $('#checkrow:checked').each(function() {
				// // alert(12);
				// // 	if($('#checkrow').is(':checked')){
				// // 	// $('#checkrow').is(':checked').val();
				// // 	   console.log(this);
				// // 	}
				// 	console.log($('.checkboxall:checked').val());
				// 	});
			
				$.ajax({              		
					type: "POST",         
					url : 'AjaxHandler.php',  
					data : datastring, 
					// contentType: false,  
					// cache: false,     
					// processData:false,              	
					success: function (responce) {    
					var responce = JSON.parse($.trim(responce));
						if(responce.type=='success') {
				            toastr.success(responce.msg);	
				            $('#RequestAdmisssion').attr('disabled',false);
				            $('#RequestAdmisssion').val('Request for Admission');
				   		    setInterval(function(){ 	
				   				// $('#attendance').empty();	
				   							 // window.location.reload();
				   				window.location.href = "dashboard.php?option=view_online_admission";
				   							 				},3000);

					    }else{
					    	// alert("SMS not sent");
					    	 toastr.error("Something error Please try again");
					    	 $('#RequestAdmisssion').attr('disabled',false);
				             $('#RequestAdmisssion').val('Request for Admission');	

					    } 
					}
				});
			}
			
			}else{
					alert("Please select at least one student.");
			}


			});
			});
</script>

 <script>

 $(document).ready(function(){

	$("#selectall").click(function(){

		if(this.checked){

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', true);				

			})

		}else{

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', false);

			})

		}

		

	});
});

	// $("input[type=reset]").click(function(){
		// alert(1);
		// $('.reset').each(function(){
		// 	// alert(this);
		// 	// $(this).trigger('reset');
		// 	document.getElementsByClassName("reset").reset();
		// });
		// const collection = document.getElementsByClassName("reset").reset();
        //       for (i = 0; i < collection.length; i++) {
        //       	collection[i].reset;
		// 	} 

	// })

 // }); 

 </script>

 				<!-- <tbody>

									<?php 

									$sr=1;
									if($query){

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['admission_id'];

									$refno=$res['reference_no'];

									$name=$res['name'];

									$fathername=$res['fathername'];

									$gender=$res['gender'];

									$phone=$res['phone'];

									$prev_school=$res['previous_school'];

									$gradeid=$res['previous_grade'];

									$q3 = mysqli_query($con,"select * from grade where grade_id='$gradeid'");

									$r3 = mysqli_fetch_array($q3);

									$prev_grade = $r3['grade_name'];

									$prev_perc=$res['previous_percentage'];

									$address=$res['address'];

									$city=$res['city'];

									$state=$res['state'];

									

									?>

									<tr>

										<td><?php echo $refno; ?></td>

										<td><?php echo $name; ?></td>

										<td><?php echo $fathername; ?></td>

										<td><?php echo $gender; ?></td>

										<td><?php echo $phone; ?></td>

										<td><?php echo $prev_school;?></td>

										<td><?php echo $prev_grade;?></td>

										<td><?php echo $prev_perc; ?></td>

										<td><?php echo $address; ?></td>

										<td><?php echo $city; ?></td>

										<td><?php echo $state; ?></td>

										<td><input type="checkbox" class="checkboxall" name="chk[]" value="<?php echo $id;?>" style="margin-left:20px;"></td>

										

									</tr>

                                    <?php $sr++; } } ?>

                                    </tbody> -->