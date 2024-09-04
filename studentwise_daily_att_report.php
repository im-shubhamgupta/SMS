<?php
include_once('myfunction.php');
error_reporting(1);


?>



	<style>



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

<div id="right-panel" class="right-panel studentwise_daily_att_report">

<!-- breadcrumb-->

<style>




</style>

<nav class="breadcrumb" style="width:1050px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Student Panel</a>

  <a class="breadcrumb-item" href="#"> Daily Attendance</a>

  <span class="breadcrumb-item active">Student Wise Daily Attendance Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=studentwise_daily_att_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">
<!-- 
                    <div class="col-md-12">



						<div class="row" style="">	 -->

						

							<div class="col-md-1" style="font-size:18px;">Class</div>
							<div class="col-md-2" style="">
								<!-- onchange="search_sec(this.value)" -->
							<select name="class" class="form-select" id="classid"  style="width:175px;" autofocus required>

							<option value="" selected="selected" >Select Class</option>

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
						   

							

							<div class="col-md-2 offset-1"  style="">Section </div>

							<div class="col-md-2" style="margin-left:-100px;">

							<select class="form-select" name="section" id="search_sect"  style="width:175px;" autofocus >
								<!-- onchange="searchstudent(this.value)"   -->

							<option value="" selected="selected" disabled>Select Section</option>

					

							<!-- <option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							</option>
 -->
							<?php 

							// }

							?>							

							</select>	

													

							<script>

							function search_sec(str)

							{

							// var xmlhttp= new XMLHttpRequest();	

							// // xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);
							// xmlhttp.open("get","search_section_by_ajax.php?cls_id="+str,true);

							// xmlhttp.send();

							// xmlhttp.onreadystatechange=function()

							// {

							// if(xmlhttp.status==200  && xmlhttp.readyState==4)

							// {

							// document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

							// }

							// } 

							}

							</script>

							</div>

							

							<script>

							// function searchstudent(str)

							// {

							// var xmlhttp= new XMLHttpRequest();	

							// xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);

							// xmlhttp.send();

							// xmlhttp.onreadystatechange=function()

							// {

							// if(xmlhttp.status==200  && xmlhttp.readyState==4)

							// {

							// document.getElementById("student").innerHTML=xmlhttp.responseText;

							// }

							// }

							// }

							</script>

							<div class="col-md-2 offset-1">

							<input type="submit" name="search" id="load_btn" class="btn btn-primary btn-md col-6" style="" value="Load">
							</div>

							<div class="col-md-2 ">

							 <input type="reset" name="reset" class="btn btn-info btn-md col-6" style="" id="reset_btn" value="Reset"> 
							</div><br><br>
				</div>
				<!-- <div class="row"> ( <u> Optional Filters </u> )</div><br> -->
				<br>
				<div class="row"> 
							

					<div class="col-md-2" style="font-size:14px;">From Date or <br> Current Date </div>

					    <div class="col-md-2" style="margin-left:-80px;">

							<input type="date" name="fromdt" id="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>"  >

						</div>							


							<div class="col-md-1 offset-1" style="font-size:14px; margin-left:65px;">To Date</div>

							<div class="col-md-2" style="">

							<input type="date" name="todt" id="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>"  >

							</div>

								

							<!-- <div class="col-md-1 offset-1"  style="font-size:14px;">Student Name</div>

							<div class="col-md-2" style="margin-left:0px;">

							<select class="form-control" name="student" id="student" style="width:175px;"  >

							<option value="" selected="selected" >Select Student</option>

							<?php

							$qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");

							while($rstu=mysqli_fetch_array($qstu))

							{

							?>

							<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>

							</option>

							<?php 

							}

							?>							

							</select>	

							</div>								
							 -->

							

						</div><br>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered"> -->
                                	<table id="table-grid" class="table table-striped table-bordered " >

                                    <thead>

                                        <tr>

										<th width="5%">Sl. No.</th>
										<th>Register no.</th>
										<th>Student Name</th>
										<th>Class</th>
										<th>Roll no.</th>

										<th>Attendance Date</th>

										<th>Attendance</th>

										<th>Reason</th>
									</tr>

                                    </thead>

                                </table>

                            </div>

                        </div>

					

	<div class="row">

	<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid red">

	<?php 

	// if(isset($search))

	// {

		// $fdate = date("Y-m-d",strtotime($fromdt));

		// $sdate = date("Y-m-d",strtotime($todt));

		

		// $date1=date_create($fdate);

		// $date2=date_create($sdate);

		// $diff=date_diff($date1,$date2);

		// $tdays = $diff->format("%a")+1;



		//$holiday=$absent+$leave;
		// if($rowcount>0){

		// $att_per = round(($present+$leave)/$rowcount*100,2)."%";

	

	echo "<p style='font-size:18px;line-height:30px;color:black;padding:10px;'>

			Attendance Taken : <span id='att_taken'>0</span><span> students</span><br/>

			Present :  <span id='att_present'>0</span><span> days</span><br/>

			Absent :  <span id='att_absent'>0</span><span> days</span><br/>

			Leave :  <span id='att_leave'>0</span><span> days</span><br/>

			Attendance Percentage :  <span id='att_per'>0</span></p>";
		// }

	// }

	?>

	</div>						

	</div><br>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		</form>	

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

			

			<!-- <a href="javascriptvoid;" onclick='report_excel_data()' style="margin-left:20px;" class="btn btn-success">

			<i class="fa fa-download"></i> Download To Excel</a> -->
			<!-- <button class="btn btn-success" type="submit" name="export_excel" onclick="report_excel_data()"><i class="fa fa-download"></i> Download To Excel</button> -->


			

		</div>

		

	
		
    </div><!-- /#right-panel -->


 <!-- <?php// include('bootstrap_datatable_javascript_library.php'); ?> -->
