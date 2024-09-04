<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

//date_default_timezone_set('Asia/Kolkata');

$email=$_SESSION['user_logged_in'];

$username=$res['username'];

$x=1;

if(isset($sms))

{
	// echo "<pre>";
	// print_r($_POST);
	// die;

	$set=mysqli_query($con,"select * from sms_setting where sms_id= 1 ");

	$rset=mysqli_fetch_array($set);

	$senderid=$rset['sender_id'];

	$apiurl=$rset['api_url'];

	$apikey=$rset['api_key'];

	

	$category = $_REQUEST['category'];

	

	if($classid5)

	{

		$classid = $_REQUEST['classid5'];

	}

	else if($classid4)

	{

		$classid = $_REQUEST['classid4'];

	}

	else if($classid1)

	{

	    $classid = $_REQUEST['classid1'];

	}

	else if($classid2)

	{

		$classid = $_REQUEST['classid2'];

	}

	else if($classid3)

	{

		$classid = $_REQUEST['classid3'];

	}

	

	if($section5)

	{

		$section = $_REQUEST['section5'];

	}

	else if($section4)

	{

		$section = $_REQUEST['section4'];

	}

	else if($section1)

	{

		$section = $_REQUEST['section1'];

	}

	else if($section2)

	{

		$section = $_REQUEST['section2'];

	}

	else if($section3)

	{

		$section = $_REQUEST['section3'];

	}


	$subject = $_REQUEST['subject'];   

    $composetext1 = $_REQUEST['composetext1'];

    $composetext2 = $_REQUEST['composetext2'];

    $composetext3 = $_REQUEST['composetext3'];

    $composetext5 = $_REQUEST['composetext5'];

	

	$stuid = $_REQUEST['to'];

	

	$heading = $_REQUEST['heading'];

	$heading1 = $_REQUEST['heading1'];

	

	if($category==1)

	{

		$compose = $composetext1;

	}

	else if($category==2)

	{

		$compose = $composetext2;

	}

	else if($category==3)

	{

		$compose = $composetext3;

	}

	else if($category==5)

	{

		$compose = $composetext5;

	}

    

	//

	if($category=="1")

	{

	$que=mysqli_query($con,"select * from students where stu_status='0'  && session='".$_SESSION['session']."'");

		$row = mysqli_num_rows($que);

		if($row)

		{

			$action = "Announcement Sent."; 

			$messagetype = "announcement";

		}

	}

	else if($category=="2")

	{

	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$section'  && session='".$_SESSION['session']."'");

		$row = mysqli_num_rows($que);

		if($row)

		{

			$cl = mysqli_query($con,"select * from class where class_id='$classid'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			

			$se = mysqli_query($con,"select * from section where section_id='$section'");

			$rse = mysqli_fetch_array($se);

			$sename = $rse['section_name'];

			

			$action = "Homework Sent to Class ".$clname." Section ".$sename."."; 

			$messagetype = "assignment";

		}

	}

	else if($category=="3")

	{

	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$section'  && session='".$_SESSION['session']."'");

		$row = mysqli_num_rows($que);

		if($row)

		{

			$cl = mysqli_query($con,"select * from class where class_id='$classid'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			

			$se = mysqli_query($con,"select * from section where section_id='$section'");

			$rse = mysqli_fetch_array($se);

			$sename = $rse['section_name'];

			

			$action = "Message Sent to Class ".$clname."Section ".$sename.".";

			$messagetype = "messages";

		}

	}

	else if($category=="4")

	{

		if($classid=="All" && $section=="All")

		{

		$quen=mysqli_query($con,"select * from students where stu_status='0'  && session='".$_SESSION['session']."' ");

			$clname = "All";

			$sename = "All";

		}

		else if($classid!="" && $section=="All")

		{

		$quen=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid'  && session='".$_SESSION['session']."'");	

			$cl = mysqli_query($con,"select * from class where class_id='$classid'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			$sename = "All";

		}

		else

		{

		$quen=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$section'  && session='".$_SESSION['session']."'");

			$cl = mysqli_query($con,"select * from class where class_id='$classid'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			

			$se = mysqli_query($con,"select * from section where section_id='$section'");

			$rse = mysqli_fetch_array($se);

			$sename = $rse['section_name'];

		}

		

		$row = mysqli_num_rows($quen);

		if($row)

		{

			$action = "Photo Gallery Sent to Class ".$clname." Section ".$sename."."; 

			$messagetype = "photogallery";

		}

	}

	else if($category=="6")

	{

	$quen=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$section'  && session='".$_SESSION['session']."' ");

		$row = mysqli_num_rows($quen);

		if($row)

		{

			$cl = mysqli_query($con,"select * from class where class_id='$classid'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			

			$se = mysqli_query($con,"select * from section where section_id='$section'");

			$rse = mysqli_fetch_array($se);

			$sename = $rse['section_name'];

			$action = "Study Material Sent to Class ".$clname." Section ".$sename."."; 

			$messagetype = "study_material";

		}

	}

	else if($category=="5")

	{

			$totalcount = count($stuid);

			if($totalcount>0)

			{

				$action = "Important Information Sent."; 

				$messagetype = "important_information";

			}

			

		foreach($stuid as $k)

		{

			$que1=mysqli_query($con,"select * from students where student_id='$k'  && session='".$_SESSION['session']."' ");

			$r1 = mysqli_fetch_array($que1);

			$classid=$r1['class_id'];

			$section=$r1['section_id'];

			$mobile=$r1['parent_no'];

			$msgtype=$r1['msg_type_id'];

			

			if($check)

			{

				if($msgtype==1)

				{

				$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)

				values('$category','$k','$classid','$section','$mobile','$compose','$username',now(),now())");

				

				//Send message via whatsapp

				$encod=urlencode($compose);

				$msg = $encod;

				sendwhatsappMessage($mobile, $msg, $messagetype);

				// if($x==2){
				// 	die;
				// }
				// $x++;

				//Send message via whatsapp

				}

				

				//Send text message

				$msg =$compose; 

				sendtextMessage($mobile, $msg, $messagetype);

				//Send text message
			}else

			{

				if($msgtype==1)

				{

				$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)

				values('$category','$k','$classid','$section','$mobile','$compose','$username',now(),now())");

				

				//Send message via whatsapp

				$encod=urlencode($compose);

				$msg = $encod;

				sendwhatsappMessage($mobile, $msg, $messagetype);

				//Send message via whatsapp

				

				}else if($msgtype==2){

					

				//Send text message

				$msg =$compose; 

				// sendtextMessage($mobile, $msg, $messagetype);

				//Send text message

				

				}

			}

		}

	}

	
if($que){
	while($resz=mysqli_fetch_array($que))

	{		

		$msgtype=$resz['msg_type_id'];

		$studid=$resz['student_id'];

		$classid=$resz['class_id'];

		$section=$resz['section_id'];

		$mobile=$resz['parent_no'];

		

		$name1 = $_FILES["file1"]["name"];

		$img_name1 = $_FILES['file1']['name'];

		$imgstr = implode(",", $img_name1);

		

		$name2 = $_FILES["file2"]["name"];

		$img_name2 = $_FILES['file2']['name'];

		$imgstr2 = implode(",", $img_name2);

		

		if($check)

		{

			if($msgtype==1)

			{

				$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)

				values('$category','$studid','$classid','$section','$subject','$mobile','$compose','$username',now(),now())");

			

				//Send message via whatsapp
				$encod=urlencode($compose);

				$msg = $encod;

				sendwhatsappMessage($mobile, $msg, $messagetype);

				// if($x==2){
				//     	die;
				//     }
				// $x++;

			}
				//Send text message

				$msg =$compose; 

				sendtextMessage($mobile, $msg, $messagetype);

				//Send text message

		}else{

			if($msgtype==1)

			{

				$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)

				values('$category','$studid','$classid','$section','$subject','$mobile','$compose','$username',now(),now())");

			

				//Send message via whatsapp

				$encod=urlencode($compose);

				$msg = $encod;

				sendwhatsappMessage($mobile, $msg, $messagetype);

				// if($x==2){
				//     	die;
				//     }
				// $x++;

				//Send message via whatsapp

				

			}else if($msgtype==2){

				

				//Send text message

				$msg = $compose; 

				// sendtextMessage($mobile, $msg, $messagetype);

				//Send text message

			}

		}

		

	}

}

if($quen){

	while($resz1=mysqli_fetch_array($quen))

	{

		$msgtype=$resz1['msg_type_id'];

		$studid=$resz1['student_id'];

		$classid=$resz1['class_id'];

		$section=$resz1['section_id'];

		$mobile=$resz1['parent_no'];

	

		$name1 = $_FILES["file1"]["name"];

		$img_name1 = $_FILES['file1']['name'];

		$imgstr = implode(",", $img_name1);

		

		$name2 = $_FILES["file2"]["name"];

		$img_name2 = $_FILES['file2']['name'];

		$imgstr2 = implode(",", $img_name2);

		

			if($imgstr!="")

			{

				foreach ($_FILES["file1"]["error"] as $key => $error) 

					{

						if ($error == UPLOAD_ERR_OK) 

						{

							$tmp_name1 = $_FILES["file1"]["tmp_name"][$key];

							$name1 = $_FILES["file1"]["name"][$key];

							

							move_uploaded_file($tmp_name1, "gallery/$name1"); 

							

							$img_name1=$_FILES['file1']['name'];

							$imgstr = implode(",", $img_name1);

						}

					}

				

				$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,photos,loginuser,notice_datetime,date)

				values('$category','$studid','$classid','$section','$mobile','$heading','$imgstr','$username',now(),now())");

			}

			else if($imgstr2!="")

			{

				foreach ($_FILES["file2"]["error"] as $key => $error) 

					{

						if ($error == UPLOAD_ERR_OK) 

						{

							$tmp_name2 = $_FILES["file2"]["tmp_name"][$key];

							$name2 = $_FILES["file2"]["name"][$key];

							

							move_uploaded_file($tmp_name2, "gallery/$name2"); 

							

							$img_name2=$_FILES['file2']['name'];

							$imgstr2 = implode(",", $img_name2);

						}

					}

				

				$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,photos,loginuser,notice_datetime,date)

				values('$category','$studid','$classid','$section','$mobile','$heading1','$imgstr2','$username',now(),now())");

			}

				

	}

	}

		$queaction = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

		machine_name,browser,date) 

		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

	

		echo "<script>window.location='dashboard.php?option=student_notification'</script>";

}



