<?php
// Include your database connection code here
require_once('../config.php');

// Include the database connection class
require_once('DBConnection.php');
if(isset($_POST['logId'])) {
    $logId = $_POST['logId'];
    $result = $conn->query("DELETE FROM `tbl_recognitionlogs` WHERE `log_id` = '$logId'");
    if($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Log ID not provided']);
}
?>