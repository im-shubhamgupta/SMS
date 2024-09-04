<?php include('myfunction.php'); ?>
<!DOCTYPE html>
<?php
error_reporting(1);
extract($_REQUEST);
// include('connection.php');


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

<style>

.watermark-image {
  content: "";
 background:url("images/profile/WhatsApp Image 2022-07-25 at 5.26.43 PM.jpeg");
  opacity: 0.1;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  position: absolute;
  z-index: 0;   
  background-repeat: no-repeat;
  background-repeat: no-repeat;
  background-position: 50% 50%; 
}


</style>
<body>

<?php
$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$registration_number = $rset['registration_number'];
$affiliation_number = $rset['affiliation_number'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];
$wesite=$rset['website'];

	$stuarr = explode(',',$stuid);
	
	$scount=0;
	foreach($stuarr as $val)
	{

		$type='report';
		$key='RC';

		$sql1="select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
		$q2 = mysqli_query($con,$sql1);
		$r2 = mysqli_fetch_assoc($q2);
		$row2 = mysqli_num_rows($q2);	
		if($row2 > 0){
			$Count2 = substr($r2['certificate_no'], 2);  //return character after 4 words
	        if(is_numeric($Count2)){
	        	$count=ltrim($Count2,'0');  
	        }
			$recptno = $key.str_pad(intval($count)+1, 6 , "0", STR_PAD_LEFT);
			$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$val', '".$_SESSION['session']."',now())");
			if(!$no){
						die("Error_desc: ".mysqli_error($con));
			}
		}
		else
		{
			$recptno = $key."000001";
			$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$val','".$_SESSION['session']."',now())";
			$no=mysqli_query($con,$sql);	
			if(!$no){
						die("Error_desc: ".mysqli_error($con));
			}
		}
	// $qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$qstu = mysqli_query($con,"select `register_no`,`student_name`,`father_name`,`mother_name`,`stu_image`,`dob`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`session` from students as s join student_records as sr ON s.student_id=sr.stu_id where student_id='$val' and sr.session='".$_SESSION['session']."'");
	$rstu = mysqli_fetch_array($qstu);
	$regno = $rstu['register_no'];
	$stuname = $rstu['student_name'];
	$nstuname = strtoupper($stuname);
	$fname = $rstu['father_name'];
	$mother_name = $rstu['mother_name'];
    $student_image=$rstu['stu_image'];
	
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
	
	// $academicyear = $rstu['academic_year'];
	$academicyear = getSessionByid($rstu['session'])['year'];
	//$pic = $rstu['stu_image']; -->
	
?>

<style>
table,tr, td{
  border: 1px solid #000;
  margin-bottom: 0rem;
}

.co_scholastic tr td{
  border: 0px solid #c1c1c1!important;
}

.co_scholastic table {
    width: 100%;
    margin-bottom: 0rem;
border:1px solid #c1c1c1!important;}

.co_scholastic .table thead th {
    vertical-align: bottom;
    border: 0px solid #000!important;
}

.co_scholastic .table td, .table th {

border-top: 0px solid #000!important;}

.table thead th {
    vertical-align: bottom;
    border: 1px solid #000;
}

.table td, .table th {

border-top: 1px solid #000;
}

@media print {
  /* style sheet for print goes here */
  .noprint {
    visibility: hidden;
  }
}


</style>

<section class="report_card py-3" style="background:#cfdce8;">
<div class="container py-3">
<?php if($scount==0){?>
 <div class="row">
	 <div class="col-md-6" style="margin-bottom:10px;">
	 </div>
 
	 <div class="col-md-6 text-right">
	  <button class="noprint btn btn-primary btn-sm" style="margin-top: -25px;" onClick="window.print()">Save and Print</button>`
	 </div>
 </div>
 <?php } ?>

<div class="row">
<div class="col-md-1">

</div>
<div class="col-md-12 py-3" style="background:white;box-shadow: 0 0 5px #000; ">
 <div class="watermark-image"></div>

<div class="row">
<div class="col-md-6 text-left">
<?php if(isset($registration_number)){ ?><span class="text-center"><small>Registration Number : <?php echo $registration_number;?></small></span> <?php } ?>
</div>
<div class="col-md-6 text-right">
  <?php if(isset($affiliation_number)){ ?><span class="text-right"><small>Affiliation No. / UDISE Code: <?php echo $affiliation_number;?></small></span> <?php } ?>
 </div>
</div>
  <div class="row" style="margin-top:40px;">
  <div class="col-md-1"></div>
  <div class="col-md-2">
  <img src="images/profile/<?php echo $scllogo;?>" class="img-fluid logo text-center ml-3" style="width:100px;height:70px">
  </div>
  <div class="col-sm-6">
  <h4 class="text-center"><b><?php echo $sclname;?></b></h4>
  <h5 class="text-center"><small><?php echo $scladd;?></small></h5>
  
  <h5 class="text-center"> <small>Website : <?php echo $wesite;?></small></h5>
  </div>
  <div class="col-md-2"></div>
  </div>
  <hr style="border:1px solid #b6bcc2">
 
<div class="card py-0 border-0 bg-transparent">
 <div class="row">
  <div class="col-md-6  offset-3 text-center">
     <h6>Academic Session : <b><?php echo $academicyear;?></b></h6>
  </div>
  
  </div>
  
  <!--<h5 class="text-center">TERM I REPORT</h5> -->
	<div class="card-body">

	<table class="table table-sm">
	  <tbody>
		<tr>
		  <th scope="row">Student's Name:</th>
		  <td><?php echo $stuname; ?></td>
		   <th scope="row">Date Of Birth:</th>
		   <td><?php echo $chgdob; ?></td>
		  <!-- <td rowspan="3"><img src="images/student/<?php echo $regno; ?>/<?php echo $student_image; ?>" width='90px' height='90px' style="border-radius:50%"/></td> -->

		  <td rowspan="3"><img src="<?='images/student/'.str_replace('/','-',$regno).'/'.$student_image;?>" width='90px' height='90px' style="border-radius:50%"/></td>

		  
		</tr>
		
		<tr>
		  <th scope="row">Mothrs's Name:</th>
		  <td><?php echo $mother_name; ?></td>
		  <th scope="row">Class and Section:</th>
		  <td><?php echo $class.' '.$section;?></td>
		</tr>
		<tr>
		  <th scope="row">Father's Name:</th>
		  <td><?php echo $fname; ?></td>
		  <th scope="row">Admission No:</th>
		 <td><?php echo $regno; ?></td>
		</tr>
	
		
	  </tbody>
	</table>
	</div>
</div>

<div class="container">  
<div class="card bg-transparent border-0">
<div class="card-title bg-success py-1" style="font-size:15px;color:white;border:1px solid black;border-top-left-radius:8px;border-top-right-radius:8px;">
<h6 class="ml-3">ACADEMIC PERFORMANCE</h6>
</div>
<div class="card-body" style="margin-top:-25px; border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000; border-bottom-left-radius:8px;border-bottom-right-radius:8px;">

<div class="row">
<?php
	$queg1 = mysqli_query($con,"select * from grade order by grade_id desc limit 1");
	$resg1 = mysqli_fetch_array($queg1);

$queg = mysqli_query($con,"select * from grade");
while($resg = mysqli_fetch_array($queg))
{
	
?>

<!--<div class="col-md-1" style="margin-right:-10px">
<p class="text-center border" style="background:<?php echo $resg['colors'];?>;"><?php echo $resg['grade_name'];?></p>
<div class="d-flex justify-content-between" style="margin-top:-20px">
<small class="text-left"><?php echo $resg['condition1'];?></small>
<small class="text-left"><?php echo $resg['condition2'];?></small>
</div>
</div>-->

<?php
}
?>
</div>
<!--<small>(All Values are in %)</small>-->

<!--table-->
<table class="table table-sm mt-2">
  <thead>
  <tr>
  <th class="text-center" width="70%" style="background:#ededed">Subjects</th>
  
  <?php
  $examarr = explode(',',$examid);

	foreach($examarr as $e)
	{
		$qe = mysqli_query($con,"select * from test where test_id='$e'  and session='".$_SESSION['session']."' ");
		$re = mysqli_fetch_array($qe);
		$max_marks = $re['max_marks'];
		$test_name = $re['test_name'];
		
  ?>
  <th class="text-center" style="background:#ededed"><h6>Score</h6>Max Marks: <?=$max_marks;?></th>     
  <th class="text-center" style="background:#ff4d4d"><h6>Grade</h6></th>
  <?php
	}
  ?>
  </tr>
  </thead>
  
  <tbody> 
	<?php
	
	 $sql="select st.subject_id, st.subject_name from subject as st  JOIN test as t ON t.subject_id=st.subject_id where st.class_id='$clsid' AND  t.section_id='$secid' AND t.test_name='$test_name'
	 and t.session='".$_SESSION['session']."' " ;   
	  $qsub = mysqli_query($con,$sql);
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
				
				$tsql="select * from test where test_id='$e'  and session='".$_SESSION['session']."'  ";
				$qe1 = mysqli_query($con,$tsql);
				$re1 = mysqli_fetch_array($qe1);
				// echo "<pre>";
				// print_r($re1); echo "</pre>";
				$mname = $re1['test_name'];				
				$max_marks = $re1['max_marks'];
                			
			
				$qm = mysqli_query($con,"select * from marks where student_id='$val' && test_name='$mname' && subject_id='$subid' and session='".$_SESSION['session']."' ");
				$rm = mysqli_fetch_array($qm);
				$marksid = $rm['mark_id'];

					$marks = $rm['marks'];
					
					$MarksPerctle=round($marks*100/$max_marks);	
                    $total_Marks[]=$rm['marks'];
					$total_percent[]=$MarksPerctle;
					$qg1 = mysqli_query($con,"select * from grade where condition1 <='$MarksPerctle' && condition2 >='$MarksPerctle'");
					$rg1 = mysqli_fetch_array($qg1);
					$color = $rg1['colors'];
                    $Grade = $rg1['grade_name'];					
				
		?>
	   <td class="text-center"><span style="background:<?php echo $color ;?>;" class="px-3 py-1"><?php echo $marks; ?></span></td>	   
	   <td class="text-center"><span style="background:<?php echo $color;?>;" class="px-3 py-1"><?php echo $Grade; ?></span></td>
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

<div class="row">
<div class="col-md-6">
<!-- <h6  style="color:#3214b3;"><?php echo'Attendance';?></h6> -->
</div>
<div class="col-md-6">
<!-- <h6 class="text-center" style="color:#3214b3;"><?='10/8';?></h6> -->

<!--<p class="text-center" style="margin-top:-15px;">Class Avg. B</p>-->
</div>
</div>

	
</div>

<?php
  $No_Of_Subject= count($total_Marks);
  $Total_Marks= array_sum($total_Marks);

  $Total_Percentile=round($Total_Marks*100/($max_marks*$No_Of_Subject),2);
  $TPERC= mysqli_query($con,"select * from grade where condition1 <='$Total_Percentile' && condition2 >='$Total_Percentile'");
  $TPERCQ = mysqli_fetch_array($TPERC);
  $Tcolor = $TPERCQ['colors'];
  $TGrade = $TPERCQ['grade_name'];	
  
  
  ?>

<div class="row">
<!--<div class="col-md-6">
<h5 class="text-center text-success">CGPA</h5>
<hr color="green" style="margin-top:0px">
<h1 class="text-center" style="margin-top:-15px;"><?=$Total_Percentile;?></h1>
</div>-->
<div class="col-md-6 offset-3">
<!--<h5 class="text-center text-success">Overall Grade</h5>
<hr color="green" style="margin-top:0px">
<h2 class="text-center" style="margin-top:-15px;"><?=$TGrade;?></h2>
<p class="text-center" style="margin-top:-15px;">Class Avg. B</p>-->
</div>
</div>
</div>
</div>
  


<!--second table-->
<div class="container" style="margin-top: 11px;">

<h6 class="mt-2">Class Teacher's Remarks:</h6>
  <hr><br><hr><br>
</div>

<div class="row row-cols-1 row-cols-md-3 pb-4">
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
<div class="row">
	<div class="col-12" style="text-align:right;font-size:10px;">
			<span>SL No. : <?=$recptno?></span>
	</div>
</div>


  
</div>
 
</div>
<div class="col-md-1"></div>
 </div>
</section>

<?php
	$scount++;
}
?>
</body>

</html>
