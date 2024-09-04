<?php
error_reporting(1);
extract($_REQUEST);

?>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

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

<nav class="breadcrumb" style="width:1000px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Exam & Result</a>
  <span class="breadcrumb-item active">View / Update Test</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=update_test" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>
							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">
							<select name="class" id="class" class="form-select" onchange="searchtest(this.value);search_sec(this.value)" style="width:175px;" autofocus required>
							<option value="" selected="selected" disabled>Select Class</option>
							 <?php
							$scls = "select * from class";
							$rcls = mysqli_query($con, $scls);
							while( $rescls = mysqli_fetch_array($rcls) ) {
							?>
							<option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?></option>

							<!-- <option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?> -->
							<!-- </option> -->
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
							<select class="form-select" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:175px;" autofocus required>
							<option value="" selected="selected" disabled>Select Section</option>
							<!-- <?php
							$qsec=mysqli_query($con,"select * from section where class_id='$class'");
							while($rsec=mysqli_fetch_array($qsec))
							{
							$secname=$rsec['section_name'];
							?>
							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
							</option>
							<?php 
							}
							?>	 -->						
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

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Test Name </div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px;">
							<select class="form-select" name="test" id="search_test" style="width:175px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Test</option>
							<!-- <?php
							$quet = "select distinct(test_name) from test";
							$rest = mysqli_query($con, $quet);
							while( $rtest= mysqli_fetch_array($rest) ) {
							?>
							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>
							</option>
							<?php } ?>	 -->
							</select>
							</div>
						</div><br><br>
                     
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2">
							<input type="submit" name="load" id="LoadUpdateSubject" class="btn btn-primary btn-sm" style="margin-top:-80px;width:120px;margin-left:450px;" value="Load"><br>
							</div>
						</div><br>		
						<!--table starts from here-->
						
						<?php
						// if(isset($load))
						// // {
						// 	$q1=mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test' && session='".$_SESSION['session']."'");
						// 	$r1=mysqli_fetch_array($q1);
						?>	
						<div class="card">
						<div class="card-body" id="show_table" style="width:1000px;display: none;" >
						<div class="row" style="margin-top:20px;">
							<!--<div class="col-md-2" style="font-size:14px;margin-left:50px;">Test Date <?php echo $cdate; ?></div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px;">
							<input type="date" name="ntestdate" value="<?php echo $r1['test_date'];?>" class="form-control" style="width:175px;" autofocus required>
							</div>-->
							<!-- <?php// echo $r1['test_name'];?> -->
							<div class="col-md-2"></div>							
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Test Name </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px;">
							<input type="text" name="ntestname" id="ntestname" value="" class="form-control" style="width:175px;" autofocus required>
							</div>
						</div><br>
						
							<!-- <div  style="display: none;">	table-responsive -->
								<P>EXISTING SUBJECTS</p>	
                               <table id="table-grid" class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                             <!-- <th>Sl No.</th> -->
                                             <th>Selection</th>
											 <th>Subject Name</th>
											 <th>Min Marks</th>
											 <th>Max Marks</th>
											 <th>No Of Question</th>
											 <th>Start Date</th>
											 <th>Start Time</th>
											 <th>End Time</th>
											 <th>Room No</th>
											 <th>Action</th>
										
										</tr>
                                    </thead>
                                    <tbody id="LoadSubject">
                                    </tbody>
													
                                 
                                </table>
                            <!-- </div> -->
							</div>	
						 </div><br><br>
						 		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div class="row" id="update_btn" style="display: none;">
		<div class="col-md-3">
		</div>
		<div class="col-md-2" id="check">
		<input type="checkbox" name="check" style="width:20px;height:20px;" checked />
		<span style="margin-left:5px;">Send SMS</span>
		</div>
		<div class="col-md-6">
		<input  type="submit" name="update" id="updatetest" value="Update" class="btn btn-primary btn-md"/>
		<!-- <input type="reset" name="reset" value="Cancel" class="btn btn-primary btn-md" style="margin-left:20px;"/> -->
		<!-- <a href="export_test_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>" style="margin-left:20px;" class="btn btn-success">Download To Excel</a> -->
		</div>
		</div>
						 
						<?php
						// }
						?>								
 <?php include('datatable_links.php'); ?>
<script>
$(document).ready(function(){
	"use strict;"
	$(".nonegative").keyup(function(){
	if($(this).val() < 0){
		 $(this).val('');
		 return false;
	 }
		
	});	
});
</script>

<script>
$(function() {
  $(".dateval").datepicker({  
  minDate: +1,
  dateFormat: 'dd-mm-yy',
	changeYear:true,
	changeMonth:true,
	});
 });
</script>

<script>
function savesub(x)
{
	//alert(x);
	//var testm = 'testid'+x;
	var minm = 'minmark'+x;
	var maxm = 'maxmark'+x;
	var testdate = 'testdate'+x;
	var starttime = 'starttime'+x;
	var endtime = 'endtime'+x;
	if($("#"+x).prop('checked')==true)
	{
		$("#"+minm).prop('disabled',false);
		$("#"+minm).attr('required',true);
		$("#"+maxm).prop('disabled',false);
		$("#"+maxm).attr('required',true);
		$("#"+testdate).prop('disabled',false);
		$("#"+testdate).attr('required',true);
		$("#"+starttime).prop('disabled',false);
		$("#"+starttime).attr('required',true);
		$("#"+endtime).prop('disabled',false);
		$("#"+endtime).attr('required',true);
	}
	else
	{
		//alert(minm);
		//$("#"+testm).prop('disabled',true);
		//$("#"+minm).prop('disabled',true);
		$("#"+minm).val('');
		$("#"+maxm).val('');
		$("#"+testdate).val('');
		$("#"+starttime).val('');
		$("#"+endtime).val('');
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

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
	<script>   
	$(document).ready(function(){
		toastr.options = {
			"closeButton": true, "debug": false,
			"newestOnTop": false,"progressBar": true,
			"positionClass": "toast-bottom-right",
			"preventDuplicates": false,
			"onclick": null,"showDuration": "300",
			"hideDuration": "1000","timeOut": "5000",
			"extendedTimeOut": "1000","showEasing": "swing",
			"hideEasing": "linear","showMethod": "fadeIn",
			"hideMethod": "fadeOut"
			};
		// $('#devel-generate-content-form')[0].reset();
		});	  

		$('#LoadUpdateSubject').on('click', function (e) {
			e.preventDefault();
			// alert("load");

			$("#update_btn").show();
			$("#show_table").show();
			var searchtestname=$('#search_test').find(':selected').val();
			$('#ntestname').val(searchtestname);

			
			// $("input[type='hidden']").removeAttr('name'); 	     
			var action ='LoadUpdateSubjectData';        
			$(this).append('<input type="hidden" name="'+ action+'"/>');          			          
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
					$('#LoadSubject').html(responce);
					if(!$("#table-grid" ).hasClass("dataTable")){
					var dataTable = $("#table-grid").DataTable({
						dom: 'Blfrtip',
						"pageLength":25,
						"ordering":false,
						"searching":false,
						"scrollX": true,
						"paging": false,
						"info": false,
					});
			    }	
                    $("#updatetest").prop('disabled', false);					
					}	
				 }); 
			});	 



 $('form').on('submit', function (e) {
 	// alert(12);
 	console.log(this);
				if( !confirm('Do you want to update the exam.') ){ 
				e.preventDefault(); 
				}else{ 
				// $("input[type='hidden'][name='LoadUpdateSubjectData']").removeAttr('name'); 
				$("input[name='LoadUpdateSubjectData']").remove(); 
				var action = 'UpdateTest';  
				$(this).append('<input type="hidden" name="'+ action+'"/>');        
				$("input[type='submit']").attr("value", "Sending, please wait...");  
				$("input[type='submit']").attr("disabled", true);	          
				$.ajax({  
				type: "POST", 
				url : 'Controllers/TestExamController.php',
				data : new FormData(this), 
				contentType: false,  
				cache: false,   
				processData:false,  
				success: function (responce) {	
				var response = JSON.parse(responce); 
				if(response.status=='success') {  
					toastr.success("Test Updated Successfuly!"); 
					setInterval(function(){ 
					   window.location.href='dashboard.php?option=update_test';
					},3000);
					// setTimeout(function(){ 
					// 	   $('#devel-generate-content-form')[0].reset();
					// 	   $("#update_btn").hide();
			        //        $("#show_table").hide();
					// 	   // $("#LoadSubject").html('');
					// 	   $("#LoadSubject").hide();
					//        $("input[type='submit']").attr("disabled", false); 
					//        $("input[type='submit']").attr('value','Update');
				    // },3000);
					
				}else if (response.status=='already') {  
					toastr.error("Test Already Created"); 
					$("input[type='submit']").attr("disabled", false); 
					$("input[type='submit']").attr('value','Update');
				}else{ 
					toastr.error("Ops Somethings is Wrong!"); 
					$("input[type='submit']").attr("disabled", false); 
					$("input[type='submit']").attr('value','Update');
				}	

				}
				}); 
				e.preventDefault(); 
				return false;	
				}
				});
		
	</script>
 
 