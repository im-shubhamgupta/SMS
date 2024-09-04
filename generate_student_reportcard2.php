<!DOCTYPE html>
<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');
$clsid = $_REQUEST['clsid'];
$secid = $_REQUEST['secid'];
$examid = $_REQUEST['examid'];
$display = $_REQUEST['display'];
$stuid = $_REQUEST['stuid'];

?>
<html lang="en">
<head>
	<title>Report Card</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body>

<?php
$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];

	$stuarr = explode(',',$stuid);
	foreach($stuarr as $val)
	{
	$qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$rstu = mysqli_fetch_array($qstu);
	$regno = $rstu['register_no'];
	$stuname = $rstu['student_name'];
	$nstuname = strtoupper($stuname);
	$fname = $rstu['father_name'];
	
	$clsid = $rstu['class_id'];
	$qc = mysqli_query($con,"select * from class where class_id='$clsid'");
	$rc = mysqli_fetch_array($qc);
	$class = $rc['class_name'];
	
	$secid = $rstu['section_id'];
	$qs = mysqli_query($con,"select * from section where section_id='$secid'");
	$rs = mysqli_fetch_array($qs);
	$section = $rs['section_name'];
	
	$dob = $rstu['dob'];
	$chgdob = date("d-M-Y", strtotime($dob));
	
	$academicyear = $rstu['academic_year'];
	
	//$pic = $rstu['stu_image'];
	
?>

<style>
table,tr, td{
  border: 2px solid black !important;
}
</style>

<section class="report_card py-3" style="background:#cfdce8;">
<div class="container py-3">
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10 py-3" style="background:white;box-shadow: 0 0 5px #000;">
  <div class="row" style="margin-top:40px;">
  <div class="col-md-1"></div>
  <div class="col-md-2">
  <img src="images/profile/<?php echo $scllogo;?>" class="img-fluid logo text-center ml-3" style="width:100px;height:70px">
  </div>
  <div class="col-sm-6">
  <h4 class="text-center"><b><?php echo $sclname;?></b></h4>
  <h5 class="text-center"><small><?php echo $scladd;?></small></h5>
  <h5 class="text-center"> <small>E-Mail : <?php echo $sclemail;?>, Ph.No. : <?php echo $sclmob;?></small></h5>
  </div>
  <div class="col-md-2"></div>
  </div>
  <hr style="border:1px solid #b6bcc2">
 
<div class="card py-0 border-0 bg-transparent">
  <small class="text-center"><span class="font-weight-bold">Academic Session : </span><span><?php echo $academicyear;?></span></small>
  <!--<h5 class="text-center">TERM I REPORT</h5> -->
	<div class="card-body">
	<table class="table table-bordered table-sm">
	  <tbody>
		<tr>
		  <th scope="row">Student's Name:</th>
		  <td><?php echo $stuname; ?></td>
		   <th scope="row">Roll No:</th>
		  <td><?php echo "1"; ?></td>
		</tr>
		<tr>
		  <th scope="row">Father's Name:</th>
		  <td><?php echo $fname; ?></td>
		  <th scope="row">Class and Section:</th>
		  <td><?php echo $class.' '.$section;?></td>
		</tr>
		<tr>
		  <th scope="row">Admission No:</th>
		  <td><?php echo $regno; ?></td>
		  <th scope="row">Total No. of Working Days:</th>
		  <td><?php echo "10"; ?></td>
		</tr>
		<tr>
		  <th scope="row">Date Of Birth:</th>
		  <td><?php echo $chgdob; ?></td>
		  <th scope="row">No. Of Days Present:</th>
		  <td><?php echo "10"; ?></td>
		</tr>
	  </tbody>
	</table>
	</div>
</div>

<div class="card bg-transparent">  
<div class="card-title bg-success" style="font-size:15px;color:white;border-top-left-radius:8px;border-top-right-radius:8px;margin-left:20px;margin-right:20px;padding:2px">
ACADEMIC PERFORMANCE
</div>
<div class="card-body" style="margin-top:-25px;margin-left:5px;">
<div class="row">
<?php
$queg = mysqli_query($con,"select * from grade");
while($resg = mysqli_fetch_array($queg))
{
	
?>

<div class="col-md-1" style="margin-right:-10px">
<p class="text-center border" style="background:<?php echo $resg['colors'];?>;"><?php echo $resg['grade_name'];?></p>
<div class="d-flex justify-content-between" style="margin-top:-20px">
<small class="text-left"><?php echo $resg['condition1'];?></small>
<small class="text-left"><?php echo $resg['condition2'];?></small>
</div>
</div>

<?php
}
?>
</div>
<small>(All Values are in %)</small>

<!--table-->
<table class="table table-bordered table-sm mt-2">
  <thead>
  <tr>
  <th class="text-center" width="70%" style="background:#ededed">Subjects</th>
  
  <?php
  $examarr = explode(',',$examid);
	foreach($examarr as $e)
	{
		$qe = mysqli_query($con,"select * from test where test_id='$e'");
		$re = mysqli_fetch_array($qe);
  ?>
  <th class="text-center" style="background:#ededed"><?php echo $re['test_name'];?><br><small>Score</small></th>
  <?php
	}
  ?>
  </tr>
  </thead>
  
  <tbody> 
	<?php
	  $qsub = mysqli_query($con,"select * from subject where class_id='$clsid'");
	  while($rsub = mysqli_fetch_array($qsub))
	  {
		$subid = $rsub['subject_id'];
		$subject = $rsub['subject_name'];
		
	?>
	<tr>
	<th scope="row"><?php echo $subject; ?></th>
		<?php
			foreach($examarr as $e)
			{
				$qe1 = mysqli_query($con,"select * from test where test_id='$e'");
				$re1 = mysqli_fetch_array($qe1);
				$mname = $re1['test_name'];
			
				$qm = mysqli_query($con,"select * from marks where student_id='$val' && test_name='$mname' && subject_id='$subid'");
				$rm = mysqli_fetch_array($qm);
				$marksid = $rm['mark_id'];
				
				if($display=="marks")
				{
					$marks = $rm['marks'];
					$qg1 = mysqli_query($con,"select * from grade where condition1 <='$marks' && condition2 >='$marks'");
					$rg1 = mysqli_fetch_array($qg1);
					$color = $rg1['colors'];					
				}
				else
				{	
					$m = $rm['marks'];
					$qg2 = mysqli_query($con,"select * from grade where condition1 <='$m' && condition2 >='$m'");
					$rg2 = mysqli_fetch_array($qg2);
					$marks = $rg2['grade_name'];
					$color = $rg2['colors'];
				}
		?>
	<td class="text-center">
	<span style="width:100px;border:1px solid black;background:<?php echo $color;?>;"><?php echo $marks; ?></span>
	</td>
		<?php
			}
		?>
	<tr>
	<?php
	  }
	?>
  </tbody>
</table>
<!--end table-->  
	
</div>
</div>

<div class="row">
<div class="col-md-6">
<h5 class="text-center text-success">CGPA</h5>
<hr color="green" style="margin-top:0px">
<h2 class="text-center">7.72</h2>
</div>
<div class="col-md-6">
<h5 class="text-center text-success">Overall Grade</h5>
<hr color="green" style="margin-top:0px">
<h2 class="text-center">B+</h2>
<p class="text-center">Class Avg. B</p>
</div>
</div>


<!--second table-->
<div class="card bg-transparent">  
<div class="card-title bg-success" style="font-size:15px;color:white;border-top-left-radius:8px;border-top-right-radius:8px;margin-left:20px;margin-right:20px;padding:2px">
CO-SCHOLASTIC PERFORMANCE
</div>
<div class="card-body" style="margin-top:-25px;margin-left:5px;">
<div class="row">
<?php
$qsg = mysqli_query($con,"select * from scholastic_grade");
while($rsg = mysqli_fetch_array($qsg))
{
	
?>

<div class="col-md-1" style="margin-right:-10px">
<p class="text-center border" style="background:<?php echo $rsg['colors'];?>;"><?php echo $rsg['grade_name'];?></p>
<div class="d-flex justify-content-between" style="margin-top:-20px">
<small class="text-left"><?php echo $rsg['condition1'];?></small>
<small class="text-left"><?php echo $rsg['condition2'];?></small>
</div>
</div>

<?php
}
?>
</div>
<small>(All Values are in %)</small>

<!--table-->
<table class="table table-bordered table-sm mt-2" style="border-0">
  <thead>
	<th>Subject</th>
	<th>Grade</th>
  </thead>
  
  <tbody>
<?php
	$qs = mysqli_query($con,"select * from co_scholastic");
	while($rs = mysqli_fetch_array($qs))
	{
?>  
	<tr>
	<th style="font-family:Times;font-size:15px;"><?php echo $rs['scholastic_name'];?></th>
	<th><span style="width:100px;border:1px solid black;background:<?php echo $color;?>;"><?php echo " A ";?></span></th>
	</tr>
<?php
	}
?>
  </tbody>
</table>
<!--end table-->  
	
</div>
</div>
<!--second table-->


<div class="card-body">
<h5>Class Teacher's Remarks:</h5>
<p><?php echo $nstuname ;?> determines various forms of writing and identifies important ideas through the development of insightful
questions and answers.</p>
</div>


<div class="row row-cols-1 row-cols-md-3 pt-5 pb-3">
  <div class="col-md-4 mb-4 ">
	<div class="card h-100 rounded-0 bg-transparent d-flex justify-content-center align-items-center" style="border-bottom:1px solid #000;border-top:0;border-left:0;border-right:0;"></div>
	<p class="text-center">Class Teacher</p>
  </div>
 <div class="col-md-4 mb-4 ">
	<div class="card h-100 rounded-0 bg-transparent d-flex justify-content-center align-items-center" style="border-bottom:1px solid #000;border-top:0;border-left:0;border-right:0;"></div>
  <p class="text-center">Controller of Examinations<br>(Vice - Principal)</p>
  </div>
<div class="col-md-4 mb-4 ">
	<div class="card h-100 rounded-0 bg-transparent d-flex justify-content-center align-items-center" style="border-bottom:1px solid #000;border-top:0;border-left:0;border-right:0;"></div>
  <p class="text-center">Principal</p>
  </div>
</div>


</div> 
</div>
</div>
</section>

<?php
	}
?>
</body>

</html>
