<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
   $class = $_POST['class'];
   $section = $_POST['section'];

if($class!="" and $section!="")
{
   // search in all table columns

$query = "SELECT * FROM `students` WHERE `class_id`='$class' and section_id='$section' and stu_status='0'";
$search_result = filterTable($query);
   }
else if($class!="" and $section=="")
{
$query = "SELECT * FROM `students` WHERE `class_id`='$class' and stu_status='0'";
$search_result = filterTable($query);
}	
else
{
$query = "SELECT * FROM `students` where stu_status='0'";
   $search_result = filterTable($query);
}
}

else {
   $query = "SELECT * FROM `students` where stu_status='0'";
   $search_result = filterTable($query);
}
// function to connect and execute the query
function filterTable($query)
{
    include('connection.php');
    //$connect = mysqli_connect("localhost", "root", "", "school_billing");
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}



?>


<div id="right-panel" class="right-panel">
<form method="post" action="dashboard.php?option=view_students" enctype="multipart/form-data">
       
<?php
if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
{
?>
<div class="breadcrumbs" style="width:1200px">
           <div class="col-sm-4" style="padding:10px;">  
               <a href="dashboard.php?option=add_students" class="btn btn-outline-primary">Add Student</a>
           </div>
       </div>
<?php
}
?>

       <div class="content mt-3" style="width:1200px">
           <div class="animated fadeIn">
               <div class="row">

                   <div class="col-md-12">
                       <div class="card">
                           <div class="card-header">
                              
  <div class="row" style="margin-top:20px;">
<div class="col-md-1" style="margin-left:10px;">Class</div>
<div class="col-md-2">
<div class="sorting-left">
<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
<option selected="selected" disabled >---Select Class---</option>
<?php
$scls = "select * from class";
$rcls = mysqli_query($con, $scls);
while( $rescls = mysqli_fetch_array($rcls) ) {
?>