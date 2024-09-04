<?php
extract($_REQUEST);
include('connection.php');

$query = mysqli_query($con,"select * from assign_department where dept_id='$deptid'");	

$row = mysqli_num_rows($query);
if($row)
{
?>

<div class="card" style="width:900px">
	<div class="card-body">
		<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Sr. No</th>
					<th>Staff Name</th>
					<th>Action</th>
					
				</tr>
			</thead>
			<tbody id="PTResults">
			<?php 
			$sr=1;
			while($res=mysqli_fetch_array($query))
			{
			$id=$res['ass_dept_id'];
			$stid=$res['staff_id'];
			$q1 = mysqli_query($con,"select * from staff where st_id='$stid'");
			$r1 = mysqli_fetch_array($q1);
			$stname = $r1['staff_name'];
		
			?>
			<tr>
				<td><?php echo $sr; ?></td>
				<td><?php echo $stname; ?></td>
				
				
			<td>
			<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>
			
			</td>
				
			</tr>
			<?php 
			$sr++; 
			} ?>
			</tbody>
		</table>
	</div>
</div><br>

<a href="export_assign_department_excel.php?deptid=<?php echo $deptid;?>" class="btn btn-success" style="margin-left:360px;">
<i class="fa fa-download"></i> Download To Excel</a>
						
							
<?php
}
else
{
	echo "<script>alert('No Staff Assigned to this Department.')</script>";
}
?>							
							