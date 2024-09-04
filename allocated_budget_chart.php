<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');



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





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Report</a>

  <span class="breadcrumb-item active">Allocated Budget Chart</span>

</nav>



	<form method="post" action="dashboard.php?option=rte_report" enctype="multipart/form-data">

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                          				

							<div class="card">

							

							<div id="chartContainer" style="height:400px; width:100%;margin-left:0px;">

							

							</div>

							

							<br>

							

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive" >

									<thead>

									<tr>

										 <th width="5%">Sr. No</th>

										 <th width="5%">Allocated Budget Header</th>

										 <th width="5%">Allocated Amount</th>

									</tr>

									</thead>

									

									<tbody>

									<tr>

								

									<?php 

									$sr = 1;

									$q1 = mysqli_query($con,"SELECT * FROM allocate_budget where 1 and session='".$_SESSION['session']."' ");
									if(mysqli_num_rows($q1)>0){

									while($r1=mysqli_fetch_array($q1))

									{

										$headerid = $r1['budget_header_id'];

										$amount=$r1['allocate_amount'];

										$q2=mysqli_query($con,"select * from budget_header where budget_header_id ='$headerid'");

										$r2=mysqli_fetch_array($q2);

										$header_name = $r2['budget_header_name'];

										

										$tamt = $tamt + $amount;

									?>

									<td><?php echo $sr; ?></td>

									<td><?php echo $header_name; ?></td>

									<td><?php echo $amount; ?></td>

									</tr>

									<?php 

									$sr++; 

									}	
								    }

									?>

									<tr>

									<td colspan="2" align="center" style="font-weight:bold">Total</td>

									<td style="font-weight:bold"><?php echo $tamt; ?></td>

									</tr>

                                    </tbody>

                                </table>

                            </div>

								

								<div>

								<a href="export_allocatedbudget_excel.php" class="btn btn-success btn-sm" 

								style="margin-left:380px;margin-right:20px"> <i class="fa fa-download"> </i> Download To Excel</a>



								<a href="print_allocatedbudget_report.php" class="btn btn-primary btn-sm"> <i class="fa fa-print"></i> Print</a>



								</div>

								<br> 

					

                            </div>

																					

                    </div>

                </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>



 

<script>

window.onload = function () {

	

var chart = new CanvasJS.Chart("chartContainer", {

	animationEnabled: true,

	//exportEnabled: true,

	theme: "light2", // "light1", "light2", "dark1", "dark2"

	title:{

		text: "Allocated Budget"

	},

	data: [

	{

		type: "pie", //change type to bar, line, area, pie, etc

		//showInLegend: "true",

		legendText: "{label}",

		indexLabelFontSize: 16,

		indexLabel: "{label} - #percent%",

		//yValueFormatString: "฿#,##0", 

		dataPoints: [

		<?php

			

			$query = mysqli_query($con,"SELECT * FROM allocate_budget where 1 and session='".$_SESSION['session']."' ");

			

			while($res=mysqli_fetch_array($query))

			{

				$headerid = $res['budget_header_id'];

				$amount=$res['allocate_amount'];

				$q1=mysqli_query($con,"select * from budget_header where budget_header_id ='$headerid'");

				$r1=mysqli_fetch_array($q1);

				$header_name = $r1['budget_header_name'];

				$row_cont=mysqli_num_rows($query);

				

					//$percentage=$row_cont/$amount*100;

					?>

					{y: <?=$amount?>, label: '<?=$header_name?>'},

					<?php

					

				

			}

			

			?>		

		]

	}]

});

chart.render();



}

</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>