<?php
include('connection.php');

$clsid = $_POST['clsid'];
$secid = $_POST['secid'];
$testname = $_POST['testname'];
$subid = $_POST['subid'];

$qcls = mysqli_query($con,"select * from class where class_id='$clsid'");
$rcls = mysqli_fetch_array($qcls);

$sid = $section;
$qsid = mysqli_query($con,"select * from section where section_id='$secid'");
$rsid = mysqli_fetch_array($qsid);

$sub = $subject;
$qsub = mysqli_query($con,"select * from subject where subject_id='$sub'");
$rsub = mysqli_fetch_array($qsub);

$mmax = $res['max_marks'];


$output = "";

$output = 	'<div class="card">
				<div class="card-body">
				<h6>MARKS ENTRY</h6>
				<div class="row" style="margin-top:20px;">
					<div class="col-md-2" style="margin-left:50px;">Class : </div>
					<div class="col-md-2" style="margin-top:-10px;margin-left:-80px">
					<input type="text" value="<?php echo $rcls['class_name'];?>" class="form-control" style="width:175px;" disabled>
					</div>
					
												
					<div class="col-md-2" style="margin-left:80px;">Section : </div>
					<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
					<input type="text" value="<?php echo $rsid['section_name'];?>" class="form-control" style="width:175px;" disabled>
					</div>
				</div><br>
				<div class="row" style="margin-top:20px;">
					<div class="col-md-2" style="margin-left:50px;">Subject : </div>
					<div class="col-md-2" style="margin-top:-10px;margin-left:-80px;">
					<input type="text" value="<?php echo $rsub['subject_name'];?>" class="form-control" style="width:175px;" disabled>
					</div>
					
					<div class="col-md-2" style="margin-left:80px;">Test Name : </div>
					<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
					<input type="text" value="<?php echo $test;?>" class="form-control" style="width:175px;" disabled>
					</div>
				</div><br><br>	
						
				<h6>STUDENT DETAILS</h6><br>
				<div class="row">
					<div class="col-md-2" style="font-size:14px;margin-left:50px;">Max Marks : </div>
					<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
					<input type="number" name="max1" id="max1" value="<?php echo $mmax;?>" class="form-control" style="width:175px;" readonly>
					</div>
				</div><br>
				
				<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
					<thead>
						<tr>
							 <th>Sl No.</th>
							 <th>Student Name</th>
							 <th>Gender</th>
							 <th>Marks</th>
						</tr>
					</thead>
					<tbody id="tablebody">
					<?php 
					$que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' && stu_status='0'");
					$i=1;							
					while($res1=mysqli_fetch_array($que2))
					{									
					$stuid = $res1['student_id'];
					$stuname = $res1['student_name'];
					$gender = $res1['gender'];
							
					$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && student_id='$stuid' && test_name='$test' && subject_id='$subject'");
					$res3 = mysqli_fetch_array($que3);
					$stumarks = $res3['marks'];
					?>
					<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $stuname; ?></td>
					<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">
					
					<td><?php echo $gender;?></td> 
					
					<td><input type="text" name="marks[]" id="marks" value="<?php echo $stumarks;?>" style="width:100px" class="form-control marks" autofocus required></td>
														
					</tr>
					<?php
					$i++;
					}
					?>					
					</tbody>
				</table>
				</div>	
			</div><br><br>';

echo $output;
?>