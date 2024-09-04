<?php include('connection.php');
extract($_REQUEST);

?>

<option value="" selected disabled>Select Test</option>

<?php 

$c=mysqli_query($con,"select DISTINCT(t.parent_test_id),pt.name from test AS t  RIGHT JOIN parent_exam as pt ON pt.id=t.parent_test_id where t.class_id='$cls_id' && t.section_id='$sec_id' and t.session='".$_SESSION['session']."'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['parent_test_id']; ?>"><?php echo $s_res['name']; ?></option>
<?php }
?>
