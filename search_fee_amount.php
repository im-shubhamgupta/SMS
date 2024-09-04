<?php 
error_reporting(1);
extract($_REQUEST);
include('connection.php');

?>

<?php

	$qhead = mysqli_query($con,"select * from assign_fee_class where class_id='$r_id' and session='".$_SESSION['session']."'");

	if(mysqli_num_rows($qhead)> 0 ){

							?>

		<table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
			<thead>
				<tr>
				
					<?php

					$reshead = mysqli_fetch_array($qhead);
						$assfeeid = $reshead['assign_fee_id'];
						$headerid = $reshead['fee_header_id'];
																	
						$headarr = explode(',',$headerid);
						foreach ($headarr as $key)
						{
							$qhn = mysqli_query($con,"select * from fee_header where fee_header_id='$key'");
							$rhn = mysqli_fetch_array($qhn);
							$rhname = $rhn['fee_header_name'];
							$rhtype = $rhn['type'];
					?>
					<th><?php 
						if($rhtype==0){
							$rhtime="(Y)";
						}else{
							$rhtime="(M)";
						}
						echo $rhname.' '.$rhtime; ?>
				    </th>
					<!-- <th><?php $rhname;?></th> -->
					<?php
						}
					?>
					
					<th>Total Fees (Y)</th>
					<th>Edit</th>
					<!-- <th>Delete</th> -->
				
					
				</tr>
			</thead>
			<tbody>
			<tr>
				<?php
				$totalfee = 0;
				$headeramt = $reshead['fee_header_amount'];	
				$total_amount = $reshead['total_amount'];												
				$headamtarr = explode(',',$headeramt);
				foreach($headamtarr as $k1)
				{
					$totalfee = $totalfee + intval($k1);
				?>
				<td><?php echo $k1; ?></td>
				<?php
				}
				?>
				
				<td><?php echo $total_amount; ?></td>
				
				<?php
				$q4 = mysqli_query($con,"select * from student_due_fees where class_id='$r_id'  and session='".$_SESSION['session']."' and ( fee_header_status='0' || fee_header_status='' ) ");
				$row = mysqli_num_rows($q4);						
				if($row)
				{
				?>
					<td>
					    <input onclick="return confirm('Could not able to Edit the Fees Structure. Contact Administrator');" type="button" name="edit" value="Edit" style='width:80px;' class="btn btn-secondary btn-sm"/>
					</td>
				<?php
				}
				else
				{
				?>
					<td>
					<?php echo "<a href='dashboard.php?option=update_assign_fees_to_class&afid=$assfeeid&clsid=$r_id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit' aria-hidden='true'></i> Edit</a>";
					?></td>
				<?php
				}
				?>
				
				
				<!-- <td>
				<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $assfeeid;?>')"> <i class="fa fa-trash"></i> Delete </a>
				</td>
 -->			
			</tr>
			</tbody>
		</table>

<?php
    }else{
    	echo "<span style='color:red;'><strong>[ *No any Fees Assign to this Class ]</strong></span>";
    }		
								
				