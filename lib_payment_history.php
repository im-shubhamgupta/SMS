<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

$issueid=$_REQUEST['issueid'];


?>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}
	</style>

<div id="right-panel" class="right-panel">

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
<nav class="breadcrumb" style="width:1020px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Library Management</a>
  <a class="breadcrumb-item" href="#">Penalty Collection</a>
  <span class="breadcrumb-item active">Payment History</span>
</nav>

   <form method="post" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Library Payment Details</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                         <tr>
                                             <th>Sr. No</th>
											 <th>Penalty Amount</th>
											 <th>Paid Amount</th>
											 <th>Due Amount</th>
											 <th>Payment Date</th>
											
	                                     </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sr=1;
									$q = mysqli_query($con,"select * from library_payment where issue_id='$issueid'");
									while($r = mysqli_fetch_array($q))
									{
										$paydate = $r['date'];
										$chgdt = date("d-m-Y", strtotime($paydate));
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $r['penalty_amount']; ?></td>
										<td><?php echo $r['paid_amount']; ?></td>
										<td><?php echo $r['due_amount']; ?></td>
										<td><?php echo $chgdt ;?></td>
																																					
									</tr>
									<?php
									$sr++;}
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		<div style="text-align:center">
		
		<a href="dashboard.php?option=penalty_collection" class="btn btn-primary">Back</a>
		
		<br><br>
		</div>
	</form>
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>