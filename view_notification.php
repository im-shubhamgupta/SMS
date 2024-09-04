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
  <a class="breadcrumb-item" href="#"> Notification Panel</a>
  <span class="breadcrumb-item active"> View Notification   
</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
        <div class="content mt-3" style="width:1020px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Notifications</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											<th>Selected Numbers </th>
											<th>Content</th>
											<!--<th>Deliver Status</th>	-->
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php
									$sr=1;
									$q1=mysqli_query($con,"select * from notifications");
									while($res=mysqli_fetch_array($q1))
									{
									?>
									<tr>
										<td><?php echo $sr;?></td>
										<td><?php echo $res['selected_no'];?></td>
										<td><?php echo $res['content'];?></td>
										<!--<td><?php echo $sr;?></td>-->
										
									</tr>
									<?php $sr++; 
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