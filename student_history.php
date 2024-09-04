<div id="right-panel" class="right-panel">
        
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Student</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Name</th>
											 <th>Register No</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Total Amount to Pay</th>
											 <th>Amount Paid</th>
											 <th>Discounted Amount</th>
											 <th>Paid Date</th>
											 <th>Due Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									extract($_REQUEST);
									if($search=="1")
									{
									$sr=1;
									$query=mysqli_query($con,"select * from students where student_name='$stuname'");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['student_id'];
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$sid=$res['section_id'];
									$ques=mysqli_query($con,"select * from section where section_id='$sid'");
									$ress=mysqli_fetch_array($ques);
									
									$date=$res['admission_date'];
									$admdate=date("d-m-y", strtotime($date));
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $ress['section_name'];?></td>
										
									</tr>
                                    <?php
									$sr++; } 
									}
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>