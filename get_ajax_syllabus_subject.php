<?php
extract($_REQUEST);
include('connection.php');

$q1=mysqli_query($con,"select * from assign_subject where st_id='$stid'");	

$row = mysqli_num_rows($q1);
if($row)
{
?>

<div class="card" style="width:1000px">
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                   <thead>
									 <tr>
										<th>Sr. No</th>
										<th>Class</th>
										<th>Section</th>
										<th>Subject</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($q1))
									{
									$id=$res['assign_sub_id'];
									
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									$clsname=$resc['class_name']; 
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									$secname=$rsec['section_name'];
																		
									$subid=$res['subject_id'];
									$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");
									$rsub=mysqli_fetch_array($qsub);
									$subname=$rsub['subject_name'];
																			
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $clsname;?></td>
										<td><?php echo $secname;?></td>
										<td><?php echo $subname;?></td>
										<td>
										<?php echo "<a href='dashboard.php?option=assign_syllabus&id=$id' class='btn btn-secondary btn-sm'> Assign Syllabus</a>";
											?>
										</td>
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
						</div><br>
						
<?php
}
else
{
	echo "<script>alert('Subject not assigned to this staff.')</script>";
}
?>							
							