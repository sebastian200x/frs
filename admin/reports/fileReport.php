<?php 
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
?>

<?php
require_once('../config.php');

// Include the database connection class
require_once('../classes/DBConnection.php');

class fileReport extends DBConnection {
    // Function to fetch the count of each file category
    public function getFileCategoryCounts() {
        $counts = array();

        // Query to count occurrences of each file category
        $sql = "SELECT file_category, COUNT(*) AS count FROM tbl_report_files GROUP BY file_category";
        $result = $this->conn->query($sql);

        // Check if query was successful
        if ($result) {
            // Fetch the results and store them in an associative array
            while ($row = $result->fetch_assoc()) {
                $counts[$row['file_category']] = $row['count'];
            }
        }

        // Return the counts
        return $counts;
    }

    // Function to insert a new report into the database
    public function insertReport($log_id, $resident_name, $employee_name, $file_mark, $file_category) {
        $response = array();

        // Check if all required fields are set
        if(isset($log_id, $resident_name, $employee_name, $file_mark, $file_category)){
            // Prepare and bind the SQL statement
            $sql = "INSERT INTO tbl_report_files (log_id, resident_name, employee_name, file_mark, file_category, Date) 
            VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssss", $log_id, $resident_name, $employee_name, $file_mark, $file_category);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                $response['status'] = 'success';
            } else {
                $response['status'] = 'error';
                $response['msg'] = "Error: " . $stmt->error;
            }
            echo '<script>
                setTimeout(function() {
                    window.location.href = "?page=reports/success";
                }, 1);
            </script>';
             
            // Close the statement
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['msg'] = 'All fields are required';
        }
        
        // Return the JSON response
        return json_encode($response);
    }
}

// Instantiate the fileReport class
$reportDB = new fileReport();

// Get the file category counts
$fileCategoryCounts = $reportDB->getFileCategoryCounts();

// Handle form submission and database insertion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $log_id = $_POST['log_id'];
    $resident_name = $_POST['resident_name'];
    $employee_name = $_POST['employee_name'];
    $file_mark = $_POST['file_mark'];
    $file_category = $_POST['file_category'];

    // Insert report
    $insertResult = $reportDB->insertReport($log_id, $resident_name, $employee_name, $file_mark, $file_category);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Logs</title>
</head>
<body>
    <div class="content py-5 px-3 bg-gradient-blue">
        <h2>File Logs</h2>
    </div>
    <div class="row flex-column mt-4 justify-content-center align-items-center mt-lg-n4 mt-md-3 mt-sm-0">
        <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
            <!-- Filter Form -->
            <div class="card rounded-0 mb-2 shadow">
                <div class="card-body">
                    <fieldset>
                        <legend>Filter</legend>
                        <form action="" id="filter-form">
                            <div class="row align-items-end">
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="date" class="control-label">Choose Date</label>
                                        <input type="date" class="form-control form-control-sm rounded-0" name="date" id="date" value="<?= $date ?>" required="required">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="resident_name" class="control-label">Resident Name</label>
                                        <input type="text" class="form-control form-control-sm rounded-0" name="resident_name" id="resident_name">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-flat btn-primary bg-gradient-primary"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
$recent_record_query = $conn->query("SELECT * FROM `tbl_recognitionlogs` ORDER BY `log_id` DESC LIMIT 1");

if ($recent_record_query) {
    $recent_record = $recent_record_query->fetch_assoc();
    $log_id_value = $recent_record['log_id'];
    $staff = $_settings->userdata('firstname');
    $resident_name = $recent_record['resident_name'];
} else {
    $log_id_value = ""; 
}
?> 
                        <div class="modal-body">
                            <!-- Form for adding a new file -->
                            <!-- Inserting data to table file_report -->
                            <form id="save_reportForm" method="POST">
                                <div class="form-group">
                                    <label for="log_id">Log ID:</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="log_id" value="<?= $log_id_value ?>" name="log_id" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="resident_name">Resident Name:</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="resident_name" value="<?= $resident_name ?>" name="resident_name" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="employee_name">Employee Name:</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo $staff?>" id="employee_name" name="employee_name" required readonly>
                                </div>
                                <div class="form-group">
    <label for="file_mark">File Mark:</label>
    <!-- Display the selected file category dynamically -->
    <input type="text" class="form-control form-control-sm rounded-0" id="file_mark" name="file_mark" required readonly>
