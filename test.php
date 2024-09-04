<?php 
  include("connection.php");
  $all_category = $con->all_fetch("attributes",array('status'=>'Yes','type'=>'4'),'order by name asc');
    
	
	if(is_array($all_category) || is_object($all_category)){  
	
	//update fetch
    $find_array = array();
    $fetch_mul_cat = $con->all_fetch('multiple_category',array('p_id'=>$list_id,'type'=>1));
	if(is_array($fetch_mul_cat) || is_object($fetch_mul_cat)){
		  foreach($fetch_mul_cat as $fmc){
			  $find_array[] = $fmc->cat_id;
		  }
	}
  
	foreach($all_category as $fc){ 
	  
	if(in_array($fc->id,$find_array)){
   ?>
		<option value="<?=$fc->id;?>" selected><?=$fc->name;?></option>
	<?php }else{ ?>
		<option value="<?=$fc->id;?>"><?=$fc->name;?></option>
  <?php } } } ?>