?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>

	

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



<script type="text/javascript">

        // Load the Google Transliteration API

        google.load("elements", "1", {

          packages: "transliteration"

        });



        function language(str) {

			if(str=="hi")

			{

			var options = {

            sourceLanguage: 'en',

            destinationLanguage: ['hi'],

            shortcutKey: 'ctrl+m',

            transliterationEnabled: true

			}

			}

			else if(str=="en")

			{

			var options = {

            sourceLanguage: 'en',

            destinationLanguage: ['en'],

            shortcutKey: 'ctrl+m',

            transliterationEnabled: true

			}	

			}

		

		  // Create an instance on TransliterationControl with the required options.

          var control = new google.elements.transliteration.TransliterationControl(options);



          // Enable transliteration in the textfields with the given ids.

         

		  var categ = $("#category").val();

		  if(categ==1)

		  {

			var ids = ["composetext1"];

            control.makeTransliteratable(ids);

		  }

		  else if(categ==2)

		  {

			var ids = ["composetext2"];

            control.makeTransliteratable(ids);

		  }

		  else if(categ==3)

		  {

			var ids = ["composetext3"];

            control.makeTransliteratable(ids);

		  }

		  else if(categ==5)

		  {

			var ids = ["composetext5"];

            control.makeTransliteratable(ids);

		  }	



          // Show the transliteration control which can be used to toggle between English and Hindi and also choose other destination language.

          control.showControl('translControl');

        }



        google.setOnLoadCallback(onLoad);

      </script>



