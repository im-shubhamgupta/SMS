<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if (isset($_REQUEST['sessionid']) && isset($_REQUEST['login_user_id'])) {

    $login_user_id = $_REQUEST['login_user_id'];
    $sessionid = $_REQUEST['sessionid'];
    $class_id = $_REQUEST['class_id'];
    $section_id = $_REQUEST['section_id'];
    $current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
    $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

    $result = important_message_list($class_id, $section_id, $sessionid, $login_user_id, $current_page, $per_page);

    if ($result != false) {

        $response["result"] = $result;

        $response["status"] = 1;

        $response["message"] = "Success";

        echo json_encode($response);
    } else {
        $response["result"] = '';

        $response["status"] = 3;

        $response["message"] = "No Data Found";

        echo json_encode($response);
    }
} else {

    $response["status"] = 2;

    $response["message"] = "Required Parameter message, login_userid  is missing";

    echo json_encode($response);
}
