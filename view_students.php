<?php

error_reporting(1);

extract($_REQUEST);


// function to connect and execute the query

function filterTable($query)

{

    include('connection.php');

	//$connect = mysqli_connect("localhost", "root", "", "school_billing");

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}







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

                <a href="dashboard.php?option=add_students" class="btn btn-primary btn-sm" id="add_student">

				<i class="fa fa-plus"></i> Add Student</a>

            </div>

        </div>

		<?php

		}

		?>

		

        <div class="content mt-3" style="width:1030px" >

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-4">

								<div class="row">

								<div class="col-md-4" style="margin-left:30px;">Class</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select name="class" class="form-select" id="ClassType" onchange="search_sec(this.value)" autofocus required>

								<option value="" selected="selected"  >All Class</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								</div>

								

								<div class="col-md-4">

								<div class="row">

								<div class="col-md-3" style="margin-left:40px;">Section</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select class="form-select" name="section" id="search_sect">

								<option value="" selected >All</option>

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

								<script>

								function search_sec(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_section_withall_report.php?cls_id="+str,true);

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

								</div>

								</div>

								

								

								<div class="col-md-2">

								<div class="row">

								<div class="col-md-12" style="margin-left:50px;">

								<!-- <input type="submit" name="search" id="search_submit" class="btn btn-primary btn-sm" value="Submit"><br><br> -->
								<a href=javascript:void(0); class="btn btn-success btn-sm" onclick=download_excel()>

								<i class="fa fa-download"></i> Important data</a>

								</div>

								</div>

								</div>

							   							

							</div>

                            </div><br>

                            <div class="card-body">

                                <!-- <table id="bootstrap-data-table-export" ">  table table-striped table-bordered table-responsive -->
                                	<table id="table-grid" class="table table-striped table-bordered " >

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>
											 
											 <th>Mother Name</th>

											 <th>Admission Date</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll No.</th>

											 <th>Session Year</th>

											 <th>Stu Phone</th>

											 <th>Parent Phone</th>

											 <th>Password</th>

											 <th>Admission Type</th>
                                              <th>Address</th>
											 <th>Message Type</th>

											 <th>Admin RTE</th>

											 <th>Religion</th>

											 <th>Caste</th>

											 <th>Social Category</th>

											 <th>Blood Grp</th>

											 <th>Mother Tongue</th>

											 <th>Aadhar No</th>

                                             <th>Action</th>

                                        </tr>

                                    </thead>

                                    

                                </table>

                            </div>

							

							<div class="card-footer">

								<!-- <a href="export_viewstudents_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>  -->
								<a href=javascript:void(0); class="btn btn-success btn-sm" onclick=download_excel()>

								<i class="fa fa-download"></i> Download To Excel</a> 

		

								<a href="dashboard.php?option=view_students" class="btn btn-info btn-sm" style="margin-left:20px;">

								<i class='fa fa-arrow-left'></i> Back</a>

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
//  $('#search_submit').click(function(e){
//  	e.preventDefault();
// alert("press on click");
//  });	
	//  var w = $(window).width();
	//  console.log(w);
    // $('.card-body').css('width', w);

</script>
	<!-- ------------------ -->
	<script>
	 $(document).ready(function(){
 			function custom_params() {
                let new_form_data = {
                classtype : $("#ClassType").val(),
                section : $("#search_sect").val(),
	            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    //'order':[7,'ASC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                 
					
					 buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'
        ],
			
		//   'order': [[1, 'asc']],
		  'order': [[7, 'desc']],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"view_students_table_data.php", // json datasource
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
			$('#ClassType').on( "change", function() {
			$('#table-grid').DataTable().ajax.reload();
			});
			$('#search_sect').on( "change", function() {
			$('#table-grid').DataTable().ajax.reload();

			});



				});

			function download_excel(){
				var ClassType = $('#ClassType').val();
				var search_sect = $('#search_sect').val();
				window.location ='data-reports.php?class='+ClassType+'&section='+search_sect+'&view_students_export_excel=0';
					console.log(ClassType + ClassType );


			}	
			   


 </script> 
	<!-- -------------- -->

