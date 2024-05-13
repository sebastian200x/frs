<?php
require_once('../../config.php');

// Include the database connection class
require_once('../../classes/DBConnection.php');

class createLog extends DBConnection {
    public function createLogs($log_id, $resident_name, $user_id, $timestamp, $confidence_score) {
        // SQL statement to insert data into the database
        $sql = "INSERT INTO tbl_recognitionlogs (log_id, resident_name, user_id, timestamp, confidence_score) 
                VALUES ('$log_id', '$resident_name', '$user_id', '$timestamp', '$confidence_score')";

        // Execute the SQL query
        if ($this->conn->query($sql) === TRUE) {
            return true; // Return true if insertion is successful
        } else {
            // Return the error message if insertion fails
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
    public function saveFace($face_id, $face_image, $date_and_time, $resident_name){
        $sql = "INSERT INTO tbl_faces (face_id, face_image, date_and_time, resident_name) 
                VALUES ('$face_id', '$face_image', '$date_and_time', '$resident_name')";
                if ($this->conn->query($sql) === TRUE) {
                    return true; // Return true if insertion is successful
                } else {
                    // Return the error message if insertion fails
                    return "Error: " . $sql . "<br>" . $this->conn->error;
                }
    }
}	

// Create an instance of the createLog class
$createLog = new createLog();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example usage:
    $log_id = ''; // Assign the log_id value
    $resident_name = $_POST['user_name']; // Assign the face_id value
    $user_id = $_settings->userdata('firstname'); // Get the user_id from $_settings
    $timestamp = date("Y-m-d H:i:s"); // Get the current timestamp
    $confidence_score = $_POST['confidence_score']; // Access confidence score from POST data
    

    
    $face_id = '';// Assign the face_id value
    $face_image = './face/labels/'.$resident_name; // Assign the face_image value
    $date_and_time = date("Y-m-d H:i:s"); // Get the current timestamp
    $resident_name = $_POST['user_name']; // Assign the resident_name value

    // Call the createLogs method to insert data into the database
    $insertResult = $createLog->createLogs($log_id, $resident_name, $user_id, $timestamp, $confidence_score);
    $insertFaces = $createLog->saveFace($face_id, $face_image, $date_and_time, $resident_name);
    // Check if insertion was successful or not
    if ($insertResult === true && $insertFaces === true) {
    
        echo '<script>
        setTimeout(function() {
            window.location.href = "../?page=reports/success";
        }, 1); // Redirect after 1 second
    </script>';
    } else {
        echo $insertResult; // Print the error message if insertion fails
    }
}
?>

