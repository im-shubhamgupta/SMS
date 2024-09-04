<?php

// $img = imagecreate(500,500);
// $bg = imagecolorallocate($img,45,100,145);
// $tx = imagecolorallocate($img,45,145,56);
// imagestring($image, 5,50,100, "PHP",$tx);
// imagestring($image, 5,50,250, "New",$tx);
// header("content-Type:image/jpg");
// imagepng($img);
// imagedestroy($img);

extract($_REQUEST);
$cid = $_REQUEST['cid'];
$q1 = mysqli_query($con,"select * from certificate_details where id='$cid'");
$r1 = mysqli_fetch_array($q1);
$oldpic = $r1['cert_image'];
if(isset($submit))
{
header("Content-Type: image/jpeg");
$font="ALGER.TTF";
$img=imagecreatefromjpeg("pic/".$oldpic);
$color=imagecolorallocate($img,19,21,22);
$name="Vishal Gupta";
imagettftext($img,40,0,100,100,$color,$font,$name);
imagejpeg($img);
imagedestroy($img);
}
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
  <span class="breadcrumb-item active">Certificate Details</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
					<div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Enter Certificate Details</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
								<div class="col-sm-6">
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Title</label>
									<input type="text" name="cert_title" class="form-control" value="<?php echo $r1['cert_title'];?>" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Action</label>
									<input type="text" name="stuname" class="form-control" value="<?php echo $r1['cert_action'];?>" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Recipient</label>
									<input type="text" name="stuname" class="form-control" value="<?php echo $r1['cert_recipient'];?>" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Reason</label>
									<input type="text" name="stuname" class="form-control" value="<?php echo $r1['cert_reason'];?>" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Date</label>
									<input type="text" name="stuname" class="form-control" value="<?php echo date('d F Y');?>" required>
									</div>									
									</div>									
									</div>
								
									<div class="row">
									<div class="col-md-12">
									<input type="submit" name="submit" class="btn btn-primary" value="submit">									
									</div>
									</div>
								</div>
								
								<div class="col-sm-6">
								<img src="<?php echo "pic/".$r1['cert_image'];?>" width="450px" height="370px" style="margin-top:35px;"/>
								</div>
								
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