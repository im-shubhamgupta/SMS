<?php
//error_reporting(1);

?>
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
  <span class="breadcrumb-item active">View Discount Students</span>
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
											 <th>Student Name</th>
											 <th>Register No</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Tution Fees Discount</th>
											 <th>Tution Fees Discount Reason</th>
											 <th>Transport Fees Discount</th>
											 <th>Transport Fees Discount Reason</th>
                                             <th>Total Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from students where stu_status='0' and tutionfee_disc!='' or transfee_disc!=''");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['student_id'];
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$tution_disc=$res['tutionfee_disc'];
									$trans_disc=$res['transfee_disc'];
									$total_amount=$tution_disc+$trans_disc;
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $res['tutionfee_disc']; ?></td>
										<td><?php echo $res['tutionfeedisc_reason']; ?></td>
										<td><?php echo $res['transfee_disc']; ?></td>
										<td><?php echo $res['transfeedisc_reason']; ?></td>
										<td><?php echo "$total_amount"; ?></td>
										
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
		
		<a href="print_discounted_student.php" class="btn btn-primary" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>
		
		<a href="export_view_discount_students_excel.php" class="btn btn-success" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>
		
		<a href="dashboard.php" class="btn btn-primary" style="margin-left:20px;"> <i class="fa fa-times"></i> Cancel</a>
			
		</div>
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>