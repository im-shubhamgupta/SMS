<?php

error_reporting(1);

extract($_REQUEST);


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





<div id="right-panel" class="right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Student</a>

  <span class="breadcrumb-item active">View Student</span>

</nav>



	<form method="post" action="dashboard.php?option=view_students" enctype="multipart/form-data">

        

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

		<div class="breadcrumbs container-fluid">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=add_text_sms_template" class="btn btn-primary btn-sm" id="add_student">

				<i class="fa fa-plus"></i> Add Template</a>

            </div>

        </div>

		<?php

		}

		?>

		

        <div class="content mt-3" style="width:1050px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:30px;">Language</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select name="language" class="form-control" id="language" autofocus required>

								<option value=""  >All</option>
								<option value="English"   >English</option>
								<option value="Hindi"  >Hindi</option>

								</select>

								</div>

								</div>

								</div>

								<div class="col-md-6" style="text-align: right;">
							

								<a href="dashboard.php?option=view_students" class="btn btn-info btn-sm" style="margin-left:20px;">

								<i class='fa fa-arrow-left'></i> Back</a>

							    </div>

							</div>

                            </div>

                            <div class="card-body">

                                <!-- <table id="bootstrap-data-table-export" ">  table table-striped table-bordered table-responsive -->
                                	<table id="table-grid" class="table table-striped table-bordered " >

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

										
											 <th>Slug</th>
											 	 <th>Temp ID</th>
											 <th>Title</th>
											 <th>SMS Content</th>

											 <th>Sample SMS</th>

											 <th>Admission Date</th>

                                             <th>Action</th>

                                        </tr>

                                    </thead>

                                    

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>

</div><!-- /#right-panel -->


 <?php include('datatable_links.php'); ?>
 <script>
"use strict";


</script>
	<!-- ------------------ -->
	<script>
	 $(document).ready(function(){
 			function custom_params() {
                let new_form_data = {
                language : $("#language").val(),
        
	            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    'order':[6,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"text_sms_templates_table_data.php", // json datasource
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
			$('#language').on( "change", function() {
			$('#table-grid').DataTable().ajax.reload();
			});
			
				});

 </script> 
	<!-- -------------- -->

