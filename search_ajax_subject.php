<?php 
session_start();
extract($_REQUEST);
include('connection.php');

?>
	<tbody>
	<?php 
	$sr=1;
	$query=mysqli_query($con,"SELECT  *
	FROM subject
	WHERE subject_id NOT IN (SELECT subject_id FROM assign_subject) && class_id='$cls_id'");
	
	while($res=mysqli_fetch_array($query))
	{
		$subid=$res['subject_id'];
		$subname=$res['subject_name'];
	?>
	<tr>
		<td><?php echo $sr; ?></td>
		<td><?php echo $subname; ?></td>
		<td><input type="checkbox" class="form" name="sub[]" value="<?php echo $subid;?>"></td>
	</tr>
	<?php $sr++;  
	}
	?>
	
	<tr>
	<td colspan="3" align="right"><input type="submit" name="assign" value="Assign"></td>
	</tr>
	</tbody>
