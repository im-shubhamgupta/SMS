<?php
extract($_REQUEST);
include('connection.php');

$query = mysqli_query($con,"select * from assign_custome_group where group_id='$grpid'");	

$row = mysqli_num_rows($query);
if($row)
{
?>

<div class="card" style="width:950px">
	<div class="card-body">
		<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Sr. No</th>
					<th>Register Number</th>
					<th>Name</th>
					<th>Class</th>
					<th>Section</th>
					<th>Action</th>
					
				</tr>
			</thead>
			<tbody id="PTResults">
			<?php 
			$sr=1;
			while($res=mysqli_fetch_array($query))
			{
			$id=$res['ass_cus_id'];
			$stuid=$res['student_id'];
			$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
			$r1 = mysqli_fetch_array($q1);
			$stuname = $r1['student_name'];
			
			$clsid=$res['class_id'];
			$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");
			$r2 = mysqli_fetch_array($q2);
			$clsname = $r2['class_name'];
			
			$secid=$res['section_id'];
			$q3 = mysqli_query($con,"select * from section where section_id='$secid'");
			$r3 = mysqli_fetch_array($q3);
			$secname = $r3['section_name'];
			?>
			<tr>
				<td><?php echo $sr; ?></td>
				<td><?php echo $res['register_no'];?></td>
				<td><?php echo $stuname; ?></td>
				<td><?php echo $clsname; ?></td>
				<td><?php echo $secname; ?></td>
				
			<td>
			<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> 
			<i class="fa fa-trash"></i> Delete </a>
			
			</td>
				
			</tr>
			<?php 
			$sr++; 
			} ?>
			</tbody>
		</table>
	</div>
</div><br>
				
							
<?php
}
else
{
	echo "<script>alert('No Students Assigned to this Group.')</script>";
}
?>							
							