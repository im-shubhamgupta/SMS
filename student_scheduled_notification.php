<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

$email=$_SESSION['user_logged_in'];
$username=$res['username'];

if(isset($save))
{
	$category = $_REQUEST['category'];
	$dtime = $_REQUEST['dttime'];
	$datetime = date("Y-m-d h:i:s",strtotime($dtime));
	
	if($category==1)
	{
		$compose = $composetext1;
	}
	else if($category==3)
	{
		$compose = $composetext3;
	}
	
	if($classid2)
	{
		$classid = $_REQUEST['classid2'];
	}
	
	if($section2)
	{
		$section = $_REQUEST['section2'];
	}
	
	if($category=="1")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0'");
	}
	else if($category=="3")
	{
	$que=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$section'");
	}
	
	while($resz=mysqli_fetch_array($que))
	{		
		$studid=$resz['student_id'];
		$mobile=$resz['parent_no'];
		$classid=$resz['class_id'];
		$section=$resz['section_id'];
		
	
		$q1=$con->query("insert into student_scheduled_notifications(category,student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)
		values('$category','$studid','$classid','$section','$mobile','$compose','$username','$datetime','$datetime')");
		
		if(mysqli_error($con)){
			echo ("Error description :" .mysqli_error($con));
		}
		
	
	echo "<script>window.location='dashboard.php?option=student_scheduled_notification'</script>";
	}
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
			if(str=="kn")
			{
			var options = {
            sourceLanguage: 'en',
            destinationLanguage: ['kn'],
            shortcutKey: 'ctrl+m',
            transliterationEnabled: true
			}
			}
			else if(str=="te")
			{
			var options = {
            sourceLanguage: 'en',
            destinationLanguage: ['te'],
            shortcutKey: 'ctrl+m',
            transliterationEnabled: true
			}
			}
			else
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
  <span class="breadcrumb-item active"> Schedule Notification</span>
</nav>
<!-- breadcrumb -->
<form method="post" enctype="multipart/form-data"> 
<div class="row" style="margin-top:50px;margin-left:20px;">
	<div class="col-md-2">Category : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:200px;" name="category" id="category" class="form-control" onchange="test456(), 
	totalstu(this.value)" required>
	<option value="" selected="selected" disabled>--- Select Category ---</option>
	<option value="1">Announcements</option>						
	<option value="3">Messages</option>						
	</select>
	</div>
	
	<div class="col-md-2" style="font-size:16px;margin-left:100px;">Select Languaue : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:200px;" class="form-control" onchange="language(this.value)" required>
	<option value="en">English</option>						
	<option value="kn">Kannada</option>						
	<option value="te">Telugu</option>						
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
			document.getElementById("message").style="display:none";
			
		}
		else if(p=="3")
		{
			document.getElementById("message").style="display:block";
			document.getElementById("class2").required=true;
			document.getElementById("section2").required=true;
			document.getElementById("composetext3").required=true;
			document.getElementById("announ").style="display:none";
			
		}
		
	}
	
		function totalstu(str)
			{
			
				if(str == 1)
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
			
	</script>


<div class="row">
<!---- Announcements ---->
	<div class="col-md-12" id="announ" style="display:none">
	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">
		<div class="col-md-2" style="margin-top:20px;">Message : </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<textarea id="composetext1" name="composetext1" class="form-control" style="width:300px;height:200px;"></textarea>
		</div>
	</div>
	</div>
<!---- Announcements ---->


<!---- Message ---->
	<div class="col-md-12" id="message">
	<div class="row" style="margin-left:22px;">
	<div class="col-md-2">Class : </div>
	<div class="col-md-2" style="margin-top:-8px;margin-left:18px;">
	<select style="width:200px;margin-left:-20px;" name="classid2" id="class2" class="form-control" 
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

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Section : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select style="width:190px;" name="section2" id="section2" class="form-control" onchange="totalstu2(this.value)">
	<option value="" selected="selected" disabled>--- Select Section ---</option>							
	</select>
	</div>



	</div><br><br>
	
	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:200px;">
		<div class="col-md-2" style="font-size:14px;margin-top:20px;">Message : </div>
		<div class="col-md-2" style="font-size:14px;"></div>
		<textarea id="composetext3" name="composetext3" class="form-control" style="width:300px;height:200px;margin-left:212px;position:absolute;"></textarea>
	</div><br>
	</div>
<!---- Message ---->


</div>

<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;" id="stcount">	
	<div class="col-md-2">Characters : </div>
	<div class="col-md-2" style="margin-top:-8px;margin-left:75px;">
		<input type="text" name="charcount" class="form-control" id="charcount" style="margin-left:-75px;" readonly>		
	</div>
	<div class="col-md-2" style="margin-left:30px">Student Count : </div>
	<div class="col-md-2" style="margin-top:-8px;margin-left:75px;">
		<input type="text" name="stucount" class="form-control" id="stucount" style="margin-left:-55px;" readonly>		
	</div>
</div>

<hr style="height:2px solid grey">


<div class="row" style="margin-top:40px;margin-bottom:40px;">
	
	<div class="col-md-2" style="margin-top:5px;margin-left:220px;">Schedule at :</div>

	<div class="col-md-3">
	<input type="datetime-local" name="dttime" class="form-control" style="width:250px;margin-left:-50px;"/>
	</div>
</div>
<hr style="height:2px solid grey">

<div class="row" style="margin-top:40px;margin-bottom:40px;">
	
	<input type="submit" value="Schedule Now" name="save" style="margin-left:350px;" class="btn btn-primary btn-md"/>
	
	<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-info btn-md"/>
	
</div>

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