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


<div id="right-panel" class="right-panel">
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Report Panel</a>
  <a class="breadcrumb-item" href="#">Student Report</a>
  <span class="breadcrumb-item active">Classwise Report</span>
</nav>

	<form method="post" action="dashboard.php?option=classwise_report" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                
				<div class="row" style="margin-top:20px;">
					<div class="col-md-2" style="margin-left:50px;">
					<input type="radio" name="ctype" value="category" checked> Category Report
					</div>
					<div class="col-md-3" style="margin-left:50px;">
					<input type="radio" name="ctype" value="gender"> Gender Report
					</div>
				</div>
				<br>
				<br>
				
				<!---------------- Category Report ---------------->
				<div class="row" style="margin-top:20px;">
				<div class="col-md-12">
					<div class="card category selectt">
					
					<div id="chartContainer1" style="height:400px; width:100%;margin-left:0px;">
					
					</div>
					<br>
					
					<div class="card-body">
						<table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
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
								$qu = mysqli_query($con,"select * from students where class_id='$k' && soc_cat_id='$catid'");
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
								$q2 = mysqli_query($con,"select * from students where class_id='$k'");
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
					
					<div>
					<a href="export_categoryreport_excel.php" class="btn btn-success btn-sm" 
					style="margin-left:380px"> <i class="fa fa-download"> </i> Download To Excel</a>
					</div>
					<br> 
					
					</div>
				</div>
				</div>
				
				
				<!---------------- Gender Report ---------------->	
				<div class="row" style="margin-top:20px;">
				<div class="col-md-12">	
					<div class="card gender selectt" style="display:none">
					
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
								$qu = mysqli_query($con,"select * from students where class_id='$clid' && section_id='$secid' && gender='male'");
								$mrow = mysqli_num_rows($qu);
								$qu = mysqli_query($con,"select * from students where class_id='$clid' && section_id='$secid' && gender='female'");
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
					
					<div>
					<a href="export_genderreport_excel.php" class="btn btn-success btn-sm" 
					style="margin-left:380px"> <i class="fa fa-download"> </i> Download To Excel</a>
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
 $(document).ready(function() {
    $('input[type="radio"]').click(function() {
		var inputValue = $(this).attr("value"); 
		var targetBox = $("." + inputValue); 
		$(".selectt").not(targetBox).hide(); 
		$(targetBox).show(); 
    });
});
</script>

 
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
			
			$query_no_of_students=mysqli_query($con,"select * from students");
			$row_no_of_students=mysqli_num_rows($query_no_of_students);
			$query_cat=mysqli_query($con,"select * from social_category");
			
			$i=0;
			while($row_cat=mysqli_fetch_array($query_cat))
			{
				$id=$row_cat['soc_cat_id'];
				$cat_name=$row_cat['soc_cat_name'];
				$query_cat2=mysqli_query($con,"select * from students where soc_cat_id=\"$id\"");
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