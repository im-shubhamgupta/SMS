<?php

extract($_REQUEST);

include('connection.php');



$q1 = mysqli_query($con,"select distinct period from staff_timetable where staff_id='$stid' and session='".$_SESSION['session']."' order by period asc");	



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

									$period = $r1['period'];

									$nperiod[] = $period;	

									

									?>										

									<th>Period <?php echo $period;?></th>

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

										$q2 = mysqli_query($con,"select * from staff_timetable where day='$dayid' && 

										period='$k' && staff_id='$stid'  and session='".$_SESSION['session']."' order by period asc");

										while($r2 = mysqli_fetch_array($q2))

										{

										$subid = $r2['subject_id'];

										if($subid=="Leisure")

										{

										$subname = "Leisure";

										}

										else

										{

										$qsub = mysqli_query($con,"select * from subject where subject_id='$subid'");

										$rsub = mysqli_fetch_array($qsub);

										$subname = $rsub['subject_name'];

										}

										

										$clid = $r2['class_id'];

										if($clid=="Leisure")

										{

										$class = "";

										}

										else

										{

										$qcl = mysqli_query($con,"select * from class where class_id='$clid'");

										$rcl = mysqli_fetch_array($qcl);

										$class = $rcl['class_name'];

										}

										

										$secid = $r2['section_id'];

										if($secid=="Leisure")

										{

										$section = "";

										}

										else

										{

										$qsec = mysqli_query($con,"select * from section where section_id='$secid'");

										$rsec = mysqli_fetch_array($qsec);

										$section = $rsec['section_name'];

										}

										

										?>

										<td><?php echo $subname;?><p style="font-size:12px;"><?php echo $class." ".$section;?></p></td>

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

				

				<!--

							<div style="text-align:center">

							<button type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-sm">

							<i class="fa fa-print"></i> Print</button>

							

							<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm" style="margin-left:20px;"/>

							

							</div>-->

							

<?php

}

else

{

	echo "<script>alert('Time Table Not Scheduled.')</script>";

}

?>							

							