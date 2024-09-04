<?php
error_reporting(1);

extract($_REQUEST);



if(isset($sms))

{

	$qs1=mysqli_query($con,"select * from sms_setting where sms_id='2'");

	$rs1=mysqli_fetch_array($qs1);

	$status=$rs1['status'];

	if($status==1 && get_whatsapp_sms_count()['count_sms'] > 0){


	    echo "<script>window.location='send_sms_result.php?class=$class&section=$section&test=$test'</script>";

	}else{



	echo "<script>alert('Check SMS Limit & Permission to send SMS')</script>";	

	}



}



?>

	<style>
table#table-grid {
	width: 100%;
}
table{
	width:100% !important;
}
	/*tr th{

		font-size:11px;

	}

	tr td{

		

		font-size:11px;

	}*/
/*	table#bootstrap-data-table-export {
    overflow-x: scroll;
    display: block;
}*/


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

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <!-- <a class="breadcrumb-item" href="#">Student Panel</a> -->

  <a class="breadcrumb-item" href="#">Exam & Result Panel</a>
  <a class="breadcrumb-item" href="#">Exam & Result </a>

  <span class="breadcrumb-item active">Send Result</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=send_result" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>

							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">

							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" style="width:180px;" autofocus required>

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:120px;">Section </div>

							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>

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

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Test Name </div>

							<div class="col-md-4" style="margin-left:-20px;margin-top:-10px;">

							<select class="form-control" name="test" id="search_test" onchange="searchsub(this.value)"

							style="width:180px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							<?php

							$quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");

							while( $rtest= mysqli_fetch_array($quet) ) {

							?>

							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>

							</option>

							<?php } ?>	

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

							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:80px;" value="Load"><br><br>

							</div>

						</div><br>

								

						<!--table starts from here-->

						

						<?php

						if(isset($load))

						{

							

						?>	

						<div class="card">

						<div class="card-body">

						<h6>MARKS REPORT</h6><br>

					    <table id="table-grid" class="table table-striped table-bordered">

							<thead>

								<tr>

									 <th>Sl No.</th>

									 <th>Student Name</th>

									 <th>Parent Name</th>

									 <th>Register No</th>

									 <?php

									 $que = mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test' && session='".$_SESSION['session']."' ");
									 if(mysqli_num_rows($que)>0){	
									 while($rque = mysqli_fetch_array($que))

									 {

										 $subid = $rque['subject_id'];

										 $subidarr[] = $rque['subject_id'];

										 $sque = mysqli_query($con,"select * from subject where subject_id='$subid'");

										 $rque = mysqli_fetch_array($sque);

									 ?>

									 <th><?php echo $rque['subject_name'];?></th>

									 <?php 

									 }
									 }

									 ?>

									 <th>Grade</th>

								</tr>

							</thead>

							<tbody>

							<?php 

							// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."' ");

							$que2 = mysqli_query($con,"select `student_id`,`register_no`,`student_name`,`father_name`,`parent_no`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");
				

							$i=1;	
							if(mysqli_num_rows($que2)>0){							

							while($res2=mysqli_fetch_array($que2)){									

							$stuid = $res2['student_id'];

							$stuname = $res2['student_name'];					

							$fathername = $res2['father_name'];					

							$regno = $res2['register_no'];					

							?>

							<tr>

							<td><?php echo $i; ?></td>

							<td><?php echo $stuname; ?></td>

							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">

							<td><?php echo $fathername;?></td>	

							<td><?php echo $regno;?></td>	

							<?php 

							$total = 0;

							$totalmarks = 0;

							$percent = 0;

							foreach($subidarr as $v)

							{

							$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid' && session='".$_SESSION['session']."' ");
							// if(mysqli_num_rows($que3)>0){
							$res3 = mysqli_fetch_array($que3);

							$stumarks = $res3['marks'];  //show marks

							if($stumarks)

							{

								$marks = $stumarks;

							}

							else

							{

								$marks = 0;

							}

							$tmarks = $res3['max_mark'];

							?>

							<td><?php echo $marks;?></td>

							<?php

							$total = $total+$marks;

							$totalmarks = $totalmarks+$tmarks;
							if($totalmarks==0 || $totalmarks=='' ){  //make due to create error
								$totalmarks=1;
							}

							$percent = round($total/$totalmarks*100,2);

							

							$que4 = mysqli_query($con,"select * from grade where (condition1 <='$percent' && condition2 >='$percent')");

							

							$row = mysqli_num_rows($que4);

							if($row)

							{

								$res4 = mysqli_fetch_array($que4);

								$gr = $res4['grade_name'];

							}

							

							}

							?>

							<td><?php echo $gr;?></td>	

							</tr>

							<?php

							$i++;

							}
						    }

							?>					

						 	</tbody>

						 </table>

						 </div>	

						 </div><br><br>

						 		

                    </div>

                </div>

				

				<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

		<button type="submit" onclick="return confirm('Are you sure want to send SMS')" name="sms" id="add" class="btn btn-primary btn-sm"/><i class="fa fa-envelope"></i> Send SMS </button>

				

		<a href="export_sendresult_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download To Excel</a>

		

		<!-- <a href="print_send_result.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>"   target="_blank"  class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a> -->

		

		

		</div>

				

				

            </div><!-- .animated -->

        </div><!-- .content -->

				 

							<?php

							}

							?>								

                            

                       

<script>

function savesub(x)

{

	//alert(x);

	var testm = 'testid'+x;

	var minm = 'minmark'+x;

	var maxm = 'maxmark'+x;

	if($("#"+x).prop('checked')==true)

	{

		//$("#"+testm).prop('disabled',false);

		$("#"+minm).prop('disabled',false);

		$("#"+maxm).prop('disabled',false);

	}

	else

	{

		//alert(minm);

		//$("#"+testm).prop('disabled',true);

		//$("#"+minm).prop('disabled',true);

		$("#"+minm).val('');

		//$("#"+maxm).prop('disabled',true);

		$("#"+maxm).val('');

	}



}

</script>						

		

<script>

$(document).ready(function(){

	

    var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');

        

    $checkboxes.change(function(){

		

	  var countCheckedCheckboxes = $checkboxes.filter(':checked').length;

	  //alert(countCheckedCheckboxes);

        $('#count-checked-checkboxes').val(countCheckedCheckboxes);

    });



});

</script>	

						

				

		

		

	</form>	

    </div><!-- /#right-panel -->

	<script>

	$('#saveForm').on('click', function() {

		$formdata = new FormData();

		$formdata = $('#devel-generate-content-form').serialize();

		

		

		$.ajax({

			url: 'dashboard.php?option=create_test',

			data: $formdata,

			method:"post",

			success:function(data) {

				alert(data);

			}				

		});

		

	});

	

	</script>



 <!-- <?php //
 //include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
 </script>
	<!-- ------------------ -->
	<script>
		"use strict";
	 $(document).ready(function(){
 			function custom_params() {
                let new_form_data = {
                
	            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500,99999999], [10, 25, 50, 100, 200, 500, 'All'] ],	
                    // 'order':[2,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
                   
					// "processing": true,
					// "serverSide": true,
                    "scrollX": true,
					// "ajax":{
					// 	'url' :"view_report_table_data.php", // json datasource
					// 	'type': "post",  // method  , by default get
					// 	'data': function(d){
						
                    //     d.custom = custom_params() 

					// 	},
					
					// 	error: function(response){  // error handling
					// 		$(".grid-error").html("");
					// 		$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					// 		$("#grid_processing").css("display","none");
							
					// 	}
						
					// }
			});
			});

		</script>

 

 