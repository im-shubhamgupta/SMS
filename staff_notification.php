<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
if(isset($sms))
{
	
	
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
	$category=$_REQUEST['category'];
	$class = $_REQUEST['class'];
	$section = $_REQUEST['section'];
	$subject = $_REQUEST['subject'];
	$number=$_REQUEST['number'];    
    $composetext = $_REQUEST['composetext'];
	
	if($category=="announcements")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0'");
	}
	else if($category=="homework" || $category=="message")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$class' and section_id='$section'");
	}
	
	while($resz=mysqli_fetch_array($que))
	{	
	if($number=="student")
	{
	$mobile=$resz['student_contact'];
	}
	else
	{
	$mobile=$resz['parent_no'];
	}
		
	//Send sms to sender and reciever
	$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => $composetext,
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
		
	$q1=mysqli_query($con,"insert into staff_notifications(selected_no,message,date)values('$mobile','$composetext',now())");
	
	echo "<script>window.location='dashboard.php?option=staff_notification'</script>";
	}
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  


	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
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

input[type=checkbox] {
    zoom: 1.8;
	margin-top:5px;
}
</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Staff Management Panel</a>
  <span class="breadcrumb-item active"> Notification   
</span>
</nav>
<!-- breadcrumb -->
 <form method="post"> 
<div class="row" style="margin-top:50px;margin-left:20px;">
	<div class="col-md-2" style="font-size:16px;">Category : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:200px;" name="category" id="category" class="form-control" onchange="test456()" required>
	<option value="" selected="selected" disabled>--- Select Category ---</option>
	<option value="announcements">Announcements</option>						
	<option value="homework">Homework</option>						
	<option value="message">Message</option>						
	</select>
	</div>
</div>
<br><br>

			<script>	
			function test456()
			{
			var p=document.getElementById("category").value
			if(p=="announcements")
			{
			document.getElementById("demo345").style="display:none";
			document.getElementById("class").value = "";
			document.getElementById("search_sect").value = "";
			document.getElementById("search_sub").value = "";
			}
			else
			{
			document.getElementById("demo345").style="display:block";
			document.getElementById("class").required = true;
			document.getElementById("search_sect").required = true;
			document.getElementById("search_sub").required = true;
			}
			}
			</script>
			
<div class="row" style="margin-left:22px;" id="demo345">
	<div class="col-md-1" style="font-size:16px;">Class : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:170px;margin-left:-20px;" name="class" id="class" class="form-control" 
	onchange="search_sec(this.value); search_subject(this.value);">
	<option value="" selected="selected" disabled>--- Select Class ---</option>
	<?php
	$scls = "select * from class";
	$rcls = mysqli_query($con, $scls);
	while( $rescls = mysqli_fetch_array($rcls) ) {
	?>
	<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
	</option>
	<?php } ?>							
	</select>
	</div>

<script>
function search_sec(str)
{
var xmlhttp= new XMLHttpRequest();	
xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);
xmlhttp.send();
xmlhttp.onreadystatechange=function()
{
if(xmlhttp.status==200  && xmlhttp.readyState==4)
{
document.getElementById("search_sect").innerHTML=xmlhttp.responseText;
}
} 
}
</script>


	<div class="col-md-1" style="font-size:16px;margin-left:20px;">Section : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:190px;" name="section" id="search_sect" class="form-control">
	<option value="" selected="selected" disabled>--- Select Section ---</option>							
	</select>
	</div>

<script>
function search_subject(str)
{
var xmlhttp= new XMLHttpRequest();	
xmlhttp.open("get","search_ajax_notice_subject.php?cls_id="+str,true);
xmlhttp.send();
xmlhttp.onreadystatechange=function()
{
if(xmlhttp.status==200  && xmlhttp.readyState==4)
{
document.getElementById("search_sub").innerHTML=xmlhttp.responseText;
}
} 
}
</script>

	<div class="col-md-1" style="font-size:16px;margin-left:50px;">Subject : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:200px;" name="subject" id="search_sub" class="form-control">
	<option value="" selected="selected" disabled>--- Select Subject ---</option>
	</select>
	</div>

</div><br>


<div class="row" style="margin-top:50px;margin-left:20px;">
	
	<div class="col-md-2" style="font-size:16px;text-align:right;margin-left:50px;">Parent Number </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<input type="checkbox" name="number" value="parent" checked>
	</div>
	
	<div class="col-md-2" style="font-size:16px;text-align:right;margin-left:-90px;">Student Number </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<input type="checkbox" name="number" value="student">
	</div>
</div>


<div class="row" style="margin-top:50px;margin-left:20px;margin-bottom:50px;">
	<div class="col-md-1" style="font-size:14px;margin-top:20px;">Message</div>
	<div class="col-md-2" style="font-size:14px;"></div>
	<textarea id="composetext" name="composetext" class="form-control" style="width:300px;height:200px;margin-left:140px;position:absolute;" required></textarea>
	
	<div class="col-md-2"></div>
	<div class="col-md-2" style="font-size:14px;margin-top:150px;">Char Count</div>
	<div class="col-md-2" style="margin-top:-8px;margin-top:150px;">
		<input type="text" name="charcount" class="form-control" id="charcount" style="margin-left:-25px;" readonly>		
	</div>
</div>
<hr style="height:2px solid grey">

<div>
<input type="submit" name="sms" value="Send" id="add" style="margin-left:350px;" class="btn btn-primary btn-md"/>
<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-primary btn-md"/>
</div>
</form>

<script>
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
</script>

	
<script>
	$(function () {
		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 
		$('#composetext').keyup(function () {
			var tsms=1;
			//.val() will give the text from the textbox and .length will give the number of characters
			var txtlen = $(this).val().length;
			
			if(txtlen>=160)
			{
				var tsms=tsms+1;
			}
			
			//alert('Hi');
			//the below lines will display the results 
			$('#charcount').val(txtlen);
			$('#smscount').val(tsms);
			
		});
	});
</script>
	
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 