<!-- breadcrumb-->

<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Student Panel</a>

  <a class="breadcrumb-item" href="#"> Notification</a>

  <span class="breadcrumb-item active"> Send Notification</span>

</nav>

<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 

<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2" style="font-size:16px;">Category : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="category" id="category" class="form-control" onchange="test456(), 

	totalstu(this.value)" required>

	<option value="" selected="selected" disabled>--- Select Category ---</option>

	<option value="1">Announcements</option>						

	<option value="2">Homework/Assignment</option>						

	<option value="3">Messages</option>						

	<option value="4">Photo Gallery</option>						

	<option value="5">Important Information</option>						

	<option value="6">Study Materials</option>						

	</select>

	</div>

	

	<div class="col-md-2" style="font-size:16px;margin-left:100px;">Select Languaue : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" class="form-control" onchange="language(this.value)" required>

	<option value="en">English</option>						

	<option value="hi">Hindi</option>						

	</select>

	</div>

</div>

<br><br>



	<script>

	function test456()

	{

		var p = document.getElementById("category").value

		if(p=="1")

		{

			document.getElementById("announ").style="display:block";

			document.getElementById("composetext1").required=true;

			document.getElementById("homework").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("impinfo").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:block";

		}

		else if(p=="2")

		{	
			const collection = document.getElementsByClassName("composetext");
                 // collection[0].required=false;
            for (i = 0; i < collection.length; i++) {
				  console.log(collection[i]);
				} 

			 // collection.forEach(function(collection) {
			// 	    console.log(collection);
			// 	});   

			document.getElementById("homework").style="display:block";

			document.getElementById("class1").required=true;

			document.getElementById("section1").required=true;

			document.getElementById("subject1").required=true;

			document.getElementById("composetext2").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("impinfo").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:block";

		}

		else if(p=="3")

		{

			document.getElementById("message").style="display:block";

			document.getElementById("class2").required=true;

			document.getElementById("section2").required=true;

			document.getElementById("composetext3").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("homework").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("impinfo").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:block";

		}

		else if(p=="4")

		{

			document.getElementById("gallery").style="display:block";

			document.getElementById("class3").required=true;

			document.getElementById("section3").required=true;

			document.getElementById("heading").required=true;

			document.getElementById("file1").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("homework").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("impinfo").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:none";

		}

		else if(p=="5")

		{

			document.getElementById("impinfo").style="display:block";

			document.getElementById("class4").required=true;

			document.getElementById("section4").required=true;

			document.getElementById("composetext5").required=true;

			document.getElementById("study").style="display:none";

			document.getElementById("announ").style="display:none";

			document.getElementById("homework").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("check").style="display:block";

		}

		else if(p=="6")

		{

			document.getElementById("study").style="display:block";

			document.getElementById("class5").required=true;

			document.getElementById("section5").required=true;

			document.getElementById("heading1").required=true;

			document.getElementById("file2").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("homework").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("impinfo").style="display:none";

			document.getElementById("check").style="display:none";

		}

	}

	

		function totalstu(str)

			{

			

				if(str == 1 || str==4)

				{					

				var xmlhttp= new XMLHttpRequest();

				xmlhttp.open("get","count_ajax_student.php?cat="+str,true);

				xmlhttp.send();

				xmlhttp.onreadystatechange=function()

				{

				if(xmlhttp.status==200  && xmlhttp.readyState==4)

				{

				document.getElementById("stucount").value=xmlhttp.responseText;

				

				}

				} 

				}

			}

			

		function totalstu1(strr)

			{

		

			var cls=$("#class1").val();

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":cls,"secid":strr};

			

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}

			

		function totalstu2(strr)

			{

		

			var cls=$("#class2").val();

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":cls,"secid":strr};

			

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}

			

		function totalstu3(strr)

			{

		

			var cls=$("#class3").val();

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":cls,"secid":strr};

			

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}

			

		function totalstu31(strr)

			{

		

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":strr};

			

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}	

			

		function totalstu4(strr)

			{

				

			var cls=$("#class4").val();

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":cls,"secid":strr};

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}

			

		function totalstu5(strr)

			{

			var cls=$("#class5").val();

			var cate=$("#category").val();

			var datastr={"cat":cate,"clid":cls,"secid":strr};

			

			$.ajax({

				url:'count_ajax_student.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					$("#stucount").val(str);

				}

			});

			

			}	

					



	</script>





