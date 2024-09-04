<?php 

session_start();

extract($_REQUEST);

include('connection.php');

if(is_numeric($sec_id)){

 $sql1="select * from section where section_id='$sec_id'";
$q = mysqli_query($con,$sql1);

$r = mysqli_fetch_array($q);

$clsid = $r['class_id'];



?>



<select class="form-control" style="width:175px;">

<?php 
if(empty($sec_id)){
    $sql2="select `student_id`,`student_name`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where 1  and sr.session='".$_SESSION['session']."' "; 
}else{
    $sql2="select `student_id`,`student_name`,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  sr.class_id='$clsid' && sr.section_id='$sec_id'  and sr.session='".$_SESSION['session']."' "; 
}

  
$c=mysqli_query($con,$sql2);

while($s_res=mysqli_fetch_array($c))

{

?>

<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>

<?php 

}

}

?>

</select>