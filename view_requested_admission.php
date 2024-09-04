<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');

$sql="SELECT * FROM admission WHERE  status='1' ";

if(isset($_REQUEST['search']))

{
	if(!empty($admission_grade)){
		$sql.=" and grade='$admission_grade' ";
	}
}

$query =mysqli_query($con,$sql);



?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}
.card-body button.dt-button {
	margin-right: 0.333em;
    margin-bottom: 0.333em;
    padding: 0.3em 1em;
    border: 1px solid #999;
    border-radius: 2px;
    cursor: pointer;
    font-size: 0.88em;
    line-height: 1.6em;
    color: black;
    white-space: nowrap;
    overflow: hidden;
	}




</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <span class="breadcrumb-item active">Online Admission</span>

</nav>



	<form method="post" action="dashboard.php?option=view_requested_admission" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:30px;">Requested for Grade</div>

								<div class="col-md-3">

								<select name="admission_grade" class="form-control" id="admission_grade" autofocus >

								<option value="" selected="selected"  >All Grades</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option <?php if($admission_grade==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								

								<div class="col-md-3" style="margin-left:30px;">

								<!-- <input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br> -->

								</div>

							</div>	

														

							

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sl no</th>
                                             <th>Reference No.</th>

                                             <th>Requested On</th>

											 <th>Name</th>

											 <th>Father Name</th>

											 <th>Gender</th>

											 <th>Mobile No.</th>

											 <th>Requested for Admission</th>

											 <th>Previous School</th>

											 <th>Previous Grade</th>

											 <th>Previous Grade Percentage</th>

											 <th>Address</th>

											 <th>City</th>

											 <th>State</th>

											 <th style="width:400px;">Message</th>

                                        </tr>

                                    </thead>

                                 

                                </table>

                            </div>

							

							<div class="card-footer">

								<!-- <a href="export_requested_admission_excel.php?class=<?php echo $admission_grade;?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download To Excel</a>	 -->
								<!-- <button onclick="export_requested_admission_excel()"  class="btn btn-success btn-sm" ><i class="fa fa-download"></i> Download To Excel</button>					 -->

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
$(document).ready(function(){

	// function export_requested_admission_excel(){

	//    	var grade=$('#admission_grade').val();
	//    	alert(grade);

    //      // window.location.href="export_requested_admission_excel.php?class="+ grade+"";

    // }
 			function custom_params() {
                let new_form_data = {

	                admission_grade : $("#admission_grade").val(),
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[13,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"view_requested_admission_table_data.php", // json datasource
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
			$('#admission_grade').on( "change", function() {
				// alert(12);
			    $('#table-grid').DataTable().ajax.reload();

			});
			});
</script>
  <!--  <tbody>

									<?php 

									$sr=1;
									if(isset($query)){

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['admission_id'];

									$refno=$res['reference_no'];

									$reqdt=$res['requested_date'];

									$newreqdt=date("d-M-y",strtotime($reqdt));

									$name=$res['name'];

									$fathername=$res['fathername'];

									$gender=$res['gender'];

									$phone=$res['phone'];

									$grade=$res['grade'];

									$scls = mysqli_query($con,"select * from class where class_id='$grade'");

									$rescls = mysqli_fetch_array($scls);

									$classname = $rescls['class_name'];

									$prev_school=$res['previous_school'];

									$prev_grade=$res['previous_grade'];

									$scls1 = mysqli_query($con,"select * from class where class_id='$prev_grade'");

									$rescls1 = mysqli_fetch_array($scls1);

									$prevclassname = $rescls1['class_name'];

									$prev_perc=$res['previous_percentage'];

									$address=$res['address'];

									$city=$res['city'];

									$state=$res['state'];

									$req_msg=$res['requested_message'];

									

									?>

									<tr>

										<td><?php echo $refno; ?></td>

										<td><?php echo $newreqdt; ?></td>

										<td><?php echo $name; ?></td>

										<td><?php echo $fathername; ?></td>

										<td><?php echo $gender; ?></td>

										<td><?php echo $phone; ?></td>

										<td><?php echo $classname; ?></td>

										<td><?php echo $prev_school;?></td>

										<td><?php echo $prevclassname;?></td>

										<td><?php echo $prev_perc; ?></td>

										<td><?php echo $address; ?></td>

										<td><?php echo $city; ?></td>

										<td><?php echo $state; ?></td>

										<td><?php echo $req_msg; ?></td>

										

									</tr>

                                    <?php $sr++; } }?>

                                    </tbody> -->