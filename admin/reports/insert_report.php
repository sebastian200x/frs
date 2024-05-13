<?php
require_once('../config.php');

// Include the database connection class
require_once('DBConnection.php');

// Handle form submission and database insertion
$response = array();

// Check if all required fields are set
if(isset($_POST['log_id'], $_POST['resident_name'], $_POST['employee_name'], $_POST['file_mark'], $_POST['file_category'])){
    // Get form data
    $log_id = $_POST['log_id'];
    $resident_name = $_POST['resident_name'];
    $employee_name = $_POST['employee_name'];
    $file_mark = $_POST['file_mark'];
    $file_category = $_POST['file_category'];

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO tbl_report_files (log_id, resident_name, employee_name, file_mark, file_category) VALUES (?, ?, ?, ?, ?)";
    $stmt = $master->conn->prepare($sql);
    $stmt->bind_param("sssss", $log_id, $resident_name, $employee_name, $file_mark, $file_category);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['msg'] = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['msg'] = 'All fields are required';
}

// Return the JSON response
echo json_encode($response);
?>
