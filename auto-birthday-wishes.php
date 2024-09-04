<?php 
include('myfunction.php');
date_default_timezone_set('Asia/Kolkata');
$dob_date=date('Y-m-d');
 $sql=" SELECT `student_id`,`student_name`,`parent_no` FROM `students` where `stu_status`='0' and `msg_type_id`='1' and dob='$dob_date'  ";
 $sch_name=get_school_details()['company_name'];
$messagetype="birthday_msg";
$query=mysqli_query($con,$sql);
if(mysqli_num_rows($query)>0){

    while($row=mysqli_fetch_assoc($query)){
        // print_r($row);
        $mobile=$row['parent_no'];
        if(!empty($row['student_name']) && !empty($sch_name) && !empty($mobile)){
        
           $msgg="Dear ".$row['student_name'].",%0aWish you a many many happy returns of the day. May God bless you with health, wealth and prosperity in your life. HAPPY BIRTHDAY.%0aRegards %0a".$sch_name." ";

            sendwhatsappMessage($mobile, $msgg, $messagetype);
        }    

    }
}
mysqli_close($con);