<div class="row">

<!---- Announcements ---->

	<div class="col-md-12" id="announ" style="display:none">

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="font-size:14px;margin-top:20px;">Message : </div>

		<div class="col-md-2">

		<textarea id="composetext1" name="composetext1" class="form-control composetext" style="width:300px;height:200px;"></textarea>

		</div>

	</div>

	</div>

<!---- Announcements ---->



<!---- Homework ---->

	<div class="col-md-12" id="homework" style="display:none">

	<div class="row" style="margin-left:22px;">

	<div class="col-md-1" style="font-size:16px;">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;margin-left:-20px;" name="classid1" id="class1" class="form-control" 

	onchange="search_sec(this.value); totalstu2(this.value)">

	<option value="" selected="selected" disabled>Select Class</option>

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

xmlhttp.open("get","search_ajax_staff_section1.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("section1").innerHTML=xmlhttp.responseText;

}

} 

}

</script>





	<div class="col-md-2" style="margin-left:20px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-80px;">

	<select style="width:190px;" name="section1" id="section1" class="form-control" onchange="totalstu1(this.value)">

	<option value="" selected="selected" disabled>Select Section</option>							

	</select>

	</div>



<script>

function search_subject(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_notice_subject1.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("subject1").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:50px;" id="sub">Subject : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-80px;">

	<select style="width:200px;" name="subject" id="subject1" class="form-control">

	<option value="0" selected="selected"> All </option>

	</select>

	</div>

	</div><br>

	

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="margin-top:20px;">Message : </div>

		<div class="col-md-2">

		<textarea id="composetext2" name="composetext2" class="form-control" style="width:300px;height:200px;"></textarea>

		</div>

	</div>

	</div>

<!---- Homework ---->



<!---- Message ---->

	<div class="col-md-12" id="message" style="display:none">

	<div class="row" style="margin-left:22px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2">

	<select style="width:200px;" name="classid2" id="class2" class="form-control" 

	onchange="search_sec2(this.value)">

	<option value="" selected="selected" disabled>Select Class</option>

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

function search_sec2(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_staff_section1.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("section2").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:100px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="section2" id="section2" class="form-control" onchange="totalstu2(this.value)">

	<option value="" selected="selected" disabled>--- Select Section ---</option>							

	</select>

	</div>



	</div><br>

	

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="font-size:14px;margin-top:20px;">Message : </div>

		<div class="col-md-2" style="font-size:14px;">

		<textarea id="composetext3" name="composetext3" class="form-control" style="width:300px;height:200px;"></textarea>

		</div>

	</div>

	</div>

<!---- Message ---->



<!---- photo gallery ---->

	<div class="col-md-12" id="gallery" style="display:none">

	<div class="row" style="margin-left:22px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2">

	<select style="width:200px;" name="classid3" id="class3" class="form-control" 

	onchange="search_sec3(this.value); totalstu31(this.value)">

	<option selected="selected">All</option>

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

function search_sec3(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("section3").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:100px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="section3" id="section3" class="form-control" onchange="totalstu3(this.value)">

	<option selected="selected"> All </option>							

	</select>

	</div>



	</div><br>

	

	<div class="row">

	<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

	<div class="col-md-8" style="margin-top:20px;">

	<input type="text" name="heading" id="heading" class="form-control" style="margin-left:-10px;width:645px;">

	</div>

	</div>

	

	<div class="row" style="margin-top:30px;margin-bottom:20px;">

	<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Path : </div>

	<div class="col-md-8" style="margin-top:20px;">

	<input type="file" name="file1[]" id="file1" accept="image/*" style="margin-left:-10px;" multiple>

	</div>

	</div><br>

	

	</div>

<!---- photo gallery ---->



<!---- Important Information ---->

	<div class="col-md-12" id="impinfo" style="display:none">

	<div class="row" style="margin-left:22px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="classid4" id="class4" class="form-control" 

	onchange="search_sec4(this.value)">

	<option value="" selected="selected" disabled>Select Class</option>

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

function search_sec4(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("section4").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:100px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="section4" id="section4" class="form-control" onchange="totalstu4(this.value); showstu(this.value)">

	<option value="" selected="selected" disabled>--- Select Section ---</option>							

	</select>

	</div>

	</div><br>

	

<script>

function showstu(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_impinfo_students.php?sec_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("students").innerHTML=xmlhttp.responseText;

}

} 

}

</script>

	

	<div class="row">

	<div class="col-md-4" style="margin-left:35px;">Student List </div>

	<div class="col-md-2" style="margin-left:20px;"></div>

	<div class="col-md-4" style="margin-left:80px;">Selected Students </div>

	</div>

	

	<div class="row">

	 <div class="col-md-5">

        <select name="from[]" id="students" class="multiselect form-control" size="8" multiple="multiple" data-right="#multiselect_to_1" data-right-all="#right_All_1" data-right-selected="#right_Selected_1" data-left-all="#left_All_1" data-left-selected="#left_Selected_1">

        </select>

    </div>

    

    <div class="col-md-2">

        <button type="button" id="right_All_1" class="btn btn-block btn-light border"><i class="fa fa-forward"></i></button>

        <button type="button" id="right_Selected_1" class="btn btn-block btn-light border"><i class="fa fa-chevron-right"></i></button>

        <button type="button" id="left_Selected_1" class="btn btn-block btn-light border"><i class="fa fa-chevron-left"></i></button>

        <button type="button" id="left_All_1" class="btn btn-block btn-light border"><i class="fa fa-backward"></i></button>

    </div>

    

    <div class="col-md-5">

        <select name="to[]" id="multiselect_to_1" class="form-control" size="8" multiple="multiple"></select>

    </div>

	</div><br>

	

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

	<div class="col-md-2">Message : </div>

	<div class="col-md-4">

	<textarea id="composetext5" name="composetext5" class="form-control" style="width:300px;height:200px;"></textarea>

	</div>

	</div>

	

	</div>

<!---- Important Information ---->



<!---- Study Material ---->

	<div class="col-md-12" id="study" style="display:none">

	<div class="row" style="margin-left:22px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="classid5" id="class5" class="form-control" 

	onchange="search_sec5(this.value);">

	<option value="" selected="selected" disabled>Select Class</option>

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

function search_sec5(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("section5").innerHTML=xmlhttp.responseText;

}

} 

}

