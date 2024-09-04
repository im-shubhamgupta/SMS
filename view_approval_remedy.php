<script type="text/javascript">
function del(id)
{
	if(confirm("Do You want to Delete"))
	{
		window.location.href='delete_remedy.php?x='+id;
	}
}
	
</script>

<?php
error_reporting(1);
extract($_REQUEST);

?>


<div id="right-panel" class="right-panel">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Administration Panel</a>
  <a class="breadcrumb-item" href="#"> Remedies Management</a>
  <span class="breadcrumb-item active"> View Approval Remedies</span>
</nav>

	<form method="post" enctype="multipart/form-data">
		
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                               <strong class="card-title">View Remedies</strong>					   
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr style="font-size:12px;">
                                             <th class="demo">Remedy No.</th>
											 <th>Remedy For</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Observations</th>
											 <th>Assigned to</th>
											 <th>Remedies Taken</th>
											 <th>Duration</th>
											 <th>Start Date</th>
											 <th>End Date</th>
											 <th>Improved Comments</th>
											 <th>Observed Proofs</th>
											 <th>Improved Proofs</th>
											 <th>Approved By</th>
											 										 
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$query=mysqli_query($con,"select * from remedy where status='1'");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['remedy_id'];
									$rid=$res['rid'];
																										
									$stuid=$res['student_id'];
									$qstu=mysqli_query($con,"select * from students where student_id='$stuid'");
									$rstu=mysqli_fetch_array($qstu);
									
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$stid=$res['staff_id'];
									$qstid=mysqli_query($con,"select * from staff where st_id='$stid'");
									$rstid=mysqli_fetch_array($qstid);
									
									$stdate=$res['start_date']; 
									$nstdate = date("d-m-Y",strtotime($stdate));
									
									$enddate=$res['end_date']; 
									$nenddate = date("d-m-Y",strtotime($enddate));
									
									$observedproof=$res['observations_proof'];
									$improvementproof=$res['improvement_proof'];
																										
									?>
									<tr style="font-size:12px;">
										<!-- <td><?php // "REM".$id; ?></td> -->
										<td><?php echo $rid; ?></td>
										<td><?php echo $rstu['student_name']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $res['observations'];?></td>
										<td><?php echo $rstid['staff_name'];?></td>
										<td><?php echo $res['remedies_taken'];?></td>
										<td><?php echo $res['duration'];?></td>
										<td><?php echo $nstdate;?></td>
										<td><?php echo $nenddate;?></td>
										<td><?php echo $res['improvement'];?></td>
										<td>
										<a href="gallery/remedy/<?php echo $observedproof;?>"><img src="gallery/remedy/<?php echo $observedproof;?>" width="100px;" height="100px;"></a>
										</td>
										<td>
										<a href="gallery/remedy/<?php echo $improvementproof;?>"><img src="gallery/remedy/<?php echo $improvementproof;?>" width="100px;" height="100px;"></a>
										</td>
										<td><?php echo $res['approved_by'];?></td>										
									</tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>