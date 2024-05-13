<?php
class saveFaces extends DBConnection {
    public function createLogs($face_id, $face_image, $date_and_time, $resident_name) {
        // SQL statement to insert data into the database
        $sql = "INSERT INTO tbl_faces (face_id, face_image, date_and_time, resident_name) 
                VALUES ('$face_id', '$face_image', '$date_and_time', '$resident_name')";

        // Execute the SQL query
        if ($this->conn->query($sql) === TRUE) {
            return true; // Return true if insertion is successful
        } else {
            // Return the error message if insertion fails
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

// Create an instance of the createLog class
$saveFaces = new saveFaces();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example usage:
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $face_id = '' // Assign the face_id value
    $face_image = './face/labels/'.$firstName.' '.$lastName; // Assign the face_image value
    $date_and_time = date("Y-m-d H:i:s"); // Get the current timestamp
    $resident_name = $_POST['resident_name']; // Assign the resident_name value

    // Call the createLogs method to insert data into the database
    $insertResult = $createLog->createLogs($face_id, $face_image, $date_and_time, $resident_name);

    // Check if insertion was successful or not
    if ($insertResult === true) {
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