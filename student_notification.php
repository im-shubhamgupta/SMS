<?php

error_reporting(1);

include('connection.php');

$school_name=get_school_details()['company_name'];
$Schlength=strlen($school_name);
if($Schlength > 29 ){   //divide the school name into two part for important imformation msg
	$output[0] = substr($school_name, 0, 29);
	$output[1] = substr($school_name,29,$Schlength);
	
}else{
	$output[0] = $school_name;
	$output[1] = '';

}
// print_r($output);
// header('Content-Type: text/html; charset=utf-8');
// include $_SERVER['DOCUMENT_ROOT']."/header.php";
?>
<script>
	// webview1.loadData(hindi_content, "text/html; charset=UTF-8", null);


	// webview1.loadDataWithBaseURL(null, hindi_content, "text/html", "utf-8", null);
</script>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<!-- <META HTTP-EQUIV="content-type" CONTENT="text/html"; charset="utf-8\"> -->
<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>



<style>
</style>



<script type="text/javascript">
	$(document).ready(function() {

		$(".menu a").each(function() {

			if ($(this).hasClass("disabled")) {

				$(this).removeAttr("href");

			}

		});

	});
</script>
<script>
	function triggercheckbox(check) {

		var num = check;
		if (num == 5) {
			// console.log(5);

			$('#checkbulk').trigger("click");
			// $('#checkbulk').attr('checked',true);
		} else {
			$('#checkbulk').attr('checked', false);

		}

	}
</script>


<script type="text/javascript">
	// Load the Google Transliteration API

	google.load("elements", "1", {

		packages: "transliteration"

	});



	function language(str) {

		if (str == "hi")

		{

			var options = {

				sourceLanguage: 'en',

				destinationLanguage: ['hi'],

				shortcutKey: 'ctrl+m',

				transliterationEnabled: true

			}

		} else if (str == "en")

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

		if (categ == 1)

		{

			var ids = ["composetext1"];

			control.makeTransliteratable(ids);

		} else if (categ == 2)

		{

			var ids = ["composetext2"];

			control.makeTransliteratable(ids);

		} else if (categ == 3)

		{

			var ids = ["composetext3"];

			control.makeTransliteratable(ids);

		} else if (categ == 5)

		{

			var ids = ["composetext5"];

			control.makeTransliteratable(ids);

		}



		// Show the transliteration control which can be used to toggle between English and Hindi and also choose other destination language.

		control.showControl('translControl');

	}



	// google.setOnLoadCallback(onLoad);
</script>



<!-- breadcrumb-->

<style>
	input[type=checkbox] {

		zoom: 1.8;

		margin-top: 5px;

	}
</style>

<nav class="breadcrumb" >

	<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

	<a class="breadcrumb-item" href="#">Communiction Panel</a>
	<a class="breadcrumb-item" href="#">Student Communiction </a>

	<!-- <a class="breadcrumb-item" href="#"> Notification</a> -->

	<span class="breadcrumb-item active"> Send Notification</span>

</nav>

<!-- breadcrumb -->

