<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facial Capture</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #video {
        transform: scaleX(-1); /* This flips the video horizontally */
        -webkit-transform: scaleX(-1); /* For Safari */
        transform-origin: center; /* Ensures the flip happens around the center */
        -webkit-transform-origin: center; /* For Safari */
    }
        .align-left {
            text-align: left;
        }
        .faceCapture{
            margin-top:75px;
        }
        h1{
            margin-top:50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Facial Capture</h1>
        <div class="faceCapture">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <video id="video" width="100%" height="auto" autoplay></video>
                    <small>Take a picture 3 times before you click save</small><br>
                    <button id="capture-btn" class="btn btn-primary mt-3">Capture</button>
                </div>
            </div>
            <div class="col-md-6">
                <form id="info-form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first-name" class="align-left">First Name:</label>
                        <input type="text" class="form-control" id="first-name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name" class="align-left">Last Name:</label>
                        <input type="text" class="form-control" id="last-name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="align-left">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday" class="align-left">Birthday:</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" required>
                    </div>
                    <div class="form-group">
                        <label for="cellphone" class="align-left">Cellphone Number:</label>
                        <input type="tel" class="form-control" id="cellphone" name="cellphone" required>
                    </div>
                    <input type="hidden" id="image-data" name="image-data">
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const video = document.getElementById('video');
        const captureBtn = document.getElementById('capture-btn');
        const imageDataInput = document.getElementById('image-data');
        let captureCount = 0;
        let capturedImages = [];

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing camera:', error);
            });

        captureBtn.addEventListener('click', () => {
            if (captureCount < 3) {
                
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/jpeg');
                capturedImages.push(imageData);
                alert('Image captured ' + captureCount);
                if (captureCount === 3) {
                    captureBtn.disabled = true;
                }
            } else {
                alert('You have captured the maximum number of photos.');
            }
            captureCount++;
        });

        document.getElementById('info-form').addEventListener('submit', event => {
            event.preventDefault();
            imageDataInput.value = JSON.stringify(capturedImages);
            document.getElementById('info-form').submit(); // Submit the form
        });
    </script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the required fields are set
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address']) && isset($_POST['image-data']) && isset($_POST['birthday']) && isset($_POST['cellphone'])) {
        // Get user input
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday']; // Retrieve birthday field
        $cellphone = $_POST['cellphone']; // Retrieve cellphone number field
        $folderName = $firstName . ' ' . $lastName;
        $imageDataList = json_decode($_POST['image-data']);
        $staff = $_settings->userdata('firstname');

        // Check if the fields are not empty
        if (!empty($firstName) && !empty($lastName) && !empty($address) && !empty($imageDataList)) {
            // Function to create a folder
            function createFolder($folderName) {
                // Specify the directory where the folder will be created
                $directory = "face/labels/";

                // Check if the folder already exists
                if (!is_dir($directory . $folderName)) {
                    // Create the folder
                    if (mkdir($directory . $folderName, 0777, true)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }

            // Create folder if it doesn't exist
            if (!createFolder($folderName)) {
                echo '<div class="alert alert-danger" role="alert">Failed to create folder.</div>';
                exit;
            }

            // Save the images
            foreach ($imageDataList as $index => $imageData) {
                $imagePath = "face/labels/$folderName/" . ($index) . ".jpg";
                if (!file_put_contents($imagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)))) {
                    echo '<div class="alert alert-danger" role="alert">Failed to save image $index.</div>';
                    exit;
                }
            }

            // Prepare data to save to labels.json
            $dataToSave = array(
                'name' => $firstName . ' ' . $lastName,
                'address' => $address,
                'birthday' => $birthday,
                'cellphone' => $cellphone,
                'staff' => $staff
            );

            // Read existing data from labels.json
            $labelsFilePath = './face/labels.json';
            $existingData = array();
            if (file_exists($labelsFilePath)) {
                $encryptedDataWithIV = file_get_contents($labelsFilePath);
                if ($encryptedDataWithIV !== false) {
                    $iv_hex = substr($encryptedDataWithIV, 0, 32); // Extract IV from the beginning
                    $encryptedData = substr($encryptedDataWithIV, 32); // Extract encrypted data without IV
                    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', 'Adm1n123', 0, hex2bin($iv_hex));
                    if ($decryptedData !== false) {
                        $existingData = json_decode($decryptedData, true);
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Failed to decrypt data from labels.json.</div>';
                        exit;
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Failed to read data from labels.json.</div>';
                    exit;
                }
            }

            // Check if the name already exists
            $nameExists = false;
            foreach ($existingData as $data) {
                if ($data['name'] == $dataToSave['name']) {
                    $nameExists = true;
                    break;
                }
            }

            if ($nameExists) {
                echo '<div class="alert alert-danger" role="alert">Name already exists in the database.</div>';
                exit;
            }

            // Append new data to existing data
            $existingData[] = $dataToSave;

            // Encrypt and write updated data back to labels.json
            $iv = openssl_random_pseudo_bytes(16); // Generate a random IV of 16 bytes (128 bits)
            $iv_hex = bin2hex($iv); // Convert the binary IV to hexadecimal representation
            $encryptedData = openssl_encrypt(json_encode($existingData), 'aes-256-cbc', 'Adm1n123', 0, $iv);
            $encryptedDataWithIV = $iv_hex . $encryptedData; // Combine IV and encrypted data

            if (file_put_contents($labelsFilePath, $encryptedDataWithIV)) {
                echo '<div class="alert alert-success" role="alert">Data saved successfully.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Failed to save data to labels.json.</div>';
            }

            // Redirect to index page after 2 seconds
            echo '<script>
                setTimeout(function() {
                    window.location.href = "?page=face";
                }, 2000);
            </script>';
            exit; // Stop further execution
        } else {
            // Return error message if required fields are empty
            echo '<div class="alert alert-danger" role="alert">Required fields are empty.</div>';
            exit;
        }
    } else {
        // Return error message if required keys are not set
        echo '<div class="alert alert-danger" role="alert">Required keys are not set.</div>';
        exit;
    }
}
?>










</body>
</html>
