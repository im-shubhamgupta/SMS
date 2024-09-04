<?php
error_reporting(1);
extract($_REQUEST);

?>


<div id="right-panel" class="right-panel">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Administration Panel</a>
  <a class="breadcrumb-item" href="#"> Feedback Management</a>
  <span class="breadcrumb-item active"> View Feedback</span>
</nav>

	<form method="post" enctype="multipart/form-data">
		
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                               <strong class="card-title">View Feedback</strong>					   
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Submission Date</th>
											 <th>Name</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Request Type</th>
											 <th>Raised For</th>
											 <th>Teacher Name</th>
											 <th>Title</th>
											 <th>Description</th>
											 <th>Response</th>
											 
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from feedback where status='1'");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['feedback_id'];
									
									$submitdate=$res['submission_date']; 
									$nsubmitdate = date("d-m-Y",strtotime($submitdate));
																										
									$stuid=$res['student_id'];
									$qstu=mysqli_query($con,"select * from students where student_id='$stuid'");
									$rstu=mysqli_fetch_array($qstu);
									
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$requestid=$res['request_id'];
									$qre=mysqli_query($con,"select * from request_type where request_id='$requestid'");
									$rre=mysqli_fetch_array($qre);
									
									$stid=$res['staff_id'];
									$qst=mysqli_query($con,"select * from staff where st_id='$stid'");
									$rst=mysqli_fetch_array($qst);									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $nsubmitdate; ?></td>
										<td><?php echo $rstu['student_name']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $rre['request_name'];?></td>
										<td><?php echo $res['raised_for'];?></td>
										<td><?php echo $rst['staff_name'];?></td>
										<td><?php echo $res['title'];?></td>
										<td><?php echo $res['description'];?></td>
										<td><?php echo $res['response'];?></td>
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