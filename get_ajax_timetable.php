<?php

extract($_REQUEST);

include('connection.php');


// echo $sql="select distinct(period), start_period, end_period  from time_table where class_id='$clsid' && section_id='$secid'";
 $sql="select distinct(period), start_period, end_period  from time_table where class_id='$clsid' && section_id='$secid' && session='".$_SESSION['session']."' group by period";
$q1 = mysqli_query($con,$sql);	



$row = mysqli_num_rows($q1);

if($row)

{

?>



<div class="card" style="width:950px" id="printableArea">

                            <div class="card-body">

                                <table class="table table-striped table-bordered">

                                   <thead>

									<tr>

									<th>Days</th>

										

									<?php

									

									while($r1 = mysqli_fetch_array($q1))

									{
										// echo "<>";

									$period = $r1['period'];

									$nperiod[] = $period;		

										

									$stperiod = $r1['start_period'];

									$chgstperiod = date('g:i a',strtotime($stperiod));

									

									$endperiod = $r1['end_period'];

									$chgendperiod = date('g:i a',strtotime($endperiod));

									?>										

									<th>Period <?php echo $period;?><p style="font-size:11px;">(<?php echo $chgstperiod;?> - <?php echo $chgendperiod;?>)</p></th>

									<?php

									}

									?>

										 

									</tr>

									</thead>

									<tbody>

									<?php

									$qday = mysqli_query($con,"select * from days where day_id !=7");

									while($rday = mysqli_fetch_array($qday))

									{

										$dayid = $rday['day_id'];

										

									?>

										<tr>

										<td><?php echo $rday['day_name'];?></td>

										

										<?php

										foreach($nperiod as $k)

										{

										$q2 = mysqli_query($con,"select * from time_table where day='$dayid' && 

										period='$k' && class_id='$clsid' && section_id='$secid' && session='".$_SESSION['session']."'");

										while($r2 = mysqli_fetch_array($q2))

										{

										$subid = $r2['subject_id'];

										if($subid == "Lunch")

										{

											$subname = "Lunch";

										}

										else if($subid == "Break")

										{

											$subname = "Break";

										}

										else

										{										

										$qsub = mysqli_query($con,"select * from subject where subject_id='$subid'");

										$rsub = mysqli_fetch_array($qsub);

										$subname = $rsub['subject_name'];

										}

										

										$staffid = $r2['staff_id'];

										if($staffid == "Lunch")

										{

											$stname = "";

										}

										else if($staffid == "Break")

										{

											$stname = "";

										}

										else

										{

										$qst = mysqli_query($con,"select * from staff where st_id='$staffid'");

										$rst = mysqli_fetch_array($qst);

										$stname = $rst['staff_name'];

										}

										

										?>

										<td><?php echo $subname;?><p style="font-size:12px;"><?php echo $stname;?></p></td>

										<?php

										}

										}

										?>

										

										</tr>

									<?php

									}

									?>

									</tbody> 

                                </table>

                            </div>

						</div><br>

				

<script>

function printDiv(divName) {

     var printContents = document.getElementById(divName).innerHTML;

     var originalContents = document.body.innerHTML;



     document.body.innerHTML = printContents;



     window.print();



     document.body.innerHTML = originalContents;

}

</script>

				

							<div style="text-align:center">

							<button type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-sm">

							<i class="fa fa-print"></i> Print</button>

							

							<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm" style="margin-left:20px;"/>

							

							</div>

							

<?php

}

else

{

	echo "<script>alert('Time Table Not Scheduled.')</script>";

}

?>							

							