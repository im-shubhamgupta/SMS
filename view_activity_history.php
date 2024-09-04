
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
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">Activity History</a>
  <span class="breadcrumb-item active">View Activity</span>
</nav>
<!-- breadcrumb -->
   <form method="post" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Activity History</strong>
                            </div>
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
									include('connection.php');
									extract($_REQUEST);
									$sr=1;
									$query=mysqli_query($con,"select * from activity_history");
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