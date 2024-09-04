<?php 
session_start();
include('connection.php');
$id=$_GET['x'];
$reason=$_GET['rea'];
$smid=$_GET['smid'];

	//For Activity History//
	
	date_default_timezone_set('Asia/Kolkata');
	$currdt = date("Y-m-d H:i:s");
	
	$sql=mysqli_query($con,"select * from users where email='".$_SESSION['user_logged_in']."'");
	
	$res=mysqli_fetch_array($sql);
	
	$roles=$_SESSION['user_roles'];
	
	$submenuid = $_REQUEST['smid'];
	$q = mysqli_query($con,"select * from sub_menu where sub_menu_id='$submenuid'");
	$r = mysqli_fetch_array($q);
	$submenuname = $r['sub_menu_name'];
	$menuid = $r['menu_id'];
	$panelid = $r['panel_id'];
	
	$machinename = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];
	if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
		// OPERA
		$ExactBrowserNameBR="Opera";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
		// CHROME
		$ExactBrowserNameBR="Chrome";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
		// INTERNET EXPLORER
		$ExactBrowserNameBR="Internet Explorer";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
		// FIREFOX
		$ExactBrowserNameBR="Firefox";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
		// SAFARI
		$ExactBrowserNameBR="Safari";
	} else {
		// OUT OF DATA
		$ExactBrowserNameBR="OUT OF DATA";
	};
	//For Activity History//

$q=mysqli_query($con,"select * from student_transport_due_fees where student_trans_fee_id ='$id'");
$r=mysqli_fetch_array($q);

$transamt=$r['trans_amount'];
$prevamt=$r['previous_trans_amount'];
$dueamt=$r['due_amount'];
$tamt = $transamt + $prevamt;
//$olddue=$r1['due_amount'];

$issby=$r['issued_by'];
$issdt=$r['issue_date'];

$email=$_SESSION['user_logged_in'];
$qu=mysqli_query($con,"select * from users where email='$email'");
$ru=mysqli_fetch_array($qu);
$loginuser=$ru['username'];

$stuid=$r['student_id'];

$q1=mysqli_query($con,"select * from students where student_id='$stuid'");
$r1=mysqli_fetch_array($q1);
$rno=$r1['register_no'];
$mobile=$r1['parent_no'];
$fname=$r1['father_name'];
$clsid=$r1['class_id'];
$secid=$r1['section_id'];
$sectionid=$r1['section_id'];
$gender=$r1['gender'];
if($gender=="FEMALE")
{
 $gen="Daughter";	
}
else
{
 $gen="Son";	
}

$sset=mysqli_query($con,"select * from setting");
$rsset=mysqli_fetch_array($sset);
$sclname=$rsset['company_name'];

$sname=$r1['student_name'];

$ndue=$dueamt+$tamt;

$action="The Paid Fees of amount";

$actiontype="Deleted Fees";

mysqli_query($con,"update student_route set due_amount='$ndue' where student_id='$stuid'");

$q3 = "update student_transport_due_fees set status=4, total_amount='$tamt', action_type='$actiontype', loginuser='$loginuser', reason='$reason', action_date=now() where student_trans_fee_id ='$id'";
if(mysqli_query($con,$q3))
{
	$action = $sname." Transport Fees of Rs ".$tamt." has been deleted."; 
	$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
	machine_name,browser,date) 
	values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
}
	
	$msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$sname." Transport Fees of Rs ".$tamt." has been discarded. Please contact school administration and collect the amount.%0a From,%0a".$sclname;
	
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
				
	//Send sms to sender and reciever
	$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => $msg,
			'to' => array($mobile)
		);
		//Prepare you post parameters
		$postData = array(
			'sender' => $senderId,
			'campaign' => $campaign,
			'route' => $route,
			'sms' => array($sms)
		);
		$postDataJson = json_encode($postData);

		$url="$apiurl";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postDataJson,
			CURLOPT_HTTPHEADER => array(
				"authkey:"."$apikey",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
	
	
	$q2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)
	values(3,'$stuid','$clsid','$sectionid',0,'$mobile','$msg','$issby','$issdt','$issdt')");	
	
echo "<script>window.location='dashboard.php?option=view_transport_payment&stuid=$stuid'</script>";


?>