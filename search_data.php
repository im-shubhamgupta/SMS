<?php
include('connection.php');
if(isset($_REQUEST['promote_class'])){

echo '<option value="" selected="selected" disabled>Select Promote Class</option>';

$q=mysqli_query($con,"select * from class where `class_id` >='".$_REQUEST['class_id']."'");

while($r=mysqli_fetch_array($q)){

	$class_id = $r['class_id'];
	$class_name = $r['class_name'];

?>

<option value="<?php echo $class_id; ?>"><?php echo $class_name; ?></option>

<?php } 
}

if(isset($_REQUEST['assign_subject_thr'])){
$cls_id=$_REQUEST['cls_id'];	
$sec_id=$_REQUEST['sec_id'];	
$sqll="select * from assign_subject where class_id='$cls_id' && section_id='$sec_id' ";
$qsub=mysqli_query($con,$sqll);
if(mysqli_num_rows($qsub)){
	while($rsub=mysqli_fetch_array($qsub)){

		$stid = $rsub['st_id'];

		$qst = mysqli_query($con,"select * from staff where st_id='$stid'");

		$rst = mysqli_fetch_array($qst);
	?>
	<option value="<?php echo $rst['st_id'];?>"><?php echo $rst['staff_name'];?>
	</option>
	<?php 

	}
}else{
	echo "<option value='' disabled>Not Found</option>";
}

}

if(isset($_REQUEST['search_homework_subject'])){
$cls_id=$_REQUEST['cls_id'];
	?>

	<select class="form-control" style="width:175px;">

	<option value='0'>All</option>

	<?php 

	$c=mysqli_query($con,"select * from subject where class_id='$cls_id'");
	if(mysqli_num_rows($c)>0){

	while($s_res=mysqli_fetch_array($c))

	{

	?>

	<option value="<?php echo $s_res['subject_id']; ?>"><?php echo $s_res['subject_name']; ?></option>

	<?php } 
    }

	 ?>

	</select>

<?php

}

if(isset($_REQUEST['check_class_teacher_assign'])){

	$st_id=$_REQUEST['tchr_id'];
 $sql="select * from assign_clsteacher where st_id='".$st_id."' and session='".$_SESSION['session']."'";

$q1 = mysqli_query($con,$sql);

if(mysqli_num_rows($q1)>0){

	$responce='1';					 
}else{
	$responce='0';		
}
echo trim($responce); die;

}
if(isset($_REQUEST['search_assign_route_students'])){
	$sec_id=$_REQUEST['sec_id'];
	$q=mysqli_query($con,"select * from section where section_id='$sec_id'");
	$r=mysqli_fetch_array($q);
	$clsid=$r['class_id'];

	echo '<option value="" selected disabled>Select Student</option>';

	$sql = "SELECT `student_id`, `register_no`, `student_name` FROM `students` as `s`  join `student_records` as `sr` on `s`.`student_id`=`sr`.`stu_id`  where `stu_status`='0'  AND `sr`.`session`= '".$_SESSION['session']."' and sr.class_id='$clsid' and sr.section_id='$sec_id' AND `bus_facility`='Yes'  ";
	$c=mysqli_query($con,$sql);
	if(mysqli_num_rows($c)>0){
		while($s_res=mysqli_fetch_array($c)){
			
			$q1 = mysqli_query($con,"select `sturoute_id`,`status` from student_route where student_id='".$s_res['student_id']."' and `session`='".$_SESSION['session']."' ");
			if(!mysqli_num_rows($q1)>0){?>

				<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>

		    <?php
			}
		}
	}
}




?>