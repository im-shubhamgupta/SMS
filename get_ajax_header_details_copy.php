<?php 
//print_r($_REQUEST);
extract($_REQUEST);

include('connection.php');

$que = mysqli_query($con,"select * from assign_fee_class where class_id='$cls_id'");
$rque = mysqli_fetch_array($que);
$hid = $rque['fee_header_id']; 
$hidarr = explode(',',$hid);

$hamt = $rque['fee_header_amount']; 
$hamtarr = explode(',',$hamt);

$array = array_combine($hidarr,$hamtarr);

	foreach($array as $key => $value)
	{
	$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$key'");
	$r1 = mysqli_fetch_array($q1);
	$hname = $r1['fee_header_name'];

?>
<tr>
	<td><?php echo $hname;?></td>
	<input type="hidden" name="headid[]" value="<?php echo $key;?>">
	
	<td> 
		<select class="form-control" name="fmode[]" id="<?php echo $key;?>" onchange="test(this.value, this.id)">
		<?php
		$qfeemode = mysqli_query($con,"select * from fee_mode where fee_mode_id !=4");
		while($rfeemode = mysqli_fetch_array($qfeemode))
		{										
		$modeid = $rfeemode['fee_mode_id'];
		$modename = $rfeemode['fee_mode_name'];
		?>
		<option value="<?php echo $modeid;?>"><?php echo $modename;?></option>
		<?php
		}
		?>
		</select>
	</td>
	
	<td><?php echo $value;?></td>
	<input type="hidden" name="headamt[]" id="amt<?php echo $key;?>" value="<?php echo $value;?>">
	
	<td><input type="number" name="updatedfee[]" id="updfee<?php echo $key;?>" value="<?=$value;?>" 
	class="form-control readonly" style="width:150px;" min="0"></td>
	
	<td><input type="text" name="reason[]" id="reason<?php echo $key;?>" class="form-control"
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
		//$("#"+tmp2).attr('required',true); 
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