<?php include('datatable_links.php'); ?>

<!-- <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> -->

 <script>
 	// alert(12);
 	// "use strict";
 		function report_excel_data(){
				var classid= $("#classid").val();
	            var sectionid = $("#search_sect").val();
	                
	            var fromdt = $("#fromdt").val();
	            var todt = $("#todt").val();
				// var DispFrom =$('#DispFrom').val();
				// console.log(startdate + enddate + Sales);//'&DispType='+DispType+
				window.location ='export_excel_report.php?classid='+classid+'&sectionid='+sectionid+'&fromdt='+fromdt+'&todt='+ todt+'&student_daily_attendance_report='+ 1 ;
				// window.location ='report.php?startdate='+startdate+'&enddate='+enddate+'&Status='+Status+'&Sales='+Sales+'&DispFrom='+DispFrom+'&SalesWiseExcelReport=0';
			}
	$(document).ready(function(){
 			function custom_params() {
                let new_form_data = {

	                classid : $("#classid").val(),
	                sectionid : $("#search_sect").val(),
	                
	                fromdt : $("#fromdt").val(),
	                todt : $("#todt").val(),
	                
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[[3,'desc'],[6,'asc']],
                    dom: 'Blfrtip',
                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					// "responsive": true,
					"ajax":{
						'url' :"studentwise_daily_att_report_table_data.php", // json datasource
						'type': "post",  // method  , by default get
						'data': function(d){
						// ClassType: classtype,
                        d.custom = custom_params() 

						},
						/* 'data': {
								orderType: ordertype,
						}, */
						error: function(response){  // error handling
							$(".grid-error").html("");
							$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#grid_processing").css("display","none");
							
						}
						
					}
			});
			
			$('#classid').on( "change", function() {
				
				var classid = $("#classid").val();
				var datastring='classid='+ classid + '&getsection_by_classid=' + 1 ;
			
				$.ajax({
					url:"AjaxHandler.php",
					type:"POST",
					data:datastring,
					// contentType:false,
					cache:false,
					// processData:false,
					success:function(responce) {
			        // var result = JSON.parse(responce);
			        console.log(responce); 	
						$('#search_sect').html(responce);
				
			          // $('#table-grid').DataTable().ajax.reload();
			      }
			});
			});
			$('#load_btn').on("click",function(e){
				e.preventDefault();

				var classid = $("#classid").val();
				var sectionid = $("#search_sect").val();
				var fromdt = $("#fromdt").val();
	            var todt = $("#todt").val();

				var datastring='classid='+ classid + '&sectionid=' + sectionid + '&fromdt='+ fromdt + '&todt=' + todt + '&getAttendenceDetails=' + 1 ;
			
				$.ajax({
					url:"AjaxHandler.php",
					type:"POST",
					data:datastring,
					// contentType:false,
					cache:false,
					// processData:false,
					success:function(responce) {
						
			        var result = JSON.parse(responce);
			        // console.log(responce); 	

			        	$('#att_taken').text(result.total);
			        	$('#att_present').text(result.present);
			        	$('#att_absent').html(result.absent);
			        	$('#att_leave').html(result.leave);
			        	$('#att_per').html(result.percent);
						// $('#search_sect').html(responce);
				
			          // $('#table-grid').DataTable().ajax.reload();
			      }
			    });

				 $('#table-grid').DataTable().ajax.reload();
			});
			// $('#reset_btn').on( "click", function() {
			// 	// alert(12);
			//     $('#table-grid').DataTable().ajax.reload();
			// });
			// $('#search_sect').on( "change", function() {
			//     $('#table-grid').DataTable().ajax.reload();

			// });
			
			// $('#fromdt').on( "change", function() {
			// 	// alert(12)
			//     $('#table-grid').DataTable().ajax.reload();

			// });
			// $('#todt').on( "change", function() {
			//     $('#table-grid').DataTable().ajax.reload();

			// });

		
			
	});

 </script>

  <!-- <tbody>

									<?php

									$i=1;

									$present=0;

									$absent=0;

									$leave=0;

									if(isset($search_result)){

									$rowcount=mysqli_num_rows($search_result);

									while($res1=mysqli_fetch_array($search_result))

									{

									 $ndate=$res1['date'];

									 $chgdate=date('d-m-Y',strtotime($ndate));



									 $attend=$res1['type_of_attend'];
									 $student_id=$res1['student_id'];

									 if($attend==1)

									 {

										$present=$present+1; 

									 }

									 else if($attend==2)

									 {

										 $absent=$absent+1;

									 }

									 else if($attend==3)

									 {

										 $leave=$leave+1;

									 }

									 

									 

									 $queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");

									 $ratt=mysqli_fetch_array($queatt);

									 // $attname=$ratt['short_name'];
									 $attname=$ratt['att_type_name'];

									 

									 $reason=$res1['reason'];

									?>

									<tr>

									<td><?php echo $i; ?></td>

									<td><?php echo getStudent_byStudent_id($student_id)['register_no']; ?></td>
									<td><?php echo getStudent_byStudent_id($student_id)['student_name']; ?></td>
								
									<td><?php echo $chgdate; ?></td>

									<td><?php echo $attname; ?></td>

									<td><?php echo $reason; ?></td>

									</tr>

									<?php

									$i++;

									}	
									}									

									?>		

                                    </tbody> -->

 

 