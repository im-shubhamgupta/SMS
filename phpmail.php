<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($submit))
{
	
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 4;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'sbbpuconlineadmission2022@gmail.com';                 // SMTP username
$mail->Password = 'sbbpuc2022';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('sbbpuconlineadmission2022@gmail.com', 'Mailer');
$mail->addAddress('negi.kanchan42@gmail.com', 'Joe User');     // Add a recipient
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
	
	
	// $receiver = $_REQUEST['to'];
	// $sub = $_REQUEST['subject'];
	// $msg = $_REQUEST['message'];
	
	// $sset=mysqli_query($con,"select * from setting");
	// $rsset=mysqli_fetch_array($sset);
	// $from=$rsset['company_email'];	
	
	
	//akashipschool@gmail.com
	//echo "<script>window.location='dashboard.php?option=send_staff_email_notification'</script>";
}

?>

<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  
<script src="multi.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	-->
	
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Communication Panel</a>
  <span class="breadcrumb-item active"> Send Email Notification</span>
</nav>
<!-- breadcrumb -->
<form method="post" enctype="multipart/form-data"> 
<div class="row" style="margin-top:50px;margin-left:20px;">
	<div class="col-md-2">To : </div>
	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">
	<textarea name="to" class="form-control" style="width:400px;height:100px;"></textarea>
	</div>

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
<input type="submit" name="submit" value="Send" id="add" style="margin-left:40px;" class="btn btn-primary btn-sm"/>
<input type="reset" name="reset" value="Cancel" style="margin-left:40px;" class="btn btn-info btn-sm"/>
</div>
</form>

