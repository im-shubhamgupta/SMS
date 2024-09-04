
	<style>
	tr th{
		
		font-size:15px;
	}

	tr td{
		
		font-size:15px;
	}

	</style>

<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Administration Panel</a>
  <span class="breadcrumb-item active">View Logs</span>
</nav>
<!-- breadcrumb -->
   <form method="post" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Log Detail</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Admission Fee</th>
											 <th>Tution Fee</th>
											 <th>Misc Fee</th>
											 <th>Transportation Fee</th>
											 <th>Paid By</th>
											 <th>Challan No.</th>
											 <th>Issued By</th>
											 <th>Issued Date</th>
											 <th>Action Date & Time</th>
											 <th>Action Type</th>
											 <th>Action</th>
											 <th>Reason</th>
											
	                                     </tr>
                                    </thead>
                                    <tbody>
									<?php 
									include('connection.php');
									extract($_REQUEST);
									$sr=1;
									$query=mysqli_query($con,"select * from log");
									while($res=mysqli_fetch_array($query))
									{
									$stuid=$res['student_id'];
									$q1=mysqli_query($con,"select * from students where student_id='$stuid'");
									$r1=mysqli_fetch_array($q1);
									$stuname=$r1['student_name'];
									$regno=$r1['register_no'];
									
									$a1=$res['admission_fee'];	
									$a2=$res['tution_fee'];	
									$a3=$res['misc_fee'];	
									$a4=$res['transportation_fee'];	
									$t=$a1+$a2+$a3+$a4;
									
									$user=$res['loginuser'];	
																			
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['admission_fee']; ?></td>
										<td><?php echo $res['tution_fee']; ?></td>
										<td><?php echo $res['misc_fee']; ?></td>
										<td><?php echo $res['transportation_fee']; ?></td>
										<td><?php echo $res['paidby']; ?></td>
										<td><?php echo $res['challan_no']; ?></td>
										<td><?php echo $res['issued_by'];?></td>
										<td><?php echo $res['issued_date'];?></td>
										<td><?php echo $res['action_date'];?></td>
										<td><?php echo $res['action_type'];?></td>
										<td><?php echo "The Paid Fees of amount '$t' for the Student '$stuname' Register Number '$regno' is deleted by '$user'.";?></td>
										<td><?php echo $res['reason'];?></td>
																											
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