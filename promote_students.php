<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');

date_default_timezone_set('Asia/Kolkata');

?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{
	.col-md-3{

		width:400px;
	}
}
.ht{
	height:22px;
}
</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <span class="breadcrumb-item ">Student Panel</span>
  <span class="breadcrumb-item active">Promote Students</span>
  <!-- <span class="breadcrumb-item active">Admission Panel</span> -->

</nav>



	<form method="post" id="promote_form" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:10px;"><span>Class :</span>
								</div>

								<div class="col-md-3">
									<!-- onchange="search_sec(this.value)" -->
									<select name="class_id" id="class_id" class="form-select" onchange="search_promote_class(this.value);search_sec(this.value)"  autofocus required >

									<option value="" selected="selected"  >Select Class</option>

									<?php

									$scls = "select * from class";

									$rcls = mysqli_query($con, $scls);

									while( $rescls = mysqli_fetch_array($rcls)){?>

									
									<option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

									</option>

									<?php } ?>							

									</select>

								</div>
								<div class="col-md-2" style="margin-left:10px;"><span>Section : </span>
								</div>

								<div class="col-md-3" style="margin-left:-20px;">
									
									<select name="section_id" id="section_id" class="form-select"  autofocus required >

									<option value="" selected="selected"  >Select Section</option>


									</select>

								</div>

								<div class="col-md-2 ">
									<input type="submit" name="search" id="search" class="btn btn-primary btn-sm col-8" value="Search"><br>

								</div>
								<!-- <div class="col-md-2 ">
									<input type="reset" name="reset" id='reset' class="btn btn-info btn-sm col-8" value="Reset"><br>

								</div> -->
							

							</div>	

							<!-- <div class="row">
								<div class="col-md-12" style="margin-left:30px; margin-top:10px;">
								<span ><u>(Optional Filters)</u></span>
							    </div>
							</div> -->
							
							
							<hr><br>
							<div class="row" style="margin-top:0px;">

								<div class="col-md-2 " style="margin-left:10px;">Promote Class</div>

								<div class="col-md-3">

								<select name="promote_class"  id="promote_class" class="form-select reset" autofocus onchange="search_promote_sec(this.value)" required>

									<option value="" selected disabled >Select Promote Class</option>
									<?php

									// $scls = "select * from class";

									// $rcls = mysqli_query($con, $scls);

									// while( $rescls = mysqli_fetch_array($rcls) ) {?>

									<!-- // <option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

									// </option> -->

									<?php// } ?>	
									
									

								</select>

								</div>

								

								<div class="col-md-2" style="margin-left:10px;">Promote Section</div>

								<div class="col-md-3">

								<select name="promote_section" id="promote_section" class="form-select reset" autofocus required >

								  <option value="" selected >Select Section</option>

								  

								</select>

								</div>

							</div>	

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:10px;">Promote Session</div>
								<div class="col-md-3">

								<select name="promote_session" id="promote_session" class="form-select reset" autofocus required>

								  <option value="" selected >Select Session</option>
								  <?php

									$scls = "select * from session where `id`>'".$_SESSION['session']."' ";

									$rcls = mysqli_query($con, $scls);

									while( $rescls = mysqli_fetch_array($rcls) ) {?>

									<option  value="<?php echo $rescls['id']; ?>"><?php echo $rescls['year']; ?>

									</option>

									<?php } ?>
								 
								</select>

								</div>

								


							</div>
							<script>
								function search_sec(str){
									var xmlhttp= new XMLHttpRequest();	

									xmlhttp.open("get","search_ajax_staff_section1.php?cls_id="+str,true);

									xmlhttp.send();
									xmlhttp.onreadystatechange=function(){

										if(xmlhttp.status==200  && xmlhttp.readyState==4){
										
										document.getElementById("section_id").innerHTML=xmlhttp.responseText;

										}
									} 

								}

								function search_promote_sec(str){
									var xmlhttp= new XMLHttpRequest();	

										xmlhttp.open("get","search_ajax_staff_section1.php?cls_id="+str,true);

										xmlhttp.send();
										xmlhttp.onreadystatechange=function(){

											if(xmlhttp.status==200  && xmlhttp.readyState==4){
											document.getElementById("promote_section").innerHTML=xmlhttp.responseText;
											}
										} 

								}	
								function search_promote_class(class_id){

									var xmlhttp=new XMLHttpRequest();
									xmlhttp.open("get","search_data.php?class_id="+class_id+'&promote_class=1',true);
									xmlhttp.send();
									xmlhttp.onreadystatechange=function(){
										if(xmlhttp.status==200 && xmlhttp.readyState==4){
											document.getElementById("promote_class").innerHTML=xmlhttp.responseText;
											
										}
									}


								}	
								</script>	


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
                                             <th>Register No.</th>

											 <th>Name</th>

											 <th>Father's Name</th>

											 <th>Gender</th>
											 <th>Dob</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Roll No.</th>
											 <th>Parent No.</th>
											 <th>Aadhar card</th>

											 <th>Session</th>

											 <th>Address</th>


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
							
							

