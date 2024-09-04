<?php
extract($_REQUEST);
$cid = $_REQUEST['cid'];
$q1 = mysqli_query($con,"select * from certificate_details where id='$cid'");
$r1 = mysqli_fetch_array($q1);
$template = $r1['new_image'];

if(isset($submit))
{
$d = $cert_date;
$newdate = date('d F Y',strtotime($d));
	
header('content-type:image/jpeg');
//$font="fonts/".$fstyle;
$font="c:/windows/fonts/".$fstyle;
$img = imagecreatefromjpeg("pic/".$template);
$color=imagecolorallocate($img,255,255,255);
imagettftext($img,60,0,1300,1000,$color,$font,$cert_action);
imagettftext($img,80,0,1200,1200,$color,$font,$cert_name);
imagettftext($img,80,0,900,1500,$color,$font,$cert_reason);
imagettftext($img,70,0,1200,1900,$color,$font,$newdate);
$file=time();
imagejpeg($img,"pic/certificates/".$file.".jpg");
imagedestroy($img);

$newimg = $file.".jpg";
$q1 = mysqli_query($con,"insert into certificate_download (cert_name,status) values ('$newimg','1')");

$lastid = $con->insert_id;

echo "<script>window.location='dashboard.php?option=download_cert&id=$lastid'</script>";

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
									<label for="nf-email" class=" form-control-label">Certificate Title</label><span id="charnum1" style="float:right"> (26/35)</span>
									<input type="text" name="cert_title" id="tarea1" class="form-control" value="<?php echo $r1['cert_title'];?>" onkeyup="countchar1(this)" required>
									</div>
									</div>
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Action</label><span id="charnum2" style="float:right"> (12/25)</span>
									<input type="text" name="cert_action" id="tarea2" class="form-control" value="<?php echo $r1['cert_action'];?>" onkeyup="countchar2(this)" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Recipient</label><span id="charnum3" style="float:right"> (14/20)</span>
									<input type="text" name="cert_name" id="tarea3" class="form-control" value="<?php echo $r1['cert_recipient'];?>" onkeyup="countchar3(this)" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Reason</label><span id="charnum4" style="float:right"> (27/30)</span>
									<input type="text" name="cert_reason" id="tarea4" class="form-control" value="<?php echo $r1['cert_reason'];?>" onkeyup="countchar4(this)" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Certificate Date</label>
									<input type="date" name="cert_date" class="form-control" required>
									</div>									
									</div>									
									</div>
									
									<div class="row">
									<div class="col-md-12">
									<div class="form-group">
									<label for="nf-email" class=" form-control-label">Select Font</label>
									<select name="fstyle" class="form-control" required>
									<option value="" selected="selected" disabled>Select font</option>
									<option value="ALGER.TTF">Algerian</option>
									<option value="ARIAL.TTF">Arial</option>
									<option value="BASKVILL.TTF">Baskerville</option>
									<option value="TIMES.TTF">Times New Roman</option>
									</select>
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
	
<script>
function countchar1(val){
	var maxlength = 35;
	var strlength = val.value.length;
	if(strlength > maxlength)
	{
		$("#charnum1").css("color", "red");
		$("#tarea1").val($("#tarea1").val().substr(0,maxlength));
	}
	else
	{
		$('#charnum1').html('('+strlength+'/35)');
		$("#charnum1").css("color", "black");
	}
	
}

function countchar2(val){
	var maxlength = 25;
	var strlength = val.value.length;
	if(strlength > maxlength)
	{
		$("#charnum2").css("color", "red");
		$("#tarea2").val($("#tarea2").val().substr(0,maxlength));
	}
	else
	{
		$('#charnum2').html('('+strlength+'/25)');
		$("#charnum2").css("color", "black");
	}
	
}

function countchar3(val){
	var maxlength = 20;
	var strlength = val.value.length;
	if(strlength > maxlength)
	{
		$("#charnum3").css("color", "red");
		$("#tarea3").val($("#tarea3").val().substr(0,maxlength));
	}
	else
	{
		$('#charnum3').html('('+strlength+'/20)');
		$("#charnum3").css("color", "black");
	}
	
}

function countchar4(val){
	var maxlength = 30;
	var strlength = val.value.length;
	if(strlength > maxlength)
	{
		$("#charnum4").css("color", "red");
		$("#tarea4").val($("#tarea4").val().substr(0,maxlength));
	}
	else
	{
		$('#charnum4').html('('+strlength+'/30)');
		$("#charnum4").css("color", "black");
	}
	
}

</script>	
	
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 