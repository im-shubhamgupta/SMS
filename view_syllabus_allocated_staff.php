<?php

//error_reporting(1);

extract($_REQUEST);



		

?>	

	



<div id="right-panel" class="right-panel">



<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Syllabus Management</a>  

  <span class="breadcrumb-item active">View Syllabus Allocated to Staff</span>

</nav>



<form method="post" action="dashboard.php?option=view_syllabus_allocated_staff" enctype="multipart/form-data">

  <div class="content mt-3" style="width:1000px;">

	<div class="animated fadeIn">

	<div class="row">

	<div class="col-md-12">

	<div class="row" style="margin-top:30px;margin-left:20px;">

		<div class="col-md-2">Select Staff :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" class="form-control" name="faculty" id="faculty" onchange="search_assign_class(this.value)" 

		autofocus required>

		<option value="" selected="selected" disabled >Select Staff</option>

		<?php
		

		$squ = "select * from staff where status='1'";


		$rsqu = mysqli_query($con, $squ);

		while( $resst = mysqli_fetch_array($rsqu) ) {

		?>

		<option value="<?php echo $resst['st_id']; ?>"><?php echo $resst['staff_name']; ?>

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

		

		<div class="col-md-2" style="margin-left:80px;">Class :</div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;margin-left:-70px;" name="class" id="class" class="form-control" onchange="search_subject(this.value);search_sec(this.value)"  autofocus required>

		<option value="" selected="selected" disabled>Select Class</option>							

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

	</div>

	

	<div class="row" style="margin-top:30px;margin-left:20px;">

		<div class="col-md-2">Section :</div>

		<div class="col-md-2">

		<select style="width:170px;" class="form-control" name="section" id="search_sect" onchange="search_subject(this.value);" required>

		<option value="" selected disabled>Select Section</option>

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

			

		<div class="col-md-2" style="margin-left:80px;">Subject :</div>

		<div class="col-md-2">

		<select style="width:170px;margin-left:-70px;" name="subject" id="search_subj" class="form-control" autofocus required>

		<option value="" selected="selected" disabled>Select Subject</option>

		</select>

		</div>

	</div>

	

	

	

	<div class="row" style="margin-top:30px;margin-left:20px;">	

		<div class="col-md-2">Status : </div>

		<div class="col-md-5">

		<select style="width:170px;" name="status" id="status" class="form-control">

		<option value="">All</option>

		<option value="1">Done</option>

		<option value="2">In Progress</option>

		<option value="3">Not Started</option>

		</select>

		</div>

	

	

	<!-- <div class="row" style="margin-top:30px;margin-left:20px;"> -->
		<div class="col-md-4" >

		<input type="submit" name="search" value="Submit" style="margin-left:0px;width:100px" class="btn btn-primary btn-sm">

		<input type="reset" value="Cancel" style="margin-left:50px;" class="btn btn-info btn-sm">

	</div>
	</div><br>

<p><u>(optional filters)</u></p>
	<div class="row" style="margin-top:10px;margin-left:20px;">	

		<div class="col-md-2">From Date : </div>

		<div class="col-md-2">

		<input type="date" name="fromdt" id="fromdt" class="form-control" style="width:170px;"  autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">To Date : </div>

		<div class="col-md-2">

		<input type="date" name="todt" id="todt" class="form-control" style="width:170px;margin-left:-70px;"  autofocus>

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

											 <th>Status</th>

											 <th>Completion Date</th>

											 <th>Updated Date</th>

											 <th>Updated By</th>

											 <th>Comments</th>

											 <th>Action</th>

										</tr>

                                    </thead>

                                </table>

                            </div>

                        </div>

						



						<?php

						// if(isset($search))

						// {

						?>

						<!-- <a href="export_syllabus_allocated_staff_excel.php?faculty=<?php echo $faculty;?>&class=<?php echo $class;?>&section=<?php echo $section;?>&subject=<?php echo $subject;?>&status=<?php echo $status;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" class="btn btn-success" style="margin-left:360px;">

<i class="fa fa-download"></i> Download To Excel</a> -->



<!-- <input type="reset" class="btn btn-info btn-sm" style="margin-left:20px;" value="Cancel"> -->

						<?php

						// }

						?>
	</div>

	</div>

	</div><!-- .animated -->

  </div><!-- .content -->

	

</form>





</div><!-- /#right-panel -->

 <!-- <?php// include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>
 	<script>
	 $(document).ready(function(){
 			function custom_params() {
                let new_form_data = {
                faculty : $("#faculty").val(),
                class : $("#class").val(),
                search_sect : $("#search_sect").val(),
                search_subj : $("#search_subj").val(),
                fromdt : $("#fromdt").val(),
                todt : $("#todt").val(),
                status : $("#status").val(),
	            }	    
	            return new_form_data;
	        }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    'order':[15,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"view_syllabus_allocated_staff_table_data.php", // json datasource
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
			$('form').on("submit", function(e){
				e.preventDefault();
				// alert(12);
			    $('#table-grid').DataTable().ajax.reload();
			});
});

 </script> 
                   