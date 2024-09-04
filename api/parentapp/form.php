<?php 
include('myfunction.php');
extract($_REQUEST);
if(isset($send))
{
	echo chkMobile($m);	
}
if(isset($verify))
{
	echo verify($m,$otp);
}
?>
<form>
	Enter Your Mobile:<input type="number" name="m"/>
	Enter Your Otp :<input type="number" name="otp"/>
	<input type="submit" value="send" name="send"/>
	<input type="submit" value="Verify" name="verify"/>
</form>