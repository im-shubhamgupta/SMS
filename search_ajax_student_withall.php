<?php 

extract($_REQUEST);

include('connection.php');



$q=mysqli_query($con,"select * from section where section_id='$sec_id'");

$r=mysqli_fetch_array($q);

$clsid=$r['class_id'];



?>



<option value="All">All</option>



<?php 

// $c=mysqli_query($con,"select * from students where class_id='$clsid' and section_id='$sec_id'");
$sql1="select `student_id`,`student_name`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$clsid' and sr.section_id='$sec_id' and sr.session='".$_SESSION['session']."' ";//
$c=mysqli_query($con,$sql1);
while($s_res=mysqli_fetch_array($c))

{

?>

<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>

<?php

}

?>

