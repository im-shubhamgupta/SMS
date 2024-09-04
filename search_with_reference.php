<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($_REQUEST['search']))
{
	$query =mysqli_query($con,"SELECT * FROM admission WHERE reference_no='$refno' && status='1'");	
}


?>

<script type="text/javascript">
	function decline(id)
	{
		var reason=prompt("Do you want to Decline.");
		if(reason=="") 
		{
		alert("Please Enter Reason ???");
		}
		else if(reason)
		{	
		window.location.href="update_admission_ref_decline.php?x=" + id + "& rea=" +reason;
		return true;
		}
		else
		{	
		return false;
		}
	}
		
</script>


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
  <span class="breadcrumb-item active">Online Admission</span>
</nav>

	<form method="post" action="dashboard.php?option=search_with_reference" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                               
							<div class="row" style="margin-top:20px;">
								<div class="col-md-3" style="margin-left:30px;">Enter Reference Number</div>
								<div class="col-md-3">
								<input type="text" name="refno" value="<?php echo $refno;?>" class="form-control"/>
								</div>
								
								<div class="col-md-3" style="margin-left:30px;">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
							</div>	
														
							
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                             <th>Reference No.</th>
                                             <th>Requested On</th>
											 <th>Name</th>
											 <th>Father Name</th>
											 <th>Gender</th>
											 <th>Mobile No.</th>
											 <th>Requested for Admission</th>
											 <th>Previous School</th>
											 <th>Previous Grade</th>
											 <th>Previous Grade Percentage</th>
											 <th>Address</th>
											 <th>City</th>
											 <th>State</th>
											 <th>Accept</th>
											 <th>Decline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['admission_id'];
									$refno=$res['reference_no'];
									$reqdt=$res['requested_date'];
									$newreqdt=date("d-M-y",strtotime($reqdt));
									$name=$res['name'];
									$fathername=$res['fathername'];
									$gender=$res['gender'];
									$phone=$res['phone'];
									$grade=$res['grade'];
									$scls = mysqli_query($con,"select * from class where class_id='$grade'");
									$rescls = mysqli_fetch_array($scls);
									$classname = $rescls['class_name'];
									$prev_school=$res['previous_school'];
									$prev_grade=$res['previous_grade'];
									$scls1 = mysqli_query($con,"select * from class where class_id='$prev_grade'");
									$rescls1 = mysqli_fetch_array($scls1);
									$prevclassname = $rescls1['class_name'];
									$prev_perc=$res['previous_percentage'];
									$address=$res['address'];
									$city=$res['city'];
									$state=$res['state'];
									
									
									?>
									<tr>
										<td><?php echo $refno; ?></td>
										<td><?php echo $newreqdt; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $fathername; ?></td>
										<td><?php echo $gender; ?></td>
										<td><?php echo $phone; ?></td>
										<td><?php echo $classname; ?></td>
										<td><?php echo $prev_school;?></td>
										<td><?php echo $prevclassname;?></td>
										<td><?php echo $prev_perc; ?></td>
										<td><?php echo $address; ?></td>
										<td><?php echo $city; ?></td>
										<td><?php echo $state; ?></td>
										
										<td>
										<a onclick="return confirm('Do you want to Accept.')" href="dashboard.php?option=update_admission_accept&id=<?php echo $id;?>&page=search_with_reference" class="btn btn-success" style="width:100px;border-radius:20px">Accept</a>
										</td>
										
										<td>
										<a href="#" class="btn btn-danger" onclick="decline('<?php echo $id;?>')" style="width:100px;border-radius:20px">Decline </a>
										
										<!--<a onclick="return confirm('Do you want to Decline.')" href="dashboard.php?option=update_leave_disapprove&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-danger" style="width:100px;border-radius:20px">Decline</a>
										--></td>
									</tr>
                                    <?php $sr++; } ?>
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
