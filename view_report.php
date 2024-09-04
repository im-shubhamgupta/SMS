<?php

error_reporting(1);

extract($_REQUEST);



?>



	<style>
		table #table-grid {
/*		    width: 100% !important;*/
/*		    overflow-x: auto;*/
	       width:inherit !important;
		}
		.table{
			  width: 100% !important;
		}
/*		html, body {margin: 0; height: 100%; overflow-x: hidden}*/




	</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>
<!-- class="right-panel" -->
<div id="right-panel" >

<!-- breadcrumb-->


<!-- style="width:1030px" -->
<nav class="breadcrumb" >

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">View Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=view_report" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select name="class" id="class" class="form-select" onchange="searchtest(this.value);search_sec(this.value)" style="width:195px;" autofocus required>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = "select * from class";

							$rcls = mysqli_query($con, $scls);

							while( $rescls = mysqli_fetch_array($rcls) ) {

							?>

							<!-- <option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?> -->
							<option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>					

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">

							<select class="form-select" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

							<?php

							// $qsec=mysqli_query($con,"select * from section where class_id='$class'");

							// while($rsec=mysqli_fetch_array($qsec))

							// {

							// $secname=$rsec['section_name'];

							// ?>

							<!-- // <option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							// </option> -->

							 <?php 

							// }

							?>							

							</select>	

							</div>

							<script>

							function searchtest(str)

							{

							var clsid = $('#class').val();

							//alert(clsid);

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_test").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>	

						</div><br><br>

                     

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="margin-left:20px;">Test Name </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
									<!-- onchange="searchsub(this.value)" -->
							<select class="form-select" name="test" id="search_test" 

							style="width:195px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							<?php

							// $quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");

							// while( $rtest= mysqli_fetch_array($quet) ) {

							// ?>

							<!-- // <option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>

							// </option> -->

							<?php //} ?>	

							</select>

							</div>							

							<script>

							function searchsub(str)

							{

							var clsid = $('#class').val();

							var secid = $('#search_sect').val();

							//alert(secid);

							var xmlhttp = new XMLHttpRequest();

							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200 && xmlhttp.readyState==4)

							{

							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	

							}									

							}

							}

							</script>



							<div class="col-md-2">

							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:142px;" value="Load"><br><br>

							</div>
							<span id="error"></span>
						</div><br>

								

						<!--table starts from here-->

						

						<?php

						// if(isset($load))

						// {

													

						?>	

						<div class="card">

						<div class="card-body">

						<p>MARKS REPORT</p>
						<div id="header_name">
							
						</div>

						 </div>	

						 </div><br><br>

						 		

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

		<!-- <div class="row">

		<div class="col-md-12" align="center">

		<a href="export_view_report.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>" style="margin-left:20px;" class="btn btn-success">Download To Excel</a>

		</div>

		</div> -->

		

						<?php

						// }

						?>								

                         

	</form>	

    </div><!-- /#right-panel -->



 <!-- <?php
 // include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
 </script>
	<!-- ------------------ -->
	<script>
		"use strict";
	
	 $(document).ready(function(){
	 	$('form').on('submit',function(e){
			e.preventDefault();

			// alert("load");
			var flag=1;
			var  classname =$('#class').val();
			var search_test=$('#search_test').val();
			var search_sub=$('#search_sub').val();
			if(classname==''){
			
				$('#error').html("*Please select class");

				flag=1;
			}else if(search_test=''){
				$('#error').html("*Please select Test name");

			}else if(search_sub==''){
				$('#error').html("*Please select Subject");

			}else{

			// $("#update_btn").show();
			// $("#show_table").show();
			// var searchtestname=$('#search_test').find(':selected').val();
			// $('#ntestname').val(searchtestname);

			
			// $("input[type='hidden']").removeAttr('name'); 	     
			var action ='LoadReportFormat';        
			$(this).append('<input type="hidden" name="'+ action+'" id="LoadReportFormat" />');          			          
			var formData =new FormData($('#devel-generate-content-form')[0]);		            		 
				$.ajax({              
					type: "POST",                
					url : 'Controllers/TestExamController.php',             
					data : formData,                
					contentType: false,               
					cache: false,                
					processData:false,              
					success: function (responce) { 
					// alert(responce);                
					$('#header_name').html(responce);

					 var dataTable = $("#table-grid").DataTable({
		                    "lengthMenu": [ [10, 25, 50, 100, 200, 500,99999999], [10, 25, 50, 100, 200, 500, 'All'] ],	
		                    // 'order':[2,'DESC'],
		                    "scrollX": true,
		                    dom: 'Blfrtip',

		                    "pageLength":25,
		                    buttons: [
		                    'copy', 'csv', 'excel', 'print'
		                    ]
					 });
					// function custom_params() {
		            //     let new_form_data = {
		            //     class_id : $("#class").val(),
		            //     section_id : $("#search_sect").val(),
		            //     testname : $("#search_test").val(),
			        //     }	    
			        //     return new_form_data;
			        //     }  
		        	
					// var dataTable = $("#table-grid").DataTable({
		            //         "lengthMenu": [ [10, 25, 50, 100, 200, 500,99999999], [10, 25, 50, 100, 200, 500, 'All'] ],	
		            //         'order':[2,'DESC'],
		            //         dom: 'Blfrtip',

		            //         "pageLength":25,
		            //         buttons: [
		            //         'copy', 'csv', 'excel', 'print'
		            //         ],
					// 		"processing": true,
					// 		"serverSide": true,
		            //         "scrollX": true,
					// 		"ajax":{
					// 			'url' :"view_report_table_data.php", // json datasource
					// 			'type': "post",  // method  , by default get
					// 			'data': function(d){
					// 			// ClassType: classtype,
		            //             d.custom = custom_params() 

					// 			},
					// 			/* 'data': {
					// 					orderType: ordertype,
					// 			}, */
					// 			error: function(response){  // error handling
					// 				$(".grid-error").html("");
					// 				$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					// 				$("#grid_processing").css("display","none");
									
					// 			}
								
					// 		}
					// });	
					 // $('#marks_submit').show();	
					 // $('#table-grid').DataTable().ajax.reload();
                    // $("#updatetest").prop('disabled', false);					
					}	
				 }); 
			}
		});	 







 			
			// $("input[type='submit']").on( "click", function(e) {
			// 	// e.preventDefault();
			// 	// alert(1);
				
			//     $('#table-grid').DataTable().ajax.reload();
			// });
			



				});

 </script> 


 
 	

 