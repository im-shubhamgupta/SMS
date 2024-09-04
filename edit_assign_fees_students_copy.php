<?php
error_reporting(1);
extract($_REQUEST);

$cl = $_REQUEST['cl1'];
$se = $_REQUEST['se1'];


$qu1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
$ru1 = mysqli_fetch_array($qu1);

$clsid = $ru1['class_id'];
$qu2 = mysqli_query($con,"select * from class where class_id='$clsid'");
$ru2 = mysqli_fetch_array($qu2);
$clsname = $ru2['class_name'];

$secid = $ru1['section_id'];
$qu3 = mysqli_query($con,"select * from section where section_id='$secid'");
$ru3 = mysqli_fetch_array($qu3);
$secname = $ru3['section_name'];

$qu4 = mysqli_query($con,"select * from students where student_id='$stuid'");
$ru4 = mysqli_fetch_array($qu4);
$stuname = $ru4['student_name'];


if(isset($save))
{
	
	$q1  = mysqli_query($con,"select * from student_due_fees where student_id='$sid'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "<script>alert('Cannot Edit Fees')</script>";
	}
	else
	{
		$qs = mysqli_query($con,"select * from students where student_id='$sid'");
		$rs = mysqli_fetch_array($qs);
		$sname = $rs['student_name'];
		
		$q = mysqli_query($con,"select * from student_wise_fees where student_id='$sid'");
		$r = mysqli_fetch_array($q);	

		$olddue = $r['due_amount'];
		$olddisc = $r['discount_amount'];
		$oldextra = $r['extra_amount'];
		
		$strhid = implode(',',$headid);
		$strmode = implode(',',$fmode);
		$strorgamt = implode(',',$headamt);
		$strhamt = implode(',',$updatedfee);
		$strreason = implode(',',$reason);
		
		$newarr = array_combine($headamt,$updatedfee);
		
			
			
		foreach($newarr as $k1=> $v1)
		{
			$disc = 0;
			$extra = 0;
			
			if($v1==$k1)
			{
				$disc = $disc;
				$extra = $extra;
			}
			else if($k1 > $v1)
			{
				$disc = $k1 - $v1;
			}
			else if($k1 < $v1)
			{
				$extra = $v1 - $k1;
			}	
			
			$tdisc = $tdisc + $disc;
			$textra = $textra + $extra;
		}	
		
		
			$due = $olddue + $olddisc - $oldextra - $tdisc + $textra;
		
		$que1 = "update student_wise_fees set fee_header_id='$strhid', fee_mode='$strmode', 
		fee_amount='$strhamt', due_amount='$due', discount_amount='$tdisc', extra_amount='$textra', reason='$strreason',
		status='1' where student_id='$sid'";
		
		if(mysqli_query($con,$que1))
		{
			$action = $sname." Fees Updated "; 
			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
			machine_name,browser,date) 
			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
		}
			
		$que2 = mysqli_query($con,"update students set due='$due' where student_id='$sid'");
		echo "<script>window.location='dashboard.php?option=view_assign_fees_students&class=$cl1&section=$se1&search=search'</script>";

	}

}

if(isset($cancel))
{
	echo "<script>window.location='dashboard.php?option=view_assign_fees_students&class=$cl1&section=$se1'</script>";
}

?>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}
	
	.row1 {
		margin:0px 10px 0px 10px;
		border:1px solid grey;
	}
	
	.row2 {
		margin:0px 10px 0px 10px;
		border-left:1px solid grey;
		border-bottom:1px solid grey;
	}
	
	.row3 {
		border-right:1px solid grey;
	}
	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->
<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb" style="width:1050px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_assign_fees_students">View Assign Fees to Students</a>
  <span class="breadcrumb-item active">Update Fees to Student</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=edit_assign_fees_students" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px;margin-left:10px;">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
					  <input type="hidden" name="cl1" value="<?php echo $cl?>">
					  <input type="hidden" name="se1" value="<?php echo $se?>">
						
					  <div class="row row1">
						  <div class="col-md-4 row3" style="padding:10px;">Student Name : <?php echo $stuname;?> </div>
						 <div><input type="hidden" name="sid" value="<?php echo $stuid;?>"></div>
						 
						  <div class="col-md-4 row3" style="padding:10px;">Class : <?php echo $clsname;?> </div><div><input type="hidden" name="classid" value="<?php echo $clsid;?>"></div>
						  
						  <div class="col-md-4" style="padding:10px;">Section : <?php echo $secname;?> </div>
					  </div>
					  
					  <div class="row row2">
<?php
$qf = mysqli_query($con,"select * from assign_fee_class where class_id='$clsid'");
$rf = mysqli_fetch_array($qf);
	
	$feehead = $rf['fee_header_id'];
	$headarr = explode(',',$feehead);
	
	$oamt = $rf['fee_header_amount'];
	$oamtarr = explode(',',$oamt);

	$array=array_combine($headarr,$oamtarr);
	
	foreach($array as $key=>$value)
	{
		
	$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$key'");
	$r1 = mysqli_fetch_array($q1);
	$fheadname = $r1['fee_header_name'];
	
	$row = sizeof($headarr);
	if($row<3)
	{
	
?>	

	<div class="col-md-6 row3" style="padding:10px;">
	<?php echo $fheadname." : ".$value ;?> </div>

<?php	
	}
else
	{

?>

	<div class="col-md-4 row3" style="padding:10px;">
	<?php echo $fheadname." : ".$value;?> </div>
	
<?php
	}
	}
