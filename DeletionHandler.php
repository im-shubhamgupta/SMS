<?php
include('myfunction.php');

if (isset($_POST['ArchiveData'])) {
    // print_r($_POST);
    date_default_timezone_set('Asia/Kolkata');
    $ArchiveTable = $_POST['ArchiveTable'];
    $Archive_dataidtype = $_POST['Archive_dataidtype'];
    $deletion_id = $_POST['id'];
    $deleted_by = $_SESSION['user_roles'];
    $statusSql=($_POST['status']=='1') ? " `status`='0' ,  " : '' ;//it means status column is avilable
    $deletion_date = date('Y-m-d H:i:s');
    $deletion_indicator = 1;
    $status = 0;
   
   

    switch ($ArchiveTable) {

        case "class":
            $Usql = "UPDATE `$ArchiveTable` SET `deletion_indicator` = '$deletion_indicator', $statusSql `deletion_date` = '$deletion_date',`modify_date`='$deletion_date', `deleted_by` = '$deleted_by' WHERE `$Archive_dataidtype` = '$deletion_id' ";
             
            $query_stu=mysqli_query($con,"select * from student_records where class_id='$deletion_id' and session='".$_SESSION['session']."' ");
            if(!mysqli_num_rows($query_stu)){
                $deletion_Query = $con->query($Usql);
            }else{
                die("Cannot Delete Class. Students, Fees and Sections are linked with this Class.");
                
            }

        case "section":
            $Usql = "UPDATE `$ArchiveTable` SET `deletion_indicator` = '$deletion_indicator', $statusSql `deletion_date` = '$deletion_date',`modify_date`='$deletion_date', `deleted_by` = '$deleted_by' WHERE `$Archive_dataidtype` = '$deletion_id' ";
                
            $query_stu=mysqli_query($con,"select * from student_records where section_id='$deletion_id' and session='".$_SESSION['session']."' ");
            if(!mysqli_num_rows($query_stu)){
                $deletion_Query = $con->query($Usql);
            }else{
                die("Cannot Delete Section. Student Sections are linked with this Class.");
                
            }    
                        
        break;

        case "fee_header":
            $Usql = "UPDATE `$ArchiveTable` SET `deletion_indicator` = '$deletion_indicator', $statusSql `deletion_date` = '$deletion_date',`modify_date`='$deletion_date', `deleted_by` = '$deleted_by' WHERE `$Archive_dataidtype` = '$deletion_id' ";
                
            $query = mysqli_query($con,"select * from assign_fee_class where `session`='".$_SESSION['session']."' ");

            $c = 0;
            while($res = mysqli_fetch_array($query)){      
                $rfstr=$res['fee_header_id'];
                $arr = explode(',',$rfstr);
                foreach($arr as $k){  
                    if($k == $deletion_id){      
                        $c += 1; 
                    }
                }
            }    
            if($c>0){
                die("This fees header cannot be deleted. Contact Administrator");
            }else{
                $deletion_Query = $con->query($Usql);
            }    
                        
        break;

        default:
        $Usql = "UPDATE `$ArchiveTable` SET `deletion_indicator` = '$deletion_indicator', $statusSql `deletion_date` = '$deletion_date',`modify_date`='$deletion_date', `deleted_by` = '$deleted_by' WHERE `$Archive_dataidtype` = '$deletion_id' ";
        $deletion_Query = $con->query($Usql);

       
    }
    if ($deletion_Query) {
        $Isql = "insert into log_archive_data(`deleted_by`,`table_name`,`deletion_id`,`machine_name`,`browser`,`session`,`deletion_date`)values('$deleted_by','$ArchiveTable','$deletion_id','".$_SESSION['machinename']."','".$_SESSION['ExactBrowserNameBR']."','" . $_SESSION['session'] . "','$deletion_date') ";

        $log = $con->query($Isql);

        if ($log) {
            echo 'success';
        } else {
            echo 'Data Deleted. Error: '.mysqli_error($con);
        }
    } else {
        echo 'Please try again. Error: '.mysqli_error($con);
    }

}
