<?php

extract($_REQUEST);

include('connection.php');



$q1 = mysqli_query($con,"select distinct period from staff_timetable where staff_id='$stid' and session='".$_SESSION['session']."' order by period ");	



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

										period='$k' && staff_id='$stid' and session='".$_SESSION['session']."'");

										while($r2 = mysqli_fetch_array($q2))

										{

										$subid = $r2['subject_id'];

										if($subid=="Leisure")

										{

										$subname = "Leisure";

										}

										else

										{

										$subname = "";

										}

																				

										?>

										<td><?php echo $subname;?></td>

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

			

			

<?php

}

else

{

	echo "<script>alert('Time Table Not Scheduled.')</script>";

}

?>							

							