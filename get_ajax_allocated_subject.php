<?php
extract($_REQUEST);
include('connection.php');

$q1=mysqli_query($con,"select * from assign_subject where st_id='$stid'");	

$row = mysqli_num_rows($q1);
if($row)
{
?>

<div class="card" style="width:950px">
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                   <thead>
									 <tr>
										<th>Sr. No</th>
										<th>Class</th>
										<th>Section</th>
										<th>Subject</th>
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
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
						</div><br>
						
<a href="export_allocated_subjects_staff_excel.php?stid=<?php echo $stid;?>" class="btn btn-success" style="margin-left:360px;">
<i class="fa fa-download"></i> Download To Excel</a>

<input type="reset" class="btn btn-info btn-sm" style="margin-left:20px;" value="Cancel">
		
				
<?php
}
else
{
	echo "<script>alert('Subject not assigned to this staff.')</script>";
}
?>							
							