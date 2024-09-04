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



							<div id="chartContainer1" style="height:400px; width:100%;margin-left:0px;">

					

							</div>

							

							<br>



                            <div class="card-body">

								<table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

											 <th width="5%">Sr. No</th>

											 <th width="5%">Category</th>

											 <?php 

											 $qcl = mysqli_query($con,"select * from class");

											 while($rcl = mysqli_fetch_array($qcl))

											 {

												$clarr[] = $rcl['class_id'];

											 ?>

											 <th width="5%"><?php echo $rcl['class_name']; ?></th>

											 <?php

											 }

											 ?>

											 <th width="5%"><?php echo "Total"; ?></th>

										</tr>

                                    </thead>

                                    <tbody>

									<tr>

										

									<?php 

									$sr = 1;

									$qsc = mysqli_query($con,"select * from social_category");

									while($rsc=mysqli_fetch_array($qsc))

									{							

										$catid = $rsc['soc_cat_id'];

										$catarr[] = $rsc['soc_cat_name'];

									?>

										<td><?php echo $sr; ?></td>

										<td><?php echo $rsc['soc_cat_name']; ?></td>

										

										<?php

										$ctotal = 0;

										foreach ($clarr as $k)

										{

										// $qu = mysqli_query($con,"select * from students where class_id='$k' && soc_cat_id='$catid' and session='".$_SESSION['session']."'  ");
										$qu=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' && sr.class_id='$k' && sr.session='".$_SESSION['session']."' && soc_cat_id='$catid'  ");


										$crow = mysqli_num_rows($qu);

										?>

										<td><?php echo $crow; ?></td>

										<?php

										$ctotal = $ctotal + $crow;

										}

										?>

										

										<td><?php echo $ctotal;?></td>

									</tr>

									<?php 

									$sr++; 

									}	

									?>

									<tr>

									<td colspan="2" align="center" style="font-weight:bold">Total</td>

									<?php

									foreach ($clarr as $k)

									{

										// $q2 = mysqli_query($con,"select * from students where class_id='$k' and session='".$_SESSION['session']."' ");
									$q2=mysqli_query($con,"select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0' && sr.class_id='$k' && sr.session='".$_SESSION['session']."' ");
	

										$row2 = mysqli_num_rows($q2);

										$cgtotal = $cgtotal + $row2;

									?>

									<td><?php echo $row2; ?></td>

									<?php

									}

									?>

									<td><?php echo $cgtotal; ?></td>

									</tr>

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

	

var chart = new CanvasJS.Chart("chartContainer1", {

	animationEnabled: true,

	//exportEnabled: true,

	theme: "light2", // "light1", "light2", "dark1", "dark2"

	title:{

		text: "Category Report"

	},

	data: [{

		type: "pie", //change type to bar, line, area, pie, etc

		//showInLegend: "true",

		legendText: "{label}",

		indexLabelFontSize: 16,

		indexLabel: "{label} - #percent%",

		//yValueFormatString: "฿#,##0", 

		dataPoints: [

		<?php


			

			// $query_no_of_students=mysqli_query($con,"select * from students where session='".$_SESSION['session']."'");
			$query_no_of_students=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' ");

			$row_no_of_students=mysqli_num_rows($query_no_of_students);

			$query_cat=mysqli_query($con,"select * from social_category");

			

			$i=0;

			while($row_cat=mysqli_fetch_array($query_cat))

			{

				$id=$row_cat['soc_cat_id'];

				$cat_name=$row_cat['soc_cat_name'];

				// $query_cat2=mysqli_query($con,"select * from students where session='".$_SESSION['session']."' and soc_cat_id=\"$id\"  ");
				$query_cat2=mysqli_query($con,"select `student_id`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  stu_status='0'  && sr.session='".$_SESSION['session']."' and soc_cat_id='$id'  ");

				$row_cont_cat=mysqli_num_rows($query_cat2);

				if(!$row_cont_cat)

				{

					$row_cont_cat=0.00;

				}

				else

				{

					$percentage=$row_cont_cat/$row_no_of_students*100;

					?>

					{y: <?=$percentage?>, label: '<?=$cat_name?>'},

					<?php

					

				}

			}

			

			?>		

		]

	}]

});

chart.render();

}

</script>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

 