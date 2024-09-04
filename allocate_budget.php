<?php

error_reporting(1);





?>



<div id="right-panel" class="right-panel">

<!-- breadcrumb-->

<nav class="breadcrumb">

 <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_allocate_budget">View Allocate Budget</a>

  <span class="breadcrumb-item active">Allocate Budget</span>

</nav>

<!-- breadcrumb -->       

		

<form method="post" id="devel-generate-content-form" enctype="multipart/form-data">      	

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

					

						<script>

							function demo1()

							{

							document.getElementById("demo2").style="display:block";

							document.getElementById("demo3").style="display:block";

							}

						</script>

					

					

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-4" style="font-size:14px;margin-left:180px;">Select Budget Header</div>

							<div class="col-md-4" style="margin-left:-100px;margin-top:-10px">

							<select name="header" class="form-control" onchange="demo1()"

							autofocus required>

							<option value="" selected="selected" disabled>Select Header</option>

							<?php

							$q1 = mysqli_query($con,"select * from budget_header");

							while( $r1 = mysqli_fetch_array($q1) ) {

							?>

							<option <?php if($header==$r1['budget_header_id']){echo "selected";}?> value="<?php echo $r1['budget_header_id']; ?>"><?php echo $r1['budget_header_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

						</div><br/><br/>

						

						<div class="row" style="margin-top:20px;display:none" id="demo2">	

							<div class="col-md-4" style="font-size:14px;margin-left:180px;">Allocate Amount</div>

							<div class="col-md-4" style="margin-left:-100px;margin-top:-10px">

							<input type="number" class="form-control" name="allocate_amt" autofocus required>

							</div>

						</div><br/><br/><br/>

						

						<div class="row" style="margin-top:20px;display:none" id="demo3">	

							<div class="col-md-4" style="font-size:14px;margin-left:380px;">

							<button type="submit" name="add" class="btn btn-primary btn-sm">

							<i class="fa fa-plus"></i> Add

							</button>

							</div>

						</div><br>

                        

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

</form>

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 <?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "allocate_budget";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	$.ajax({
		url:"Controllers/AdministrationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=allocate_budget';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("button[type='submit']").html("<i class='fa fa-plus'></i> Add");  
	        $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
