<!-- breadcrumb-->
<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">View Details</a>
  <span class="breadcrumb-item active">View Transport Availed</span>
</nav>
<!-- breadcrumb -->

<div id="right-panel" class="right-panel">
	<form method="post" action="dashboard.php?option=view_students" enctype="multipart/form-data">
        
		
        <div class="content mt-3" style="width:1200px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                               <strong class="card-title">View Students</strong>
							</div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Register No</th>
											 <th>Student Name</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Route</th>
											 <th>Transport Fees</th>
											 <th>Paid</th>
											 <th>Balance</th>
                                             <th>Generate E Bill</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from students where stu_status='0' and trans_id!=''");
									while($res=mysqli_fetch_array($query))
									{
									$stuid=$res['student_id'];
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$transid=$res['trans_id'];
									$qtr=mysqli_query($con,"select * from transports where trans_id='$transid'");
									$rtr=mysqli_fetch_array($qtr);
									$transfee=$rtr['price']-$res['transfee_disc'];
									
									$qbil=mysqli_query($con,"select * from bill where student_id='$stuid'");
									$tpaid=0;
									while($rbill=mysqli_fetch_array($qbil))
									{
									$tpaid=$tpaid+$rbill['transfeepaid'];
									
									}
									$bal=$transfee-$tpaid;
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $rtr['route_name']; ?></td>
										<td><?php echo $transfee; ?></td>
										<td><?php echo $tpaid; ?></td>
										<td><?php echo $bal; ?></td>
										<td>
										<a href='dashboard.php?option=generate_bill&stuid=<?php echo $stuid;?>' class='btn btn-outline-success btn-sm' title='Generate Bill'>Generate Bill</a>
										
										</td>
										
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
		
		
		<div style="text-align:center">
		
		<a href="print_transportavailed_student.php" class="btn btn-primary" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>
		
		<a href="export_view_transport_availed_excel.php" class="btn btn-success" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>
		
		<a href="dashboard.php" class="btn btn-primary" style="margin-left:20px;"> <i class="fa fa-times"></i> Cancel</a>
			
		</div>
		
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>