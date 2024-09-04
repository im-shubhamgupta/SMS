<?php

error_reporting(1);

include_once('connection.php');
include_once('myfunction.php');

extract($_REQUEST);

if(isset($send))

{

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";
// die;
	

	$receiver = $_REQUEST['to'];

	$sub = $_REQUEST['subject'];

	$msg = $_REQUEST['message'];

	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$from=$rsset['company_email'];	

	$headers = "From: $from";

  $res=SendEmail($Email,$subject, $message,$from)['type'];  
	
//---------
	if(mail($receiver, $sub, $msg, $headers)){

		$err="<span id='err_successful'>[ Email Sent. ]</span>";

	}else

	{

		$err="<span id='err_notsuccessful'>[ Email Failed..! ]</span>";

	}

	

}



?>



	

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Communication Panel</a>

  <span class="breadcrumb-item active"> Send Email Notification</span>

</nav>

<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 



<div class="card-header">

		<strong>Email</strong> Notification

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	

<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2">To : </div>

	<div class="col-md-5" style="margin-top:-8px;margin-left:-40px;">

	<textarea name="to" class="form-control" style="width:400px;height:100px;"></textarea>

	</div>

	<!--<span class="col-md-5">Multiple Email id seperated with (,) Comma</span>-->



</div>



<div class="row" style="margin-top:30px;margin-left:20px;">

	<div class="col-md-2">Subject : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

	<input type="text" name="subject" class="form-control" style="width:400px;height:50px;"/>

	</div>



</div>





<div class="row" style="margin-top:30px;margin-left:20px;margin-bottom:50px;">

	<div class="col-md-2" style="margin-top:20px;">Message : </div>

	<div class="col-md-2" style="margin-left:-40px;">

	<textarea name="message" class="form-control" style="width:400px;height:200px;"></textarea>

	</div>	

</div>

	

<hr style="height:2px solid grey">



<div>

<input type="submit" name="send" value="Send" id="add" style="margin-left:40px;" class="btn btn-primary btn-sm"/>

<input type="reset" name="reset" value="Cancel" style="margin-left:40px;" class="btn btn-info btn-sm"/>

</div>

</form>



