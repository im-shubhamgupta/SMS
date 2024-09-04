<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');



?>

<style>

	tr th{

		

		font-size:12px;

	}



	tr td{

		

		font-size:12px;

	}



	</style>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}



</style>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<div id="right-panel" class="right-panel">

   <form method="post" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">



							<div id="chartContainer2" style="height:400px; width:100%;margin-left:0px;">

					

							</div>

							

							<br>



                            <div class="card-body">

							<table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

							<thead>

								<tr>

									 <th width="5%">Sr. No</th>

									 <th width="20%">Class</th>

									 <th width="20%">Section</th>

									 <th width="20%">Male</th>

									 <th width="20%">Female</th>

									 <th width="15%">Total</th>

									 

								</tr>

							</thead>

							<tbody>

							<tr>

								

							<?php 

							$sr = 1;

							$qsec = mysqli_query($con,"select * from section");

							while($rsec=mysqli_fetch_array($qsec))

							{							

								$clid = $rsec['class_id'];

								$secid = $rsec['section_id'];

								$qcl = mysqli_query($con,"select * from class where class_id='$clid'");

								$rcl = mysqli_fetch_array($qcl);

							?>

								<td><?php echo $sr; ?></td>

								<td><?php echo $rcl['class_name']; ?></td>

								<td><?php echo $rsec['section_name']; ?></td>

								

								<?php

								// $qu = mysqli_query($con,"select * from students where class_id='$clid' && section_id='$secid' && gender='male'");
								$qu=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$clid' && sr.section_id='$secid' && gender='male' and stu_status='0'  && sr.session='".$_SESSION['session']."' ");

								$mrow = mysqli_num_rows($qu);

								// $qu = mysqli_query($con,"select * from students where class_id='$clid' && section_id='$secid' && gender='female'");
								$qu=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$clid' && sr.section_id='$secid' && gender='female' and stu_status='0'  && sr.session='".$_SESSION['session']."' ");

								$frow = mysqli_num_rows($qu);

								$trow = $mrow + $frow;

								

								?>

								<td><?php echo $mrow; ?></td>

								

								<td><?php echo $frow; ?></td>

								

								<td><?php echo $trow; ?></td>

								

							</tr>

							<?php 

							$totalmale = $totalmale + $mrow;

							$totalfemale = $totalfemale + $frow;

							$gtotal = $gtotal + $trow;

							$sr++; 

							}

							?>

							<tr>

							<td colspan="3" align="center" style="font-weight:bold">Total</td>

							<td><?php echo $totalmale; ?></td>

							<td><?php echo $totalfemale; ?></td>

							<td><?php echo $gtotal; ?></td>

							</tr>

							<?php

							$dataPoints2 = array(

									array("label"=> "Male", "y"=> $totalmale),

									array("label"=> "Female", "y"=> $totalfemale)

									

								);

							

							?>

							

							</tbody>

							</table>

							</div>

                        </div>

										

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=classwise_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 <?php include('bootstrap_datatable_javascript_library.php'); ?>





<script>

window.onload = function () {



var chart = new CanvasJS.Chart("chartContainer2", {

	animationEnabled: true,

	//exportEnabled: true,

	theme: "light2", // "light1", "light2", "dark1", "dark2"

	title:{

		text: "Gender Report"

	},

	data: [{

		type: "pie", //change type to bar, line, area, pie, etc

		//showInLegend: "true",

		legendText: "{label}",

		indexLabelFontSize: 16,

		indexLabel: "{label} - #percent%",

		//yValueFormatString: "฿#,##0", 

		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>

	}]

});

chart.render();

}

</script>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

 