<form method="post" id="devel-generate-content-form" enctype="multipart/form-data">

	<div class="row" style="margin-top:50px;margin-left:20px;margin-right: 229px;" >

		<div class="col-md-2" style="font-size:16px;">Category : </div>

		<div class="col-md-2" style="margin-top:-8px;">
		<?php
		$cat_sql="SELECT * from sms_category where status ='1' ";
		$cat_query=mysqli_query($con,$cat_sql);
		?>

			<select style="width:200px;" name="category" id="category" class="form-select" onchange="test456(), 

	totalstu(this.value),triggercheckbox(this.value)" required>

				<option value="" selected="selected" disabled>--- Select Category ---</option>

				<?php
				if(mysqli_num_rows($cat_query)>0){
					while($cat_row=mysqli_fetch_assoc($cat_query)){
						echo '<option value="'.$cat_row['id'].'">'.$cat_row['category_name'].'</option>';
				    }	
			    }

				?>

				<!-- <option value="1">Announcements</option>

				<option value="2">Homework/Assignment</option>

				<option value="3">Messages</option>

				<option value="4">Photo Gallery</option>

				<option value="5">Important Information</option>

				<option value="6">Study Materials</option> -->

			</select>

		</div>



		<div class="col-md-3" style="font-size:16px;margin-left:100px;">Select Languaue : </div>

		<div class="col-md-2" style="margin-top:-8px;">

			<select style="width:200px;" class="form-select" required>
				<!-- onchange="language(this.value)" -->
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

			if (p == "1")

			{ //use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error

				document.getElementById("announ").style = "display:block";

				document.getElementsByClassName("composetext").required = false;

				document.getElementById("composetext1").required = true;
				document.getElementById("heading_announce").required = true;

				document.getElementById("homework").style = "display:none";

				document.getElementById("message").style = "display:none";

				document.getElementById("gallery").style = "display:none";

				document.getElementById("impinfo").style = "display:none";

				document.getElementById("study").style = "display:none";

				document.getElementById("check").style = "display:block";

			} else if (p == "2")

			{
				//use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error
				document.getElementById("homework").style = "display:block";
				document.getElementById("class1").required = true;

				document.getElementById("section1").required = true;

				document.getElementById("subject1").required = true;

				document.getElementById("composetext2").required = true;
				document.getElementById("heading2").required = true;

				document.getElementById("announ").style = "display:none";

				document.getElementById("message").style = "display:none";

				document.getElementById("gallery").style = "display:none";

				document.getElementById("impinfo").style = "display:none";

				document.getElementById("study").style = "display:none";

				document.getElementById("check").style = "display:block";

			} else if (p == "3")

			{
				//use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error


				document.getElementById("message").style = "display:block";

				document.getElementById("class2").required = true;

				document.getElementById("section2").required = true;
				document.getElementById("heading3").required = true;

				document.getElementById("composetext3").required = true;

				document.getElementById("announ").style = "display:none";

				document.getElementById("homework").style = "display:none";

				document.getElementById("gallery").style = "display:none";

				document.getElementById("impinfo").style = "display:none";

				document.getElementById("study").style = "display:none";

				document.getElementById("check").style = "display:block";

			} else if (p == "4")

			{
				//use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error

				document.getElementById("gallery").style = "display:block";

				document.getElementById("class3").required = true;

				document.getElementById("section3").required = true;

				document.getElementById("heading").required = true;

				document.getElementById("file1").required = true;

				document.getElementById("announ").style = "display:none";

				document.getElementById("homework").style = "display:none";

				document.getElementById("message").style = "display:none";

				document.getElementById("impinfo").style = "display:none";

				document.getElementById("study").style = "display:none";

				document.getElementById("check").style = "display:none";

			} else if (p == "5")

			{ //use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error

				document.getElementById("impinfo").style = "display:block";
				document.getElementsByClassName("composetext").required = false;
				document.getElementById("class4").required = true;

				document.getElementById("section4").required = true;

				document.getElementById("text_template").required = true;
				// document.getElementsByClassName("composetext5").required=true;

				document.getElementById("study").style = "display:none";

				document.getElementById("announ").style = "display:none";

				document.getElementById("homework").style = "display:none";

				document.getElementById("message").style = "display:none";

				document.getElementById("gallery").style = "display:none";

				document.getElementById("check").style = "display:block";
				// document.getElementById("check").checked = true;
				// document.form.elements['check'].checked = true;
				// var ch=document.getElementById("check").value;
				// alert(ch);
				// ch.click();
				// // body.dispatchEvent(new Event('click'));
				// ch.addEventListener('click', e => {
				//   console.log('clicked body');
				// }); 


			} else if (p == "6")

			{ //use for remove unecessary error 
				const collection = document.getElementsByClassName("composetext");
				for (i = 0; i < collection.length; i++) {
					collection[i].required = false;
				}
				const h = document.getElementsByClassName("heading");
				for (i = 0; i < h.length; i++) {
					h[i].required = false;
				}
				const f = document.getElementsByClassName("file");
				for (i = 0; i < f.length; i++) {
					f[i].required = false;
				}
				const ci = document.getElementsByClassName("class");
				for (i = 0; i < ci.length; i++) {
					ci[i].required = false;
				}
				const se = document.getElementsByClassName("section");
				for (i = 0; i < se.length; i++) {
					se[i].required = false;
				}
				const subj = document.getElementsByClassName("subject");
				for (i = 0; i < subj.length; i++) {
					subj[i].required = false;
				}
				//use for remove unecessary error

				document.getElementById("study").style = "display:block";

				document.getElementById("class5").required = true;

				document.getElementById("section5").required = true;

				document.getElementById("heading1").required = true;

				document.getElementById("file2").required = true;

				document.getElementById("announ").style = "display:none";

				document.getElementById("homework").style = "display:none";

				document.getElementById("message").style = "display:none";

				document.getElementById("gallery").style = "display:none";

				document.getElementById("impinfo").style = "display:none";

				document.getElementById("check").style = "display:none";

			}

		}



		function totalstu(str)

		{



			if (str == 1 || str == 4)

			{

				var xmlhttp = new XMLHttpRequest();

				xmlhttp.open("get", "count_ajax_student.php?cat=" + str, true);

				xmlhttp.send();

				xmlhttp.onreadystatechange = function()

				{

					if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

					{

						document.getElementById("stucount").value = xmlhttp.responseText;



					}

				}

			}else if(str == 5){
				showstu(); //call for all class
				totalstu4(); //get total stu
			}

		}



		function totalstu1(strr)

		{



			var cls = $("#class1").val();

			var cate = $("#category").val();

			var datastr = {
				"cat": cate,
				"clid": cls,
				"secid": strr
			};



			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

				{

					$("#stucount").val(str);

				}

			});



		}



		function totalstu2(strr)

		{



			var cls = $("#class2").val();

			var cate = $("#category").val();

			var datastr = {
				"cat": cate,
				"clid": cls,
				"secid": strr
			};



			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

				{

					$("#stucount").val(str);

				}

			});



		}



		function totalstu3(strr)

		{



			var cls = $("#class3").val();

			var cate = $("#category").val();

			var datastr = {
				"cat": cate,
				"clid": cls,
				"secid": strr
			};



			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

				{

					$("#stucount").val(str);

				}

			});



		}



		function totalstu31(strr)

		{



			var cate = $("#category").val();

			var datastr = {
				"cat": cate,
				"clid": strr
			};



			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

				{

					$("#stucount").val(str);

				}

			});



		}



		function totalstu4(strr='')

		{



			var cls = $("#class4").val();

			var cate = $("#category").val();
			// alert(cate);

			var datastr = {
				"cat": cate,
				"clid": cls,
				"secid": strr
			};

			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

				{

					$("#stucount").val(str);

				}

			});



		}



		function totalstu5(strr)

		{

			var cls = $("#class5").val();

			var cate = $("#category").val();

			var datastr = {
				"cat": cate,
				"clid": cls,
				"secid": strr
			};



			$.ajax({

				url: 'count_ajax_student.php',

				type: 'post',

				data: datastr,

				success: function(str)

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

				<div class="col-md-2" style="font-size:14px;margin-top:20px;">Title : </div>


				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="heading_announce" id="heading_announce" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>

			<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

				<div class="col-md-2" style="font-size:14px;margin-top:20px;">Message : </div>

				<div class="col-md-2">

					<textarea id="composetext1" name="composetext1" class="form-control composetext " style="width:300px;height:200px;"></textarea>

				</div>

			</div>

		</div>

		<!---- Announcements ---->



		<!---- Homework ---->

		<div class="col-md-12" id="homework" style="display:none">

			<div class="row" style="margin-left:22px;">

				<div class="col-md-1" style="font-size:16px;">Class : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:170px;margin-left:-20px;" name="classid1" id="class1" class="form-select class" onchange="totalstu1(this.value);search_sec(this.value);search_subject(this.value)">

						<option value="" selected="selected" disabled>Select Class</option>

						<?php

						$scls = "select * from class";

						$rcls = mysqli_query($con, $scls);

						while ($rescls = mysqli_fetch_array($rcls)) {

						?>

							<option <?php if ($class == $rescls['class_id']) {
										echo "selected";
									} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

						<?php } ?>

					</select>

				</div>



				<script>
					function search_sec(str)

					{

						var xmlhttp = new XMLHttpRequest();

						xmlhttp.open("get", "search_ajax_staff_section1.php?cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("section1").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>





				<div class="col-md-2" style="margin-left:20px;">Section : </div>

				<div class="col-md-2" style="margin-top:-8px;margin-left:-80px;">

					<select style="width:190px;" name="section1" id="section1" class="form-select section" onchange="totalstu1(this.value)">

						<option value="" selected="selected" disabled>Select Section</option>

					</select>

				</div>



				<script>
					function search_subject(str)

					{

						var xmlhttp = new XMLHttpRequest();

						// xmlhttp.open("get","search_ajax_notice_subject1.php?search_homework_subject=1&cls_id="+str,true);
						xmlhttp.open("get", "search_data.php?search_homework_subject=1&cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("subject1").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>



				<div class="col-md-2" style="margin-left:50px;" id="sub">Subject : </div>

				<div class="col-md-2" style="margin-top:-8px;margin-left:-80px;">

					<select style="width:200px;" name="subject" id="subject1" class="form-select subject">

						<option value="0" selected="selected"> All </option>

					</select>

				</div>

			</div><br>

			<div class="row">

				<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="heading2" id="heading2" class="form-control heading" style="margin-left:-10px;width:645px;">
				</div>
			</div>
			<div class="row" style="margin-top:30px;margin-bottom:20px;">
				<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Attachments : </div>
				<div class="col-md-8" style="margin-top:20px;">
				<!-- accept="image/*" -->
					<input type="file" name="file22[]" id="file22" class="file"  style="margin-left:-10px;" >

				</div>

			</div><br>



			<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

				<div class="col-md-2" style="margin-top:20px;">Message : </div>

				<div class="col-md-2">

					<textarea id="composetext2" name="composetext2" class="form-control composetext" style="width:300px;height:200px;"></textarea>

				</div>

			</div>

		</div>

		<!---- Homework ---->



		<!---- Message ---->

		<div class="col-md-12" id="message" style="display:none">

			<div class="row" style="margin-left:22px;">

				<div class="col-md-2">Class : </div>

				<div class="col-md-2">

					<select style="width:200px;" name="classid2" id="class2" class="form-select class" onchange="totalstu2(this.value);search_sec2(this.value)">

						<option value="" selected="selected" disabled>Select Class</option>

						<?php

						$scls = "select * from class";

						$rcls = mysqli_query($con, $scls);

						while ($rescls = mysqli_fetch_array($rcls)) {

						?>

							<option <?php if ($class == $rescls['class_id']) {
										echo "selected";
									} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

						<?php } ?>

					</select>

				</div>



				<script>
					function search_sec2(str)

					{

						var xmlhttp = new XMLHttpRequest();

						xmlhttp.open("get", "search_ajax_staff_section1.php?cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("section2").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>



				<div class="col-md-2" style="margin-left:100px;">Section : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="section2" id="section2" class="form-select section" onchange="totalstu2(this.value)">

						<option value="" selected="selected" disabled>--- Select Section ---</option>

					</select>

				</div>



			</div><br>


			<div class="row">

				<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="heading3" id="heading3" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>



			<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

				<div class="col-md-2" style="font-size:14px;margin-top:20px;">Message : </div>

				<div class="col-md-2" style="font-size:14px;">

					<textarea id="composetext3" name="composetext3" class="form-control composetext" style="width:300px;height:200px;"></textarea>

				</div>

			</div>

		</div>

		<!---- Message ---->



		<!---- photo gallery ---->

		<div class="col-md-12" id="gallery" style="display:none">

			<div class="row" style="margin-left:22px;">

				<div class="col-md-2">Class : </div>

				<div class="col-md-2">

					<select style="width:200px;" name="classid3" id="class3" class="form-select class" onchange="search_sec3(this.value); totalstu31(this.value)">

						<option selected="selected">All</option>

						<?php

						$scls = "select * from class";

						$rcls = mysqli_query($con, $scls);

						while ($rescls = mysqli_fetch_array($rcls)) {

						?>

							<option <?php if ($class == $rescls['class_id']) {
										echo "selected";
									} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

						<?php } ?>

					</select>

				</div>



				<script>
					function search_sec3(str)

					{

						var xmlhttp = new XMLHttpRequest();

						xmlhttp.open("get", "search_ajax_section.php?cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("section3").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>



				<div class="col-md-2" style="margin-left:100px;">Section : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="section3" id="section3" class="form-select section" onchange="totalstu3(this.value)">

						<option selected="selected"> All </option>

					</select>

				</div>



			</div><br>



			<div class="row">

				<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="heading" id="heading" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>

			<div class="row">

				<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Description : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="message4" id="message4" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>



			<div class="row" style="margin-top:30px;margin-bottom:20px;">

				<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Path : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="file" name="file1[]" id="file1" class="file" accept="image/*" style="margin-left:-10px;" multiple>

				</div>

			</div><br>



		</div>

		<!---- photo gallery ---->



		<!---- Important Information ---->

		<div class="col-md-12" id="impinfo" style="display:none">

			<div class="row" style="margin-left:22px;">

				<div class="col-md-2">Class : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="classid4" id="class4" class="form-select class" onchange="search_sec4(this.value);totalstu4(this.value); showstu(this.value) ">

						<option value="0" selected="selected" >All Classes</option>

						<?php

						$scls = "select * from class";

						$rcls = mysqli_query($con, $scls);

						while ($rescls = mysqli_fetch_array($rcls)) {

						?>

							<option <?php if ($class == $rescls['class_id']) {
										echo "selected";
									} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

						<?php } ?>

					</select>

				</div>



				<script>
					function search_sec4(str)

					{
						// alert()

						var xmlhttp = new XMLHttpRequest();

						xmlhttp.open("get", "search_ajax_section.php?cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("section4").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>



				<div class="col-md-2" style="margin-left:100px;">Section : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="section4" id="section4" class="form-select section" onchange="totalstu4(this.value); showstu(this.value)">

						<option value="" selected="selected" >All Sections </option>

					</select>

				</div>

			</div><br>



			<script>
				function showstu(str=''){
					if(str==''){
						var str='0';
					}

					var xmlhttp = new XMLHttpRequest();

					xmlhttp.open("get", "search_ajax_impinfo_students.php?sec_id=" + str, true);

					xmlhttp.send();

					xmlhttp.onreadystatechange = function()

					{
						if (xmlhttp.status == 200 && xmlhttp.readyState == 4){
							document.getElementById("students").innerHTML = xmlhttp.responseText;
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

				<div class="col-md-5" id="from_div">

					<select data-right="#multiselect_to_1" data-right-all="#right_All_1" data-right-selected="#right_Selected_1" data-left-all="#left_All_1" data-left-selected="#left_Selected_1" name="from[]" id="students" class="multiselect form-control " size="8" multiple="multiple">




						<!-- <select name="from[]" id="students" multiple class="multiselect form-control" size="8" data-right="#multiselect_to_1" data-right-all="#right_All_1"  data-right-selected="#right_Selected_1"  > -->


					</select>



				</div>



				<div class="col-md-2">

					<button type="button" id="right_All_1" class="btn btn-block btn-light border arrow-btn" ><i class="fa fa-forward"></i></button>
					<!-- <div id="right_All_1" class="btn btn-block btn-light border"><i class="fa fa-forward"></i></div> -->

					<button type="button" id="right_Selected_1" class="btn btn-block btn-light border arrow-btn" > <i class="fa fa-chevron-right"></i></button>

					<button type="button" id="left_Selected_1" class="btn btn-block btn-light border arrow-btn"  > <i class="fa fa-chevron-left"></i></button>

					<button type="button" id="left_All_1" class="btn btn-block btn-light border arrow-btn"  ><i class="fa fa-backward"></i></button>

				</div>



				<div class="col-md-5">

					<select name="to[]" id="multiselect_to_1" multiple class="form-select " size="8">


					</select>
					<!-- multiple="multiple" -->

				</div>

			</div><br><br>

			<div class="row">
				<div class="col-2">
					Choose Template:
				</div>
				<div class="col-4">
					<!--  -->
					<select name="text_template" id="text_template" class="form-select composetext composetext5" onchange="choose_text_template(this.value)" autofocus>
						<option value=''>Select SMS Template</option>
						<?php $tsql = "SELECT * FROM `textsms_templates` where `status`='1' and `msg_type`LIKE 'imp-inform%' ";
						mysqli_set_charset($con, 'utf8');
						$tquery = mysqli_query($con, $tsql);

						if (mysqli_num_rows($tquery) > 0) {
							while ($row = mysqli_fetch_assoc($tquery)) {
								echo "<option value=" . $row['id'] . " data-desc='" . $row['description'] . "' data-dummy_sms='" . $row['dummy_sms'] . "' >" . $row['title'] . "</option>";
							}
						}
						?>
					</select>
				</div>

			</div>
			<br>
			<div class="row" style="margin-top:20px;margin-bottom:50px;">

				<div class="col-md-2">Sample Message : </div>


				<div class="col-md-6">
					<div class="Dummy_sms" id="Dummy_sms">

					</div>




				</div>

			</div>


			<div class="row" style="margin-top:20px;margin-bottom:50px;">

				<div class="col-md-2">Message : </div>


				<div class="col-md-6">
					<div class="text_sms_format" id="text_sms_format">

					</div>
					<span id="error" style="color:red;"></span>
					<!-- not in use -->
					<!-- <textarea id="composetext5" name="composetext5" style="display: none;" class="form-control composetext" style="width:300px;height:200px;"></textarea> -->
					<!-- not in use -->

				</div>

			</div>



		</div>

		<!---- Important Information ---->



		<!---- Study Material ---->

		<div class="col-md-12" id="study" style="display:none">

			<div class="row" style="margin-left:22px;">

				<div class="col-md-2">Class : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="classid5" id="class5" class="form-select class" onchange="totalstu5(this.value);search_sec5(this.value);">

						<option value="" selected="selected" disabled>Select Class</option>

						<?php

						$scls = "select * from class";

						$rcls = mysqli_query($con, $scls);

						while ($rescls = mysqli_fetch_array($rcls)) {

						?>

							<option <?php if ($class == $rescls['class_id']) {
										echo "selected";
									} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

						<?php } ?>

					</select>

				</div>



				<script>
					function search_sec5(str)

					{

						var xmlhttp = new XMLHttpRequest();

						xmlhttp.open("get", "search_ajax_section.php?cls_id=" + str, true);

						xmlhttp.send();

						xmlhttp.onreadystatechange = function()

						{

							if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

							{

								document.getElementById("section5").innerHTML = xmlhttp.responseText;

							}

						}

					}
				</script>



				<div class="col-md-2" style="margin-left:100px;">Section : </div>

				<div class="col-md-2" style="margin-top:-8px;">

					<select style="width:200px;" name="section5" id="section5" class="form-select section" onchange="totalstu5(this.value)">

						<option value="" selected="selected" disabled>--- Select Section ---</option>

					</select>

				</div>

			</div><br>

			<div class="row">

				<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="text" name="heading6" id="heading6" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>

			<div class="row">

				<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Message : </div>

				<div class="col-md-8" style="font-size:14px;margin-top:20px;">

					<input type="text" name="heading1" id="heading1" class="form-control heading" style="margin-left:-10px;width:645px;">

				</div>

			</div>



			<div class="row" style="margin-top:30px;margin-bottom:20px;">

				<div class="col-md-3" style="margin-top:20px;margin-left:40px;">Select Material : </div>

				<div class="col-md-8" style="margin-top:20px;">

					<input type="file" name="file2[]" id="file2" class="file" style="margin-left:-98px;" >

				</div>

			</div><br>



		</div>

		<!---- Study Material ---->



	</div>



	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;" id="stcount">

		<div class="col-md-2" style="font-size:14px;">Characters : </div>

		<div class="col-md-2" style="margin-top:-8px;">

			<input type="text" name="charcount" class="form-control" id="charcount" readonly>

		</div>

		<div class="col-md-2" style="margin-left:50px;">Student Count : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">

			<input type="text" name="stucount" class="form-control" id="stucount" style="margin-left:-55px;" readonly>

		</div>

	</div>



	<!-- <hr style="height:2px solid grey"> -->



	<div class="row" style="margin-top:50px;">

		<div class="col-md-3">

		</div>

		<div class="col-md-2" id="check">

			<input type="checkbox" name="check" id="checkbulk" /><span style="margin-left:5px;">Send Bulk SMS</span>

		</div>

		<div class="col-md-3">

			<input type="submit" name="sms" value="Send Now" id="add" class="btn btn-primary btn-sm" />

			<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm" />

		</div>

	</div>

	<br /><br>

	<hr />



</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-bottom-right",
			"preventDuplicates": false,

			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "6000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
	});
</script>

<script>
	"use strict";
	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext1').keyup(function() {

			var tsms = 1;

			//.val() will give the text from the textbox and .length will give the number of characters

			var txtlen = $(this).val().length;



			if (txtlen >= 160)

			{

				var tsms = tsms + 1;

			}



			//alert('Hi');

			//the below lines will display the results 

			$('#charcount').val(txtlen);



		});

	});
</script>



<script>
	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext2').keyup(function() {

			var tsms = 1;

			//.val() will give the text from the textbox and .length will give the number of characters

			var txtlen = $(this).val().length;



			if (txtlen >= 160)

			{

				var tsms = tsms + 1;

			}



			//alert('Hi');

			//the below lines will display the results 

			$('#charcount').val(txtlen);



		});

	});
</script>



<script>
	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#composetext3').keyup(function() {

			var tsms = 1;

			//.val() will give the text from the textbox and .length will give the number of characters

			var txtlen = $(this).val().length;



			if (txtlen >= 160)

			{

				var tsms = tsms + 1;

			}



			//alert('Hi');

			//the below lines will display the results 

			$('#charcount').val(txtlen);



		});

	});
</script>
<script>
	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#heading').keyup(function() {

			var tsms = 1;

			//.val() will give the text from the textbox and .length will give the number of characters

			var txtlen = $(this).val().length;



			if (txtlen >= 160)

			{

				var tsms = tsms + 1;

			}



			//alert('Hi');

			//the below lines will display the results 

			$('#charcount').val(txtlen);



		});

	});