</div>
<!-- fetch category count -->
<input type="hidden" name="Residence Certificates" id ="RC" value="RC<?php echo($fileCategoryCounts['Residence Certificates'] ?? 0)+1 ?>">

<input type="hidden" name="Business Permits" id="BP"value="BP<?php echo($fileCategoryCounts['Business Permits'] ?? 0)+1 ?>">

<input type="hidden" name="Community Tax Certificates" id="CTC" value="CTC<?php echo($fileCategoryCounts['Community Tax Certificates'] ?? 0)+1 ?>">

<input type="hidden" name="Complaints and Grievances" id="CG" value="CG<?php echo($fileCategoryCounts['Complaints and Grievances'] ?? 0)+1 ?>">

<input type="hidden" name="Petition Letters" id="PL" value="PL<?php echo($fileCategoryCounts['Petition Letters'] ?? 0)+1 ?>">

<input type="hidden" name="Community Development Proposals" id="CDP" value="CDP<?php echo($fileCategoryCounts['Community Development Proposals'] ?? 0)+1 ?>">

<input type="hidden" name="Barangay Clearance Requests" id="BCR" value="BCR<?php echo($fileCategoryCounts['Barangay Clearance Requests'] ?? 0)+1 ?>">

<input type="hidden" name="Notarized Documents" id="ND" value="ND<?php echo($fileCategoryCounts['Notarized Documents'] ?? 0)+1 ?>">

<input type="hidden" name="Building or Construction Permits" id="BCP" value="BCP<?php echo($fileCategoryCounts['Building or Construction Permits'] ?? 0)+1 ?>">

<input type="hidden" name="Personal Records" id="PR" value="PR<?php echo($fileCategoryCounts['Personal Records'] ?? 0)+1 ?>">

<div class="form-group">
    <label for="file_category">File Category:</label>
    <!-- Add onchange event to trigger the updateFileMark() function -->
    <select class="form-control form-control-sm rounded-0" id="file_category" name="file_category" required onchange="updateFileMark()">
        <option value="Residence Certificates">Residence Certificates</option>
        <option value="Business Permits">Business Permits</option>
        <option value="Community Tax Certificates">Community Tax Certificates</option>
        <option value="Complaints and Grievances">Complaints and Grievances</option>
        <option value="Petition Letters">Petition Letters</option>
        <option value="Community Development Proposals">Community Development Proposals</option>
        <option value="Barangay Clearance Requests">Barangay Clearance Requests</option>
        <option value="Notarized Documents">Notarized Documents</option>
        <option value="Building or Construction Permits">Building or Construction Permits</option>
        <option value="Personal Records">Personal Records</option>
    </select>
