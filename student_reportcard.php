<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

?> 

<style>


</style>

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Report</a>
  <span class="breadcrumb-item active">Student Report</span>
</nav>


   <div class="tab">
	  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Exam Wise Report</button>
	  <button class="tablinks" onclick="openCity(event, 'Paris')">TERM Wise Report</button>
   </div>


  <div id="London" class="tabcontent">
	<form method="post" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                                 
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-2" style="margin-left:80px;">Class</div>
								<div class="col-md-5" style="margin-left:70px;">
								<select name="class" id="class" class="form-select" onchange="searchexam(this.value);searchstudent(this.value);search_sec(this.value)" style="width:180px" autofocus required>
								<option value="" selected="selected" disabled >Select</option>
								<?php
								$scls =  mysqli_query($con,"select * from class");
								while( $rescls = mysqli_fetch_array($scls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								</div>
								
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:30px">Section</div>
								<div class="col-md-5">
								<select class="form-select" name="section" id="search_sect" onchange="searchexam(this.value), searchstudent(this.value)" autofocus required>
								<option value="" selected disabled>Select</option>
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
								
								<script>
								function searchexam(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_exam.php?sec_id="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("exam").innerHTML=xmlhttp.responseText;
								}
								}
								}
								</script>
								
								<script>
								function searchstudent(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("student").innerHTML=xmlhttp.responseText;
								}
								}
								}
								</script>
								</div>
								</div>
								</div>
							</div>
							
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:80px;">Select Exams</div>
								<div class="col-md-5">
								<select name="exam[]" multiple id="exam" class="form-select" style="width:180px" autofocus>
								<option value="" selected="selected" disabled>Select</option>
								<?php
								$qtest=mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."'");
								while($rtest=mysqli_fetch_array($qtest))
								{	
									// print_r($rtest);
								?>
								<option <?php if($exam==$rtest['test_id']){echo "selected";}?> value="<?php echo $rtest['test_id']; ?>"><?php echo $rtest['test_name'];?>
								</option>
								<?php 
								}
								?>		
								</select>
								</div>
								</div>
								</div>
							
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:30px">Display</div>
								<div class="col-md-5">
								<select class="form-select" name="display" autofocus required>
								<option value="" selected="selected" disabled>Select</option>
								<option value="grade">Grade</option>
								<option value="marks">Marks</option>
								</select>	
								</div>
								</div>
								</div>
							</div>
							
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:80px;">Select Student</div>
								<div class="col-md-5">
								
								<select class="form-control" name="student[]" multiple id="student" style="width:180px" autofocus required>
								<option value="" selected="selected" disabled>Select</option>
								<?php
								// $rsql="select * from students where class_id='$class' && section_id='$section'";
								$rsql ="select `student_id`,`student_name` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."'";
								$qstu=mysqli_query($con,$rsql);
								while($rstu=mysqli_fetch_array($qstu))
								{
								?>
								<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>
								</option>
								<?php 
								}
								?>							
								</select>	
							
								</div>
								</div>
								</div>
							</div><br>
							<br>
							
							<div class="row">
								<div class="col-md-2" style="margin-left:280px">
								<input type="submit" name="save" class="btn btn-primary btn-sm" value="Generate"><br><br>
								</div>
								<div class="col-md-2">
								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br><br>
								</div>
							</div>
							
                    </div>
                    </div>
                </div>
            </div><!-- .animated -->
       
	   </form>

	</div>
	
	
  <div id="Paris" class="tabcontent">
	 
	 <form method="post" enctype="multipart/form-data">
        <div class="content mt-3" style="width:1000px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                                 
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-2" style="margin-left:80px;">Class</div>
								<div class="col-md-5" style="margin-left:70px;">
								<select name="class" class="form-control" onchange="searchstudent_term(this.value);search_sec_term(this.value)" style="width:180px" autofocus required>
								<option value="" selected="selected" disabled >Select</option>
								<?php
								$scls =  mysqli_query($con,"select * from class");
								while( $rescls = mysqli_fetch_array($scls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								</div>
								
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:30px">Section</div>
								<div class="col-md-5">
								<select class="form-control" name="section" id="search_sect_term" onchange="searchstudent_term(this.value)" autofocus required>
								<option value="" selected disabled>Select</option>
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
								<script>
								function search_sec_term(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("search_sect_term").innerHTML=xmlhttp.responseText;
								}
								} 
								}
								</script>
								
								
								<script>
								function searchstudent_term(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("student_term").innerHTML=xmlhttp.responseText;
								}
								}
								}
								</script>
								</div>
								</div>
								</div>
							</div>
							
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:80px;">Select Exams</div>
								<div class="col-md-5">
								<select name="exam[]"  id="term_exam" class="form-control" style="width:180px" autofocus>
								
								<?php
								$qtest=mysqli_query($con,"select id, name from parent_exam");
								while($rtest=mysqli_fetch_array($qtest))
								{	
								?>
								<option value="<?php echo $rtest['id']; ?>"><?php echo $rtest['name'];?>
								</option>
								<?php 
								}
								?>		
								</select>
								</div>
								</div>
								</div>
							
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:30px">Display</div>
								<div class="col-md-5">
								<select class="form-control" name="display" autofocus required>
								<option value="" selected="selected" disabled>Select</option>
								<option value="grade">Grade</option>
								<option value="marks">Marks</option>
								<option value="marks">Both </option>
								</select>	
								</div>
								</div>
								</div>
							</div>
							
							<div class="row" style="margin-top:20px;">
								<div class="col-md-5">
								<div class="row">
								<div class="col-md-4" style="margin-left:80px;">Select Student</div>
								<div class="col-md-5">
								
								<select class="form-control" name="student[]" multiple id="student_term" style="width:180px" autofocus required>
								<option value="" selected="selected" disabled>Select</option>
								<?php
								// "select * from students where class_id='$class' && section_id='$section'"
								$rsql2 ="select `student_id`,`student_name` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."'";
								$qstu=mysqli_query($con,$rsql2);
								while($rstu=mysqli_fetch_array($qstu))
								{
								?>
								<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>
								</option>
								<?php 
								}
								?>							
								</select>	
							
								</div>
								</div>
								</div>
							</div><br>
							<br>
							
							<div class="row">
								<div class="col-md-2" style="margin-left:280px">
								<input type="submit" name="save_term" class="btn btn-primary btn-sm" value="Generate"><br><br>
								</div>
								<div class="col-md-2">
								<input type="reset" class="btn btn-info btn-sm" value="Cancel"><br><br><br>
								</div>
							</div>
							
                    </div>
                    </div>
                </div>
            </div><!-- .animated -->
       
	   </form>
	 
	 
   </div>

	
		<?php
		if(isset($save))
		{
			// print_r($_REQUEST);
			$examid = implode(',',$exam);
			$stuid = implode(',',$student);
			
			// echo "<script>window.location='generate_student_reportcard.php?clsid=$class&secid=$section&examid=$examid&display=$display&stuid=$stuid'</script>";
			?><script>
				document.getElementById('class').value='';  //set due to some issue
			var urll='generate_student_reportcard_pdf.php?clsid=<?=$class?>&secid=<?=$section?>&examid=<?=$examid?>&display=<?=$display?>&stuid=<?=$stuid?>';

			var w=window.open(urll, "_blank");
			if(!w) { 
			   alert('oops..seems like a pop-up blocker is enabled. Please disable it');
			}

		</script>

			<?php
			// echo '<script>window.open("https://abhigya.in/beta/sms/generate_student_reportcard.php?clsid=$class&secid=$section&examid=$examid&display=$display&stuid=$stuid", "_blank")</script>';
						
		}
		
		if(isset($save_term))
		{
			$examid = implode(',',$exam);
			$stuid = implode(',',$student);
				?>
			<script>
				document.getElementById('class').value='';  //set due to some issue
			var Turl='generate_term_wise_student_reportcard_pdf.php?clsid=<?=$class?>&secid=<?=$section?>&examid=<?=$examid?>&display=<?=$display?>&stuid=<?=$stuid?>';

			var w=window.open(Turl, "_blank");
			if(!w) { 
			   alert('oops..seems like a pop-up blocker is enabled. Please disable it');
			}
		</script>
		<?php	
				// echo '<script>window.open(Turl, "_blank");</script>';
			// echo "<script>window.location='generate_term_wise_student_reportcard.php?clsid=$class&secid=$section&examid=$examid&display=$display&stuid=$stuid'</script>";
						
		}
		
		?>
		
<script>

document.getElementById("defaultOpen").click();

function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>