</script>



	<div class="col-md-2" style="margin-left:100px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:200px;" name="section5" id="section5" class="form-control" onchange="totalstu5(this.value)">

	<option value="" selected="selected" disabled>--- Select Section ---</option>							

	</select>

	</div>

	</div><br>

	

	<div class="row">

	<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Message : </div>

	<div class="col-md-8" style="font-size:14px;margin-top:20px;">

	<input type="text" name="heading1" id="heading1" class="form-control" style="margin-left:-10px;width:645px;">

	</div>

	</div>

	

	<div class="row" style="margin-top:30px;margin-bottom:20px;">

	<div class="col-md-3" style="margin-top:20px;margin-left:40px;">Select Material : </div>

	<div class="col-md-8" style="margin-top:20px;">

	<input type="file" name="file2[]" id="file2" style="margin-left:-98px;" multiple>

	</div>

	</div><br>

	

	</div>

<!---- Study Material ---->



</div>



<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;" id="stcount">	

	<div class="col-md-2" style="font-size:14px;">Characters : </div>

	<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="charcount" class="form-control" id="charcount"  readonly>		

	</div>

	<div class="col-md-2" style="margin-left:50px;">Student Count : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">

		<input type="text" name="stucount" class="form-control" id="stucount" style="margin-left:-55px;" readonly>		

	</div>

</div>



<hr style="height:2px solid grey">



<div class="row" style="margin-top:50px;">

<div class="col-md-3">

</div>

<div class="col-md-2"  id="check">

<input type="checkbox" name="check"/><span style="margin-left:5px;">Send Bulk SMS</span>

</div>

<div class="col-md-3">

<input type="submit" name="sms" value="Send Now" id="add" class="btn btn-primary btn-sm"/>

<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm"/>

</div>

</div>

<br/><br> 

<hr/>



</form>





<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext1').keyup(function () {

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

			

		});

	});

</script>



<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext2').keyup(function () {

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

			

		});

	});

</script>



<script>

	$(function () {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext3').keyup(function () {

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

			

		});

	});

</script>

 

<script type="text/javascript">

jQuery(document).ready(function($) {

    $('.multiselect').multiselect();

});

</script>