</div>

                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
            <div class="card rounded-0 mb-2 shadow">
                <div class="card-header py-1">
                    <div class="card-tools">
                        <!-- Button to trigger the modal -->
                        <button type="button" class="btn btn-flat btn-sm btn-light bg-gradient-primary border text-white" data-toggle="modal" data-target="#addFileModal">
                            Create
                        </button>

                        <button class="btn btn-flat btn-sm btn-light bg-gradient-primary border text-white" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid" id="printout">
                        <table class="table table-bordered">
                            <!-- Table Header -->
                            <colgroup>
                                <col width="10%">
                                <col width="5%">
                                <col width="20%">
                                <col width="15%">
                                <col width="15%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="px-1 py-1 text-center">Report id</th>
                                    <th class="px-1 py-1 text-center">Log id</th>
                                    <th class="px-1 py-1 text-center">Resident name</th>
                                    <th class="px-1 py-1 text-center">Employee name</th>
                                    <th class="px-1 py-1 text-center">File mark</th>
                                    <th class="px-1 py-1 text-center">File category</th>
                                    <th class="px-1 py-1 text-center">Date & Time</th>
                                    <?php if($_settings->userdata('type') == 1): ?>
                                <!-- <th class="px-1 py-1 text-center">Action</th> -->
                                <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Fetching data from the database and populating the table rows
                                $residentName = isset($_GET['resident_name']) ? $_GET['resident_name'] : '';
                                $qry = $conn->query("SELECT * FROM `tbl_report_files` WHERE resident_name LIKE '%$residentName%'");
                                while($row = $qry->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['report_id'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['log_id'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['resident_name'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['employee_name'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['file_mark'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['file_category'] ?></td>
                                    <td class="px-1 py-1 align-middle text-center"><?= $row['Date'] ?></td>
                                    <!-- <?php if($_settings->userdata('type') == 1): ?>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn" data-log-id="<?= 							$row['log_id'] ?>">Delete</button>
                                </td>
                                <?php endif; ?> -->
                                </tr>
                                <?php endwhile; ?>

                            </tbody>
                            <tfoot>
                                <!-- Table Footer -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <noscript>
        <style>
            .page-container {
                display: none;
            }
        </style>
        <div class="noscriptmsg text-center py-5">
            <p>This page requires JavaScript to function properly.</p>
        </div>
    </noscript>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- JavaScript Section -->
    <script>
        // Add this JavaScript code to clear the form fields after reloading the page
        window.onload = function() {
            // Check if the form exists
            var form = document.getElementById("save_reportForm");
            if (form) {
                // Reset the form fields
                form.reset();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Get the form
            var form = document.getElementById("save_reportForm");

            // Store initial form values
            var initialFormValues = {};
            for (var i = 0; i < form.elements.length; i++) {
                var element = form.elements[i];
                if (element.type !== "button" && element.type !== "submit") {
                    initialFormValues[element.name] = element.value;
                }
            }

            // Listen for page refresh event
            window.addEventListener("beforeunload", function(event) {
                // Reset form values if the form has been modified
                for (var i = 0; i < form.elements.length; i++) {
                    var element = form.elements[i];
                    if (element.type !== "button" && element.type !== "submit" && initialFormValues[element.name] !== undefined) {
                        element.value = initialFormValues[element.name];
                    }
                }
            });
        });

        function updateFileMark() {
        // Get the selected option's text
        var selectedCategory = document.getElementById("file_category").value ;

        switch (selectedCategory) {
            case 'Residence Certificates':
                document.getElementById("file_mark").value = document.getElementById("RC").value
                break;
            case 'Business Permits':
                document.getElementById("file_mark").value = document.getElementById("BP").value
                break;
            case 'Community Tax Certificates':
                document.getElementById("file_mark").value = document.getElementById("CTC").value 
                break;
            case 'Complaints and Grievances':
                document.getElementById("file_mark").value = document.getElementById("CG").value 
                break;
            case 'Petition Letters':
                document.getElementById("file_mark").value =  document.getElementById("PL").value 
                break;
            case 'Community Development Proposals':
                document.getElementById("file_mark").value = document.getElementById("CDP").value 
                break;
            case 'Barangay Clearance Requests':
                document.getElementById("file_mark").value = document.getElementById("BCR").value 
                break;
            case 'Notarized Documents':
                document.getElementById("file_mark").value = document.getElementById("ND").value 
                break;
            case 'Building or Construction Permits':
                document.getElementById("file_mark").value = document.getElementById("BCP").value 
                break;
            case 'Personal Records':
                document.getElementById("file_mark").value = document.getElementById("PR").value 
                break;
            // Handle additional cases if needed
            default:
                // Set a default value if the selected category is not recognized
                document.getElementById("file_mark").value = selectedCategory + ' (' + count + ')';
        }

        // Set the selected option's text as the value of the file mark input field
        // document.getElementById("file_mark").value = selectedCategoryData;
    }

    //print
    function print_r(){
        var h = $('head').clone()
        var el = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Daily Logs - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el[0].outerHTML
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(document).ready(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=reports/fileReport&'+$(this).serialize()
        })
        $('#print').click(function(){
            print_r()
        })
        $('.generate').click(function(){
            _conf("Are you sure you want to end today's sale?","generate",[$(this).attr('data-id')])
            console.log($(this).attr('data-id'));
        })

        // Add event listener to delete buttons
        $('.delete-btn').click(function(){
            var logId = $(this).data('log-id');
            if(confirm('Are you sure you want to delete this record?')) {
                // Perform AJAX request to delete the record
                $.post('delete_record.php', {log_id: logId}, function(data){
                    // Handle the response as needed
                    alert(data);
                    // Reload the page after deleting the record
                    location.reload();
                });
            }
        });

    })
    </script>
</body>
</html>
