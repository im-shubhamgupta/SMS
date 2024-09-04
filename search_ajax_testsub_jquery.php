<?php 
extract($_REQUEST);
include('connection.php');

?>

<option value="" selected>Select Subject</option>
<?php 
$c=mysqli_query($con,"select test.subject_id, subject.subject_name from test INNER JOIN subject ON test.subject_id = subject.subject_id where test.class_id='$clsid' && test.section_id='$secid' && test.test_name='$testname'");
while($s_res=mysqli_fetch_array($c))
{
	
?>
<option value="<?php echo $s_res['subject_id'] ?>"><?php echo $s_res['subject_name']; ?></option>
<?php }
?>
