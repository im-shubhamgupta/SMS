<?php 

extract($_REQUEST);

include('connection.php');



$q=mysqli_query($con,"select * from section where section_id='$sec_id'");

$r=mysqli_fetch_array($q);

$clsid=$r['class_id'];



?>



<option value="" selected disabled>Select Student</option>



<?php 

// $c=mysqli_query($con,"select * from students where class_id='$clsid' and section_id='$sec_id' and session='".$_SESSION['session']."'");
$sql = "SELECT `student_id`, `register_no`, `student_name` FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id` where `stu_status`='0'  AND `sr`.`session`= '".$_SESSION['session']."' and sr.class_id='$clsid' and sr.section_id='$sec_id' ";
$c=mysqli_query($con,$sql);
if(mysqli_num_rows($c)>0){
while($s_res=mysqli_fetch_array($c))

{

?>

<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>

<?php }
}
?>

