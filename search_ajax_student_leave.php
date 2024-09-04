<?php 

extract($_REQUEST);

include('connection.php');



$q=mysqli_query($con,"select * from section where section_id='$sec_id'");

$r=mysqli_fetch_array($q);

$clsid=$r['class_id'];



?>



<option value="">All</option>



<?php 

// $c=mysqli_query($con,"select * from students where class_id='$clsid' and section_id='$sec_id'");
$c=mysqli_query($con,"select `student_id`,`student_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where  sr.class_id='$clsid' && sr.section_id='$sec_id' && stu_status='0' && `sr`.`session`='".$_SESSION['session']."'    ");

while($s_res=mysqli_fetch_array($c))

{

?>

<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>

<?php }

?>

