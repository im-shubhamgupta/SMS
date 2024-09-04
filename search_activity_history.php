<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

$sr=1;
if(isset($_POST['search']))
{
	$cond = '';
	
	if($_POST['panelid']!='') 
	{
		$cond.=" && panel_id='$_REQUEST[panelid]'";
	}
	
$query =mysqli_query($con,"SELECT * FROM activity_history WHERE date(date) between '$fromdt' AND '$todt' $cond");

}

?>
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
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">Activity History</a>
  <span class="breadcrumb-item active">Search Activity</span>
</nav>

	<form method="post" action="dashboard.php?option=search_activity_history" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                                 
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-5" style="margin-left:50px;">From Date</div>
								<div class="col-md-5" style="margin-left:-30px;">
								<input type="date" name="fromdt" class="form-control" style="width:180px;" value="<?php echo $fromdt; ?>" autofocus required>
								</div>
								</div>
								</div>
								
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-3" style="margin-left:20px;">To Date</div>
								<div class="col-md-6" style="margin-left:00px;">
								<input type="date" name="todt" class="form-control" style="width:180px;" value="<?php echo $todt; ?>" autofocus required>
								</div>
								</div>
								</div>
							</div><br>
							
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-5" style="margin-left:50px;">Panel</div>
								<div class="col-md-5" style="margin-left:-30px;">
								<select class="form-control" name="panelid" style="width:180px"> 
									<option value="">All</option>
									<?php
									$qp = mysqli_query($con,"SELECT * FROM panel where panel_id!=1");
									while( $rp = mysqli_fetch_array($qp) ) {
									?>
									<option <?php if($panelid==$rp['panel_id']){echo "selected";}?> value="<?php echo $rp['panel_id']; ?>"><?php echo $rp['panel_name']; ?>
									</option>
									<?php } ?>	
								</select>
								</div>
								</div>
								</div>
							</div><br>
							<br>
							
							<div class="row">
								<div class="col-md-2" style="margin-left:280px">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
								<div class="col-md-2">
								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br>
								</div>
							</div>
														
							<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											<th>Activity Date</th>
											<th>Login</th>
											<th>Panel</th>
											<th>Menu</th>
											<th>Sub Menu</th>
											<th>Action Details</th>
											<th>Machine Name</th>
											<th>Browser</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									
									while($res=mysqli_fetch_array($query))
									{
																	
										$activitydate = $res['date'];
										$chgdt = date("d-M-Y h:i A",strtotime($activitydate));
										$panelid = $res['panel_id'];
										$q1 = mysqli_query($con,"select * from panel where panel_id='$panelid'");
										$r1 = mysqli_fetch_array($q1);
										$panelname = $r1['panel_name'];
										$menuid = $res['menu_id'];
										$q2 = mysqli_query($con,"select * from menu where menu_id='$menuid'");
										$r2 = mysqli_fetch_array($q2);
										$menuname = $r2['menu_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $chgdt; ?></td>
										<td><?php echo $res['login_user']; ?></td>
										<td><?php echo $panelname; ?></td>
										<td><?php echo $menuname; ?></td>
										<td><?php echo $res['sub_menu']; ?></td>
										<td><?php echo $res['action_details']; ?></td>
										<td><?php echo $res['machine_name']; ?></td>							
										<td><?php echo $res['browser']; ?></td>	
									</tr>
                                    <?php $sr++; }
									
									?>
                                    </tbody>
                                </table>
                            </div>
							
							<div>
							<a href="export_studentreport_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success btn-sm" style="margin-left:380px"> <i class="fa fa-download"> </i> Download To Excel</a>
							</div>
							<br> 
							
                            </div>
														
                    </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		
		
		
		
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>