</script>
<script>
	

	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 
		// $('#composetext5').keyup(function () {
		$(document).on('keyup', '.sms_input_field', function() {
			// $('.sms_input_field').keyup(function () {


			var txtlen = $(this).val().length;



			if (txtlen >= 30) {
				// var tsms=tsms+1;
				$('#error').html("*Maximum thirty characters allowed at one field");
				// alert("Maximum thirty characters allowed");

			} else {
				$('#error').html(" ");

			}


			$('#charcount').val(txtlen);



		});
		$(document).on('click', '.sms_input_field', function() {

			var txtlen = $(this).val().length;

			$('#charcount').val(txtlen);

		});

	});
</script>
<script>
	$(function() {

		//lets use the jQuery Keyboard Event to catch the text typed in the textbox 

		$('#heading1').keyup(function() {

			var tsms = 1;

			//.val() will give the text from the textbox and .length will give the number of characters

			var txtlen = $(this).val().length;



			if (txtlen >= 160)

			{

				var tsms = tsms + 1;

			}



			//alert('Hi');

			//the below lines will display the results 

			$('#charcount').val(txtlen);



		});

	});
</script>
<script>
	function choose_text_template(id) {

		var i;

		var text = $('#text_template').find(':selected').attr('data-desc');
		var dummy = $('#text_template').find(':selected').attr('data-dummy_sms');
		// alert(dummy);
		$('#Dummy_sms').html(dummy);

		document.getElementById("text_sms_format").innerHTML = text.replace(/{#var#}/g, "<input type='text' maxlength='30' name='textsms5[]' id='textsms5'  class='sms_input_field'  size='20' />");

		// const input = document.getElementsByClassName("sms_input_field");
		//        for (i =input.length; i < 0; i--) {
		//      	// input[i].required=false;
		//        	console.log(i);
		//        // $('.sms_input_field')[0].val('44');	
		// 	} 
		Add_input_text();	//call this function

		// alert(text.match("{#var#}"));
		//  let temp = "Welcome to to to W3Docs  to ";
		// let count = (text.match(/{#var#}/g) || []).length;
		// alert(count);

		// for (i = 0; i < count; i++) {
		//       	se[i].required=false;
		// 	console.log(i);

		// }
		// $('#textsms5'[0]).val('hello');
		//     var Toarr = [];
		// $("#textsms5").each(function(){
		// 	alert(12);
		//    // Toarr.push('hello');
		//    // console.log(this);
		// });
		// 		 if(text!=""){
		// 		 		  alert(uid);
		// 		 	let res = str.replace(/text/g, 501);
		//             document.getElementById("text_sms_format").innerHTML = res;
		// 		 	$('.text_sms_format').html(text);
		// 			$('.text_sms_format').html(text.replace(uid, "W3Schools"));
		// 		 }
		

	}

	function Add_input_text(){
		// $(document).on('each', '.sms_input_field', function(){
		// $(".sms_input_field").each(function(){
	 
		// $("select.x:nth-last-of-type(2)").val('5566');

        // $("select.x:nth-last-child(2)").val('4567');
	
		// $('.sms_input_field:nth-child(2)').val('456');
		$('.sms_input_field').last().prev().val('<?=$output[0]?>');
		$(".sms_input_field").last().val('<?=$output[1]?>');
		$(".sms_input_field").last().prev().css("background-color", "yellow");
		$(".sms_input_field").last().css("background-color", "yellow");
		$(".sms_input_field").last().css("width","260px");  
		$(".sms_input_field").last().prev().css("width","260px");  
		var chk='<?=$output[1]?>';
		if(chk ==''){
			$(".sms_input_field").last().css("display","none");  
			
		} 

	}
</script>
<script>
	$('form').on('submit', function(e) {

		e.preventDefault();
		var Toarr = [];
		$("#multiselect_to_1 > option").each(function() {
			Toarr.push(this.value);
			// console.log(this);
		});

		// 	var options = document.getElementById('multiselect_to_1').selectedOptions;
		//    var values = Array.from(options).map(({ value }) => value);
		// console.log(options);
		// console.log(values);


		if (confirm("Are you sure want to send SMS")) {

			$('input[type="submit"]').attr('disabled', true);
			$('input[type="submit"]').val('Please wait...')

			var action = 'CommunicationSMS';
			$(this).append('<input type="hidden" name="' + action + '"/>');
			// var formData =new FormData($('#devel-generate-content-form')[0]);
			var formData = new FormData(this);
			// formData.append("to_student_id", Toarr);

			for (i = 0; i < Toarr.length; i++) {
				formData.append("to_student_id[" + i + "]", Toarr[i]);
			}


			$.ajax({
				type: "POST",
				url: 'Controllers/CommunicationControllers.php',
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				success: function(res) {
					var responce = JSON.parse(res);
					// console.log(response);	
					if (responce.status == 'success') {

						toastr.success(responce.message);
						setInterval(function() {

							// window.location.reload();
							window.location.href = "dashboard.php?option=student_notification";
						}, 6000);
					} else {

						toastr.error(responce.message);
					}
					$('input[type="submit"]').attr('disabled', false);
					$('input[type="submit"]').val('Send Now');
				}
			});
		} else {
			return false;
		}


	});
	// });
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {

		$('.multiselect').multiselect();

	});
		

</script>