<?php

extract($_REQUEST);

include('connection.php');



$day = $_REQUEST['dayid'];

$p = $_REQUEST['period'];



if(!empty($day))

{

?>



<div class="card" style="width:950px" id="printableArea">

                            <div class="card-body">

                                <table class="table table-striped table-bordered">

                                   <thead>

									<tr>

									<th>Staff Name</th>

										

									<?php

									if($p==""){

										$q = mysqli_query($con,"select * from staff_timetable and session='".$_SESSION['session']."'");
										if(mysqli_num_rows($q)>0){
										$r = mysqli_fetch_array($q);

										$tperiod = $r['tperiod'];

									

									for($i=1;$i<=$tperiod;$i++)

									{										

									?>										

									<th>Period <?php echo $i;?></th>

									<?php

									}
								   }

									}else{

									?>

									<th>Period <?php echo $p;?></th>	

									<?php

									}

									?>

										 

									</tr>

									</thead>

									<tbody>

									<?php

									$qst = mysqli_query($con,"select * from staff where status='1'");

									while($rst = mysqli_fetch_array($qst))

									{

										$staffid = $rst['st_id'];

										

									?>

										<tr>

										<td><?php echo $rst['staff_name'];?></td>

										

										<?php

										if($p=="")

										{

										$q = mysqli_query($con,"select * from staff_timetable where 1 and session='".$_SESSION['session']."'");
										if(mysqli_num_rows($q)>0){
										$r = mysqli_fetch_array($q);

										$tperiod = $r['tperiod'];

										

										for($i=1;$i<=$tperiod;$i++)

										{

										$q2 = mysqli_query($con,"select * from staff_timetable where day='$day' && 

										period='$i' && staff_id='$staffid' and session='".$_SESSION['session']."'");

										while($r2 = mysqli_fetch_array($q2))

										{

										$subid = $r2['subject_id'];

										$q4 = mysqli_query($con,"select * from subject where subject_id='$subid'");

										$r4 = mysqli_fetch_array($q4);

										$sname = $r4['subject_name'];

										if($subid=="Leisure")

										{

										$subname = "Leisure";

										}

										else

										{

										$subname = $sname;

										}

																				

										?>

										<td><?php echo $subname;?></td>

										<?php

										}

										}
									   }

										}

										else

										{

										$q3 = mysqli_query($con,"select * from staff_timetable where day='$day' && 

										period='$p' && staff_id='$staffid' and session='".$_SESSION['session']."'");
										if(mysqli_num_rows($q)>0){
										$r3 = mysqli_fetch_array($q3);

										$subid = $r3['subject_id'];

										$q4 = mysqli_query($con,"select * from subject where subject_id='$subid'");

										$r4 = mysqli_fetch_array($q4);

										$sname = $r4['subject_name'];

										if($subid=="Leisure")

										{

										$subname = "Leisure";

										}

										else

										{

										$subname = $sname;

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

				

			

<?php

}

else

{

	echo "<script>alert('Time Table Not Scheduled.')</script>";

}

?>							

							