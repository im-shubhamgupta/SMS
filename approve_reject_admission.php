<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');


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

  <span class="breadcrumb-item active">Online Admission</span>

</nav>



	<!-- <form method="post" action="dashboard.php?option=search_with_reference" enctype="multipart/form-data"> -->

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:10px;">Enter Reference Number</div>

								<div class="col-md-3">

								<input type="text" name="refno" id="reference_no" value="" class="form-control"/>

								</div>
								<div class="col-md-1" style="margin-left:10px;"> Grade </div>

								<div class="col-md-3">
									<select name="admission_grade" class="form-control" id="admission_grade" autofocus >

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

								

								<div class="col-md-3" style="margin-left:30px;">

								<!-- <input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit">-->
									<br>

								</div>

							</div>	

														

							

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sl No.</th>
                                             <th>Reference No.</th>

                                             <th>Requested On</th>

											 <th>Name</th>

											 <th>Father Name</th>

											 <th>Gender</th>

											 <th>Mobile No.</th>

											 <th>Requested for Admission</th>

											 <th>Previous School</th>

											 <th>Previous Grade</th>

											 <th>Previous Grade Percentage</th>

											 <th>Address</th>

											 <th>City</th>

											 <th>State</th>

											 <th>Accept</th>

											 <th>Decline</th>

                                        </tr>

                                    </thead>

                                  

                                </table>

                            </div>

							

							

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	<!-- </form> -->

</div><!-- /#right-panel -->

 <!-- <?php
 // include('bootstrap_datatable_javascript_library.php'); ?> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
 <?php include('datatable_links.php'); ?>


 <script>
 				
$(document).ready(function(){
	// toastr.options = {		
 	// 	"closeButton": true, 
	// 	"debug": false,"newestOnTop": false,
	// 	"progressBar": true,
	// 	// "positionClass": "toast-bottom-right",	
	// 	"preventDuplicates": false,	

	// 	"onclick": null,	
	// 	"showDuration": "300",
	// 	"hideDuration": "1000",	
	// 	"timeOut": "5000",		
	// 	"extendedTimeOut": "1000",
	// 	"showEasing": "swing",	
	// 	"hideEasing": "linear",	
	// 	"showMethod": "fadeIn",
	// 	"hideMethod": "fadeOut"	
	// 	};	

 			function custom_params() {
                let new_form_data = {

	                reference_no : $("#reference_no").val(),
	                admission_grade : $("#admission_grade").val(),
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[13,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"view_approve_reject_admission_table_data.php", // json datasource
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
						
					}
			});
			$('#reference_no').on( "keyup", function() {
			    $('#table-grid').DataTable().ajax.reload();

			});
			$('#admission_grade').on( "change", function() {
			    $('#table-grid').DataTable().ajax.reload();

			});
			});

</script>
<script type="text/javascript">

	function decline(id){

		var reason=prompt("Enter Reason for Decline.");

		if(reason==""){

		    alert("Please Enter Reason ???");

		}else if(reason){	
			 
			var	datastring='id='+ id +'&reason='+ reason +'&reject_Student='+ 1 ; 
	           
	        $.ajax({              	
	 		    type: "POST",    
	 		    url : 'AjaxHandler.php', 
	 		    data : datastring,
	 		    // contentType: false,   
		    	// cache: false,    
		    	// processData:false, 
		    	success: function (responce) {  
			    	var responce = JSON.parse(responce);	
	 		    	    if(responce.type=='success') { 
	 		    	        toastr.success(responce.msg);	 
	 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},2000);		
	 		    	    	
	 		    	    }else{      
	 		    	    	// $('#registration_btn').attr('disabled',false);
	 		    	    	// $('#error').html(responce.msg);
	 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
	 		    	    }
	 		  	    }	
	 		  	});
	 	
	 		
		
			    // window.location.href="update_admission_ref_decline.php?x=" + id + "& rea=" +reason;

			return true;

		}else{	

		return false;

		}

	}
	function Approve(id){
		if(confirm("Do you want to Approve")){
		// var id=id;	
		 
		var	datastring='id='+ id +'&approve_Student='+ 1 ; 
		// alert(datastring);
           
        $.ajax({              	
 		    type: "POST",    
 		    url : 'AjaxHandler.php', 
 		    data : datastring,
 		    // contentType: false,   
	    	cache: false,    
	    	// processData:false, 
	    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.type=='success') {  
 		    	    	 // $('#registration_btn').attr('disabled',false);
 		     		  	 // $('#error').html(""); 
 		    	    	toastr.success(responce.msg);		
 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},2000);
 		    	    }else{      
 		    	    	// $('#registration_btn').attr('disabled',false);
 		    	    	// $('#error').html(responce.msg);
 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
 		    	    }
 		  	    }	
 		  	});
 	
 		
		}else{
			return false;
		}

	}

		

</script>
<!-- 
  <tbody>

									<?php 

									$sr=1;
									if($query){
									while($res=mysqli_fetch_array($query))

									{

									$id=$res['admission_id'];

									$refno=$res['reference_no'];

									$reqdt=$res['requested_date'];

									$newreqdt=date("d-M-y",strtotime($reqdt));

									$name=$res['name'];

									$fathername=$res['fathername'];

									$gender=$res['gender'];

									$phone=$res['phone'];

									$grade=$res['grade'];

									$scls = mysqli_query($con,"select * from class where class_id='$grade'");

									$rescls = mysqli_fetch_array($scls);

									$classname = $rescls['class_name'];

									$prev_school=$res['previous_school'];

									$prev_grade=$res['previous_grade'];

									$scls1 = mysqli_query($con,"select * from class where class_id='$prev_grade'");

									$rescls1 = mysqli_fetch_array($scls1);

									$prevclassname = $rescls1['class_name'];

									$prev_perc=$res['previous_percentage'];

									$address=$res['address'];

									$city=$res['city'];

									$state=$res['state'];

									

									

									?>

									<tr>

										<td><?php echo $refno; ?></td>

										<td><?php echo $newreqdt; ?></td>

										<td><?php echo $name; ?></td>

										<td><?php echo $fathername; ?></td>

										<td><?php echo $gender; ?></td>

										<td><?php echo $phone; ?></td>

										<td><?php echo $classname; ?></td>

										<td><?php echo $prev_school;?></td>

										<td><?php echo $prevclassname;?></td>

										<td><?php echo $prev_perc; ?></td>

										<td><?php echo $address; ?></td>

										<td><?php echo $city; ?></td>

										<td><?php echo $state; ?></td>

										

										<td>

										<a onclick="return confirm('Do you want to Accept.')" href="dashboard.php?option=update_admission_accept&id=<?php echo $id;?>&page=search_with_reference" class="btn btn-success" style="width:100px;border-radius:20px">Accept</a>

										</td>

										

										<td>

										<a href="#" class="btn btn-danger" onclick="decline('<?php echo $id;?>')" style="width:100px;border-radius:20px">Decline </a>

										

										<!--<a onclick="return confirm('Do you want to Decline.')" href="dashboard.php?option=update_leave_disapprove&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-danger" style="width:100px;border-radius:20px">Decline</a>

										-->

										<!--</td>

									</tr>

                                    <?php $sr++; }  }?>

                                    </tbody> -->
