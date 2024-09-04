<?php
include('connection.php');


?>
<style>
	input[type="number"] {
    width: 95px;
}
	</style>

<div id="right-panel" class="right-panel">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <span class="breadcrumb-item active">Edit Late Fee Assign to Class</span>
</nav>

   <form method="post" action="" enctype="multipart/form-data" id="late_fee_form">      
        <div class="content mt-3" style="width:1050px">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            	<div class="row">

                            	<div class="col-md-2" style="margin-left:10px;"><span>Class :</span>
								</div>

								<div class="col-md-3">
									<!-- onchange="search_sec(this.value)" -->
									<?php  ?>

									<select name="class_id" id="class_id" class="form-control" readonly >
									<?php

								    $scls = "select * from class where class_id='".$_GET['classid']."' "; 									
									$rcls = mysqli_query($con, $scls);

									while( $rescls = mysqli_fetch_array($rcls)){?>

									
									<option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

									</option>

									<?php } ?>							

									</select>

								</div>
								<div class="col-md-2" style="margin-left:10px;"><span>Section :</span>
								</div>

								<div class="col-md-3">
									<!-- onchange="search_sec(this.value)" -->
									<?php  ?>

									<select name="section_id" id="section_id" onchange="load_late_fee_data(this.value)" class="form-control"  >
									<?php
								    $scls = "select * from section where class_id='".$_GET['classid']."' "; 									
									$rcls = mysqli_query($con, $scls);

									while( $rescls = mysqli_fetch_array($rcls)){

										
									$select=($_GET['secid']==$rescls['section_id']) ? 'selected' : '';

										  ?>
									
									<option  value="<?php echo $rescls['section_id'];?>"
									 <?=$select?> ><?php echo $rescls['section_name']; ?>

									</option>

									<?php } ?>							

									</select>

								</div>
							</div>
                              
								
							<!-- table-responsive -->
							<div class="card-body">
                                <table id="table-grid" class="table table-striped table-bordered ">
                                    <thead>
                                        <tr> 
                                             <th>Sr. No</th>
											 <th>Register No.</th>
											 <th>Student Name</th>
											 <th>Late Fee Amount</th>
											 <th>Days</th>
											 <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									if(isset($_GET['secid']) && !empty($_GET['secid'])){
										$sec_sql=" and section_id='".$_GET['secid']."' ";
									}else{
										$sec_sql='';
									}	
								    $sql="SELECT * FROM `late_fee` WHERE  class_id='".$_GET['classid']."' $sec_sql and session='".$_SESSION['session']."' order by class_id ASC" ;
									
									$chkQuery = mysqli_query($con,$sql );
	   	                            if(mysqli_num_rows($chkQuery)>0){
									$sr=1;
									while($res=mysqli_fetch_assoc($chkQuery)){ 
									$qcls=mysqli_query($con,"select * from class where class_id='".$res['class_id']."'");
										$rcls=mysqli_fetch_assoc($qcls);
										$stuclass = $rcls['class_name'];	
									 ?>
									
									<tr>
										<td><?php echo $sr; ?></td>

										<td><?php echo getStudent_byStudent_id($res['student_id'])['register_no']; ?></td>
										<td><?php echo getStudent_byStudent_id($res['student_id'])['student_name']; ?></td>
										<!-- <td><input type="number" size='2' name="late_amt_<?=$res['id']?>" id="late_amt_<?=$res['id']?>" value="<?=$res['late_fee_amount']?>"></td>
										<td><input type="number" size='2' name="late_days_<?=$res['id']?>" id="late_days_<?=$res['id']?>" value="<?=$res['late_fee_date']?>"></td>
										
										<td><a  href="javascript:void(0)" id="submit_btn"  onclick="change_late_fee(<?=$res['id']?>)"                    class="btn btn-info submit_btn_<?=$res['id']?>" ><i class="fa fa-edit"></i> Update</a></td> -->

										<input type="hidden" name="late_id[]"  value="<?=$res['id']?>">
										<!-- <input type="hidden" name="stuid[]"  value=""> -->
										<td><input type="number" size='2' name="late_amt[]"  value="<?=$res['late_fee_amount']?>"></td>
										<td><input type="number" size='2' name="late_days[]"  value="<?=$res['late_fee_date']?>"></td>
										
										

								
									</tr>
                                    <?php
									$sr++; 
									}//while
									$submit_btn=true;
									
									}else{?>
										<tr>
											<td >No Any Students in this</td> 
											<td ></td> 
											<td ></td> 
											<td ></td> 
											<td ></td> 
											<td ></td> 
											
									</tr>
									<?php	} 
									
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

        <?php
       // if(isset($submit_btn) && $submit_btn==true){ ?>
        <div class="row" style="margin-bottom:20px;">
        	<div class="col-md-4"></div>
        	<div class="col-md-2">
		<!-- <input type="submit"  name="save_late_fee"  value="Update" class="btn btn-primary btn-lm"/> -->
		<button type="submit" onclick="return confirm('Are you sure want to Update?')"  name="save_late_fee"  value="Update" class="btn btn-primary btn-lm"/>Update</div>
		<div class="col-md-2">
		
		    <a href='dashboard.php?option=view_late_fee_assign_to_class' class="btn btn-info btn-lm"/>Back</a>
	    </div>
		</div>
		</div>


        <?php// }

        ?>
		
		<div style="text-align:center">
		<!--
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php'); ?>
<script>
	toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	
		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "1000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};				
</script>
<script>
"use strict";

$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();

  var action = "update_late_fee";
	$(this).append("<input type='hidden' name="+action+" >");
	// var data_string=new FormData($('#late_fee_form')[0]);
	var data_string=$('#late_fee_form').serialize();
	// console.log(this);

	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
		type:"POST",
		data:data_string,
		// contentType:false,
		// cache:false,
		// processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
					// console.log(responce);
			if(result.status=="success"){
				toastr.success(result.message);
				setInterval(function(){ 

				window.location.href='dashboard.php?option=view_late_fee_assign_to_class';
				// 			// $('form')[0].reset(); 
					// location.reload();
				},3000);
			}else{
				toastr.error(result.message);
				// window.location.reload();
			}
			$("button[type='submit']").html(' Update');  
	      $("button[type='submit']").attr("disabled", false);
		}
	});
});
})
 </script>
	<script>
	 // $(document).ready(function(){
 			
		// 	var dataTable = $("#table-grid").DataTable({
        //             "lengthMenu": [ [-1], ['All'] ],	
        //             // 'order':[6,'DESC'],
        //             // dom: 'Blfrtip',

        //             // "pageLength":25,
        //             // buttons: [
        //             // 'copy', 'csv', 'excel', 'print'
        //             // ],
		// 			// "processing": true,
		// 			// "serverSide": true,
        //             // "scrollX": true,
				
		// 	// });
		// 	// $('#language').on( "change", function() {
		// 	// $('#table-grid').DataTable().ajax.reload();
		// 	// });
			
		// });
		// });

 </script> 
<script>
function load_late_fee_data(id){


window.location.href='dashboard.php?option=edit_assign_fees_to_class&classid=<?=$_GET['classid']?>&secid='+id+'';



	}
</script>	
 
 
 