<!-- <textarea name="message" class="form-control" style="width:780px;height:200px;margin-left:50px;margin-top:10px;margin-bottom:20px;">Dear Student,

Congratulations, We have shortlisted you for the admission of <?php// echo $clsname;?> as per your interest. Kindly Come for an admission on next working days. Kindly carry the reference number for the admission and necessary documents.

Regards,

<?php// echo $slname;?>
</textarea> -->
<!-- style="margin-left:300px;margin-right:20px;" -->
<div class="row">
<div class="col-md-3">

<!-- <center>	<input type="checkbox" name="check_sms"  value="1" checked  />	<span> Send SMS</span></center> -->
</div>	


<div class="col-md-3">


<input type="submit" name="request" id='RequestPromote' value="Request for Promote" class="btn btn-success btn-sm" />

</div>

<div class="col-md-3">
	<input type="reset" value="Cancel" class="btn btn-primary btn-sm">
</div>
							



</div>	
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
<script>
 	"use strict";
$(document).ready(function(){

 			function custom_params() {
                let new_form_data = {
	                class_id : $("#class_id").val(),
	                section_id : $("#section_id").val(),
	                // promote_class : $("#promote_class").val(),
	                // promote_section : $("#promote_section").val(),
	                // promote_session : $('#promote_session').val(),
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[8,'ASC'],
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
						'url' :"promote_students_table_data.php", // json datasource
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
			// $('#reset').on('click',function(){
			// 	$('#table-grid').DataTable().ajax.reload();
			// });


	$('form').on('submit',function(e){
		e.preventDefault();
	
		if($('.checkboxall:checked').serialize() !=''){
		
		if(confirm("Are you sure want to Promote")){

		// console.log($('.checkboxall:checked').serialize());
		// console.log($(this).serialize());
		var data=$(this).serialize();
		// var msg=$('textarea[name=message]').text();
		// var check_sms=$('input[name=check_sms]').val();
		// var datastring=$('.checkboxall:checked').serialize() +'&message='+msg +'&check_sms='+check_sms +'&Request_for_Promote=' + 1;
		var datastring=data +'&Request_for_Promote=' + 1;

		$('#RequestPromote').attr('disabled',true);
		$('#RequestPromote').val('Please wait...');

		

		$.ajax({              		
			type: "POST",         
			url : 'Controllers/StudentControllers.php',  
			data : datastring, 
			// contentType: false,  
			// cache: false,     
			// processData:false,              	
			success: function (responce) {    
			var responce = JSON.parse($.trim(responce));
				if(responce.type=='success') {
		            toastr.success(responce.msg);	
		   		    setInterval(function(){ 	
		   							 // window.location.reload();
		   				window.location.href = "dashboard.php?option=promote_students";
		   							 				},3000);

			    }
			    else if(responce.type=='empty'){
			    	toastr.error(responce.msg);

			    }else if(responce.type=='error'){
			    	toastr.error(responce.msg);

			    }else{
			    	// alert("SMS not sent");
			    	 toastr.error("Something error Please try again");
			    		

			    } 
			    $('#RequestPromote').attr('disabled',false);
		        $('#RequestPromote').val('Request for Promote');
		        $('#promote_form')[0].reset();
			}

		});
	}
	
	}else{
			alert("Please select at least one student.");
	}


	});
});
</script>



