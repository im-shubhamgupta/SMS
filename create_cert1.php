
<style>
.spanname
{
font-size:25px;
font-weight:bold;
padding:20px;		
}

a img{
	border:1px solid #D3D3D3;
}
</style>

<form method="post">
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Certificate Panel</a>
  <span class="breadcrumb-item active">Create Certificate</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		
        <div class="content mt-3" style="width:900px">
            <div class="animated fadeIn">
                <div class="row">
					<div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Select a Design Category</strong>
                            </div>
                            <div class="card-body">
							
								<?php
								$q1 = mysqli_query($con,"select * from certificate_category");
								while($r1 = mysqli_fetch_array($q1))
								{
									$catid = $r1['cert_id']; 
								?>
								
								<div class="row">
								<div class="col-sm-6">
								<a href="dashboard.php?option=create_cert2&cat=<?php echo $catid;?>"><img src="<?php echo "pic/".$r1['cert_image'];?>" width="150px" height="100px"><span class="spanname"><?php echo $r1['cert_name'];?></span></a>
								</div>
								</div>
								<br/>
								
								<?php
								}
								?>
								
								
                                <!--<div class="row">
								<div class="col-sm-6">
								<a href="dashboard.php?option=create_cert2&cat=1"><img src="pic/formal1.jpg" width="150px" height="100px"><span class="spanname">Formal</span></a>
								</div>
								</div>
								<br/>
								
								
								<div class="row">
								<div class="col-sm-6">
								<a href="dashboard.php?option=create_cert2&cat=2"><img src="pic/sports1.jpg" width="150px" height="100px"/><span class="spanname">Sports</span></a>
								</div>
								</div>
								<br/>-->
																
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
	</form>
 <?php include('bootstrap_datatable_javascript_library.php'); ?>