?>	
  </div>
					  <br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
										<th>Fees Header</th>
										<th>Mode</th>
										<th>Actual Fees</th>
										<th>Updated Fees</th>
										<th>Reason</th>
                                    </thead>
                                    <tbody>
<?php 
$que = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
$rque = mysqli_fetch_array($que);
$hid = $rque['fee_header_id']; 
$hidarr = explode(',',$hid);

$hamt = $rque['fee_amount']; 
$hamtarr = explode(',',$hamt);

$hmode = $rque['fee_mode']; 
$hmodearr = explode(',',$hmode);

$qu1 = mysqli_query($con,"select * from assign_fee_class where class_id='$clsid'");
$rqu1 = mysqli_fetch_array($qu1);
$nhid = $rqu1['fee_header_id']; 
$nhidarr = explode(',',$nhid);
$namt = $rqu1['fee_header_amount']; 
$namtarr = explode(',',$namt);

$totalh = sizeof($nhidarr);
for($i=0;$i<$totalh;$i++)
	{
		
	$newhid = $hidarr[$i];
	$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$newhid'");
	$r1 = mysqli_fetch_array($q1);
	$hname = $r1['fee_header_name'];
	
	$newhmode = $hmodearr[$i];
	
	$newhamt = $hamtarr[$i];	
	
	if(in_array($newhid,$nhidarr))
	{
		$pos = array_search($newhid,$nhidarr);
		$val = $namtarr[$pos];	
	}
?>
<tr>
	<td><?php echo $hname;?></td>
	<input type="hidden" name="headid[]" value="<?php echo $newhid;?>">

	<td> 
		<select class="form-control" name="fmode[]" id="<?php echo $newhid;?>" onchange="test(this.value, this.id)">
		<?php
		$qfeemode = mysqli_query($con,"select * from fee_mode where fee_mode_id !=4");
		while($rfeemode = mysqli_fetch_array($qfeemode))
		{										
		$modeid = $rfeemode['fee_mode_id'];
		$modename = $rfeemode['fee_mode_name'];
		?>
		<option <?php if($newhmode==$modeid){echo "selected";}?> value="<?php echo $modeid; ?>"><?php echo $modename;?>
		</option>
		
		<?php
		}
		?>
		</select>
	</td>
	
	<td><?php echo $newhamt;?></td>
	<!--<input type="hidden" name="headamt[]" id="namt<?php echo $newhid;?>" value="<?php echo $newhamt;?>">-->
	<input type="hidden" name="headamt[]" id="amt<?php echo $newhid;?>" value="<?php echo $val;?>">
	
	<td><input type="number" name="updatedfee[]" id="updfee<?php echo $newhid;?>" value="<?=$newhamt;?>" 
	class="form-control readonly" style="width:150px;" min="0"></td>
	
	<td><input type="text" name="reason[]" id="reason<?php echo $newhid;?>" class="form-control"
	style="width:150px;display:<?php if(!empty($reason)){echo 'block';} else {echo 'none';}?>"></td>

</tr>
<?php
	}
?>
<script>
function test(fid,key)
{
	var tmp1 = "updfee"+key;
	var tmp2 = "reason"+key;
	
	$amt = $("#amt"+key).val();
	
	//alert($amt);
	if(fid=="2" || fid=="3" || fid=="4")
	{
		if(fid=="2") 
		{
			$("#"+tmp1).prop('min',parseInt($amt)+1);
			$("#"+tmp1).removeAttr('max');
			$("#"+tmp1).removeAttr('readonly');
			$("#"+tmp1).val(0);
			$("#"+tmp2).removeAttr('readonly');
		}
		else if(fid=="3") 
		{
			$("#"+tmp1).prop('max',parseInt($amt)-1);
			$("#"+tmp1).prop('min',0);
			$("#"+tmp1).removeAttr('readonly');
			$("#"+tmp1).val(0);
			$("#"+tmp2).removeAttr('readonly');
		}
		else if(fid=="4") 
		{
			$("#"+tmp1).prop('min',0);
			$("#"+tmp1).prop('max',0);
			$("#"+tmp1).val(0);
			$("#"+tmp1).attr('readonly','readonly');
			$("#"+tmp1).val(0);
			$("#"+tmp2).attr('readonly','readonly');
		}
		$("#"+tmp1).css("display","block");		 
		$("#"+tmp1).attr('required',true); 
		$("#"+tmp2).css("display","block");		 
		$("#"+tmp2).attr('required',true); 
	}
	else
	{
		$("#"+tmp1).val($amt);
		$("#"+tmp1).attr('readonly','readonly');
		$("#"+tmp2).css("display","none");
		$("#"+tmp2).val(0);
	}	
	
}
</script>


 <script>
 
$(document).ready(function(){
	
	$(".readonly").attr('readonly','readonly');
	
});
</script>																
                                    </tbody>
                                </table>
                            </div>
                        </div>
					
	<div class="row">
	<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
	
		<div class="row" style="margin-top:20px;">
			<div class="col-md-2">
			<input type="submit" name="save" class="btn btn-primary btn-sm" value="Save" style="width:120px;height:35px;margin-left:350px;">
			</div>
			<div class="col-md-2">
			<input type="submit" name="cancel" class="btn btn-primary btn-sm" value="Cancel" style="width:120px;height:35px;margin-left:350px;">
			</div>
		</div>
	
	</div>						
	</div><br>
						
						
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 