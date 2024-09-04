<?php

// error_reporting(1);




?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->

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

        // google.load("elements", "1", {

        //   packages: "transliteration"

        // });



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

		  else if(categ==3)

		  {

			var ids = ["composetext2"];

            control.makeTransliteratable(ids);

		  }

		  



          // Show the transliteration control which can be used to toggle between English and Hindi and also choose other destination language.

          control.showControl('translControl');

        }



        google.setOnLoadCallback(onLoad);

      </script>



<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Communication Panel</a>

  <a class="breadcrumb-item" href="#"> Custom Communication</a>

  <span class="breadcrumb-item active"> Send Custom Note</span>

</nav>

<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 

<div class="row" style="margin-top:50px;margin-left:20px;">

	<div class="col-md-2">Category : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

	<select style="width:165px;" name="category" id="category" onchange="test456()" 

	class="form-control" required>

	<option value="" selected="selected" disabled>Select Category</option>

	<option value="1">Announcements</option>						

	<option value="3">Messages</option>	

	</select>

	</div>

	

	<div class="col-md-2" style="margin-left:40px;">Select Group : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

	<select style="width:150px;" name="group" id="group" onchange="totalstu(this.value)" 

	class="form-control" required>

	<option value="" selected="selected" disabled>Select Group</option>

	<?php

	$qgrp = mysqli_query($con,"select * from custome_group");

	while( $rgrp = mysqli_fetch_array($qgrp) ) {

	?>

	<option <?php if($group==$rgrp['group_id']){echo "selected";}?> value="<?php echo $rgrp['group_id']; ?>"><?php echo $rgrp['group_name']; ?>

	</option>

	<?php } ?>							

	</select>

	</div>

	

	<div class="col-md-2" style="margin-left:30px;">Select Languaue : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px">

	<select style="width:150px;" class="form-control" onchange="language(this.value)" required>

	<option value="en">English</option>						

<!-- 	<option value="kn">Kannada</option>						

	<option value="te">Telugu</option>						
 -->
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

			document.getElementById("gallery").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:block";
			// document.getElementById("submit_btn_row").style="display:block";



		}

		else if(p=="3")

		{

			document.getElementById("message").style="display:block";

			document.getElementById("composetext2").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:block";
			// document.getElementById("submit_btn_row").style="display:block";

		}

		/*else if(p=="4")

		{

			document.getElementById("gallery").style="display:block";

			document.getElementById("heading2").required=true;

			document.getElementById("file2").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("study").style="display:none";

			document.getElementById("check").style="display:none";

			

		}

		else if(p=="6")

		{

			document.getElementById("study").style="display:block";

			document.getElementById("heading1").required=true;

			document.getElementById("file1").required=true;

			document.getElementById("announ").style="display:none";

			document.getElementById("gallery").style="display:none";

			document.getElementById("message").style="display:none";

			document.getElementById("check").style="display:none";

		}*/

		

	}

	

		function totalstu(str)

			{

			

				var xmlhttp= new XMLHttpRequest();

				xmlhttp.open("get","count_ajax_group_student.php?grpid="+str,true);

				xmlhttp.send();

				xmlhttp.onreadystatechange=function()

				{

				if(xmlhttp.status==200  && xmlhttp.readyState==4)

				{

				document.getElementById("stucount").value=xmlhttp.responseText;

				

				}

				} 

				

			}

			



	</script>





<div class="row">

<!---- Announcements ---->

	<div class="col-md-12" id="announ" style="display:none">

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="margin-top:20px;">Message : </div>

		<div class="col-md-2" style="margin-left:-40px;">

		<textarea id="composetext1" name="composetext1" class="form-control" style="width:300px;height:200px;"></textarea>

		</div>

	</div>

	</div>

<!---- Announcements ---->





<!---- Message ---->

	<div class="col-md-12" id="message" style="display:none">

	<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;">

		<div class="col-md-2" style="margin-top:20px;">Message : </div>

		<div class="col-md-2" style="margin-left:-40px;">

		<textarea id="composetext2" name="composetext2" class="form-control" style="width:300px;height:200px;"></textarea>

		</div>	

	</div>

	</div>

<!---- Message ---->



<!---- photo gallery ---->
<!-- 
	<div class="col-md-12" id="gallery" style="display:none">

	<div class="row">

	<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Heading : </div>

	<div class="col-md-8" style="margin-top:20px;">

	<input type="text" name="heading2" id="heading2" class="form-control" style="margin-left:-10px;width:645px;">

	</div>

	</div>

	

	<div class="row" style="margin-top:30px;margin-bottom:20px;">

	<div class="col-md-2" style="font-size:14px;margin-top:20px;margin-left:40px;">Path : </div>

	<div class="col-md-8" style="margin-top:20px;">

	<input type="file" name="file2[]" id="file2" accept="image/*" style="margin-left:-10px;" multiple>

	</div>

	</div><br>

	

	</div> -->

<!---- photo gallery ---->



<!---- Study Material ---->

<!-- 	<div class="col-md-12" id="study" style="display:none">

	<div class="row">

	<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Message : </div>

	<div class="col-md-8" style="margin-top:20px;margin-left:25px;">

	<input type="text" name="heading1" id="heading1" class="form-control" style="margin-left:-75px;">

	</div>

	</div>

	

	<div class="row" style="margin-top:30px;margin-bottom:20px;">

	<div class="col-md-2" style="margin-top:20px;margin-left:40px;">Select Material : </div>

	<div class="col-md-8" style="margin-top:20px;margin-left:-25px;">

	<input type="file" name="file1[]" id="file1" multiple>

	</div>

	</div><br>

	</div>
 -->
<!---- Study Material ---->



</div>



<div class="row" style="margin-top:20px;margin-left:20px;margin-bottom:50px;" id="stcount">	

	<div class="col-md-2">Characters : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

		<input type="text" name="charcount" class="form-control" id="charcount" style="width:150px;" readonly>		

	</div>

	<div class="col-md-2" style="margin-left:40px;">Student Count: </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px">

		<input type="text" name="stucount" class="form-control" id="stucount" style="width:150px;" readonly>		

	</div>

</div>



<hr style="height:2px solid grey">



<div id="submit_btn_row" class="row" style="margin-top:50px; " >

<div class="col-md-3">

</div>

<div class="col-md-2"  id="check">

<input type="checkbox" name="check" value='on' checked /><span style="margin-left:5px;">Send SMS</span>

</div>

<div class="col-md-2">

<!-- <input type="submit" name="sms" onclick="return confirm('Do you want to Send the Message')" value="Send" id="add" class="btn btn-primary btn-sm"/> -->
<button type="submit" name="sms" value="Send" id="add" class="btn btn-primary btn-sm"/>Send</button>


</div>

<div class="col-md-1">

<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm"/>

</div>

</div>



<div>



</div>

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
<?php include('datatable_links.php')?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// alert(11);
if(confirm('Do you want to Send the Message')){	
  var action = "send_custome_notification";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/CommunicationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=send_custome_notification';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('Send');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
}
});

});

</script>