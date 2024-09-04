<?php
extract($_REQUEST);
$catid = $_REQUEST['cat'];

?>

<style>
.spanname
{
font-size:12px;
font-weight:bold;
text-align: center;
}

</style>


<form method="post">
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Certificate Panel</a>
  <a class="breadcrumb-item" href="dashboard.php?option=create_cert1">Create Certificate</a>
  <span class="breadcrumb-item active">Select Design</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		
        <div class="content mt-3" style="width:900px">
            <div class="animated fadeIn">
                <div class="row">
					<div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Select a Certificate Design</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
								<?php
								$q1 = mysqli_query($con,"select * from certificate_details where cert_id='$catid'");
								while($r1 = mysqli_fetch_array($q1))
								{		
									$id = $r1['id'];
								?>
								<div class="col-sm-3">
								<a href="dashboard.php?option=create_cert3&cid=<?php echo $id;?>"><img src="<?php echo "pic/".$r1['cert_image'];?>" width="150px" height="100px" style="border:1px solid #DCDCDC;margin-left:20px;"/>
								<p class="spanname"><?php echo $r1['cert_title'];?></p>
								</a>
								</div>
								<?php
								}
								?>
								</div>
								<br/>
								
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
	</form>
 <?php include('bootstrap_datatable_javascript_library.php'); ?>