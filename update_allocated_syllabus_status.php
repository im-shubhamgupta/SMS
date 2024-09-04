<?php

error_reporting(1);

extract($_REQUEST);






?>





<div id="right-panel" class="right-panel">



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Syllabus Management</a>  

  <span class="breadcrumb-item active">Update Allocated Syllabus Status</span>

</nav>



	<form method="post" action="dashboard.php?option=update_allocated_syllabus_status" enctype="multipart/form-data">

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

					<div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px;">Select Staff :</div>

							<div class="col-md-2" style="margin-left:-40px;margin-top:-10px">

							<select style="width:175px;" class="form-control" name="faculty" id="faculty" onchange="search_assign_class(this.value)" 

							autofocus required>

							<option value="" selected="selected" disabled >Select Staff</option>

							<?php

							$squ = mysqli_query($con,"select * from staff where status='1'");

							while( $rsqu = mysqli_fetch_array($squ)) 

							{

							?>

							<option <?php if($faculty==$rsqu['st_id']){echo "selected";}?>  value="<?php echo $rsqu['st_id']; ?>"><?php echo $rsqu['staff_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<script>

							function search_assign_class(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_assign_class.php?st_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("class").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>

		

							<div class="col-md-2" style="margin-left:60px;">Class : </div>

							<div class="col-md-2" style="margin-top:-10px">

							<select style="width:175px;margin-left:-70px;" name="class" id="class" class="form-control" onchange="search_subject(this.value);search_sec(this.value)"  autofocus required>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = mysqli_query($con,"select * from class where class_id='$class'");

							while($rcls = mysqli_fetch_array($scls)) 

							{

							?>

							<option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

							</option>

							<?php } ?>	

							</select>	

							</div>

							

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							

							var stid = document.getElementById("faculty").value;

							xmlhttp.open("get","search_ajax_assign_section.php?stid="+stid+"&cls_id="+str,true);

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

						</div><br>

						

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px;">Section :</div>

							<div class="col-md-2" style="margin-left:-40px;margin-top:-10px">

							<select style="width:170px;" class="form-control" name="section" id="search_sect" onchange="search_subject(this.value);" required>

							<option value="" selected disabled>Select Section</option>

							<?php

							$qsec = mysqli_query($con,"select * from section where section_id='$section'");

							while($rsec = mysqli_fetch_array($qsec)) 

							{

							?>

							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name']; ?>

							</option>

							<?php } ?>

							</select>

							</div>

							

							<script>

							function search_subject(str)

							{

							var xmlhttp= new XMLHttpRequest();

							var stid = document.getElementById("faculty").value;

							var clid = document.getElementById("class").value;

							xmlhttp.open("get","search_ajax_assigned_subject_staff.php?stid="+stid+"&clid="+clid+"&secid="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_subj").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>

		

							<div class="col-md-2" style="margin-left:60px;">Subject :</div>

							<div class="col-md-2" style="margin-top:-10px">

							<select style="width:170px;margin-left:-70px;" name="subject" id="search_subj" class="form-control" autofocus required>

							<option value="" selected="selected" disabled>Select Subject</option>

							<?php

							$qsub = mysqli_query($con,"select * from subject where subject_id='$subject'");

							while($rsub = mysqli_fetch_array($qsub)) 

							{

							?>

							<option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>

							</option>

							<?php } ?>

							</select>	

							</div>
							

						</div>
						<div class="row"  style="margin-top:20px;">

							<div class="col-md-9">
									<p><u>(optional Filters)</u></p>
							</div>
							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;margin-left:40px;width:120px;" value="Load"><br><br>

							</div>
						</div>
						
				
						<div class="row" style="margin-top:10px;">	

							<div class="col-md-2" style="margin-left:20px;">From Date :</div>

							<div class="col-md-2" style="margin-left:-40px;margin-top:-10px">

							<input type="date" name="fromdt" value="<?php echo $fromdt; ?>" class="form-control" style="width:170px;"  autofocus>

							</div>

									

							<div class="col-md-2" style="margin-left:60px;">To Date :</div>

							<div class="col-md-2" style="margin-top:-10px">

							<input type="date" name="todt" value="<?php echo $todt; ?>" class="form-control" style="width:170px;margin-left:-70px;"  autofocus>

							</div>

							

							

						</div><br>

                        

                        <div class="card">

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

											<th>Staff</th>

											<th>Class</th>

											<th>Section</th>

											<th>Subject</th>

											<th>Chapter</th>

											<th>From</th>

											<th>To</th>

											<th>Days</th>

											<th>Description</th>

											<th>Action</th>

										</tr>

                                    </thead>

                                    <tbody id="tbody">


                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>

</div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
<?php include('datatable_links.php');?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
// 	$(document).ready(function(){	
  // toastr.options = {		
 // 		"closeButton": true, 
// 		"debug": false,"newestOnTop": false,
// 		"progressBar": true,
// 		"positionClass": "toast-bottom-right",	
// 		"preventDuplicates": false,	

// 		"onclick": null,	
// 		"showDuration": "300",
// 		"hideDuration": "1000",	
// 		"timeOut": "3000",		
// 		"extendedTimeOut": "1000",
// 		"showEasing": "swing",	
// 		"hideEasing": "linear",	
// 		"showMethod": "fadeIn",
// 		"hideMethod": "fadeOut"	
// 		};					}); 


</script>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// console.log(this);
	// alert(12);
  var action ="Load_Update_Allocated_Syllbus_Format";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StaffController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			// var result = JSON.parse(responce); 
			// alert(responce);
			// console.log(responce);
			if($.trim(responce)!=""){
				$('#tbody').html(responce);
				
				 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });

			}else{
				$('#tbody').html("<center>No data found</center>");
			}
			
			// if(result.type=="success"){
			// 	// alert('success');
			// 	// toastr.success(result.msg); 
			// 	// setInterval(function(){ 
			// 	// window.location.href='dashboard.php?option=assign_subject';
			// 	// },3000);
			// }
		
			// else if(result.type=="error"){
			// 	toastr.error(result.msg); 
			

			// }
			  $("input[type='submit']").val("Load");  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>