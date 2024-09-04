<?php 


// extract($_REQUEST);

include_once('connection.php');

$cls_id=$_REQUEST['cls_id'];



?>



<select class="form-control" name="section" style="width:175px;">

<!-- <option value="All" selected>All</option> -->



<?php 

if(!empty($cls_id)){
    $c=mysqli_query($con,"select * from section where class_id='$cls_id'");

    while($s_res=mysqli_fetch_array($c))

    {

    ?>

    <option value="<?php echo $s_res['section_id']; ?>"><?php echo $s_res['section_name']; ?></option>

    <?php }

}else{
    echo '<option value="0">All Sections</option>';
 }
?>

</select>