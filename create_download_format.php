<?php

error_reporting(1);

extract($_REQUEST);



if(isset($load))

{ 

	$query="select * from test where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$subject' && session='".$_SESSION['session']."'";

	$search_result = filterTable($query);



}



	function filterTable($query)

	{

		include('connection.php');

		$filter_Result = mysqli_query($con, $query);

		return $filter_Result;

	}	

	

	

if(isset($save))

{

	

	$class = $_REQUEST['class'];

	$section = $_REQUEST['section'];

	$subject = $_REQUEST['subject'];

	$test = $_REQUEST['test'];

	$maxmark = $_REQUEST['max1'];

	$stuid = $_REQUEST['studid'];

	$marks = $_REQUEST['marks'];

	

	$totalstu = sizeof($stuid);

	for($i=0;$i<$totalstu;$i++)

	{

	

	$newstuid = $stuid[$i];

	$newmarks = $marks[$i];

	

	$q = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && student_id='$newstuid' && test_name='$test' && subject_id='$subject' and session='".$_SESSION['session']."'");

	$r = mysqli_num_rows($q);

	if($r)

	{

		$re = mysqli_fetch_array($q);

		$markid = $re['mark_id'];

		$querysave = mysqli_query($con,"update marks set marks='$newmarks' where mark_id='$markid' and session='".$_SESSION['session']."'");

	}

	else

	{

		$querysave = mysqli_query($con,"insert into marks (class_id,section_id,subject_id,test_name,student_id,marks,max_mark,date) values 

	    ('$class','$section','$subject','$test','$newstuid','$newmarks','$maxmark',now())");

	}

	

	  

		

	}

	

}



?>



	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	

<script type="text/javascript">

	$("#table").dataTable({

		

		paging : false

	});

	

</script>



<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Exam & Result Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Create & Download Format</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=create_download_format" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" style="width:180px;" autofocus required>

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

							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);

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

							

							<div class="col-md-2" style="margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

							<?php

							$qsec=mysqli_query($con,"select * from section where class_id='$class'");

							while($rsec=mysqli_fetch_array($qsec))

							{

							$secname=$rsec['section_name'];

							?>

							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							</option>

							<?php 

							}

							?>							

							</select>	

							</div>

							<script>

							function searchtest(str)

							{

							var clsid = $('#class').val();

							//alert(clsid);

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_test").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>	

						</div><br><br>

                     

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Test Name </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">

							<select class="form-control" name="test" id="search_test" onchange="searchsub(this.value)"

							style="width:195px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							<?php

							$quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section'");

							while( $rtest= mysqli_fetch_array($quet) ) {

							?>

							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>							

							<script>

							function searchsub(str)

							{

							var clsid = $('#class').val();

							var secid = $('#search_sect').val();

							//alert(secid);

							var xmlhttp = new XMLHttpRequest();

							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200 && xmlhttp.readyState==4)

							{

							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	

							}									

							}

							}

							</script>



							

							<div class="col-md-2" style="margin-left:50px;">Subject </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">

							<select class="form-control" name="subject" id="search_sub" style="width:195px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Subject</option>

							<?php

							$qsub = mysqli_query($con,"select test.subject_id, subject.subject_name from test INNER JOIN subject ON test.subject_id = subject.subject_id where test.class_id='$class' && test.section_id='$section' && test.test_name='$test'");

							while( $rsub= mysqli_fetch_array($qsub) ) {

							?>

							<option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>

														

							

							<div class="col-md-2">

							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-90px;width:120px;margin-left:60px;" value="Load"><br><br>

							</div>

						</div><br>

						



						<?php 

						if(isset($load))

						{

						?>

						<div class="row">

						<div class="col-md-12" align="center">

						<a href="export_create_download_format.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>&subject=<?php echo $subject;?>" class="btn btn-success">Download To Excel</a>

						</div>

						</div>

						<?php

						}

						?>

						

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

											

                            		

		

		

	</form>	

    </div><!-- /#right-panel -->





	

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 <script>

$(document).ready(function(){

	$('.marks').blur(function(){

		

	var m = parseInt($("#max1").val());

	

	if($(this).val() > m)

	{

		//console.log("Hi");

		alert("Marks is greater than Max marks.");

		$(this).val("");

		$(this).focus();

		return false;

	}

	});

});

</script>	