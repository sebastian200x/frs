<?php 
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
?>
<div class="content py-5 px-3 bg-gradient-blue">
    <h2>Daily Logs</h2>
</div>
<div class="row flex-column mt-4 justify-content-center align-items-center mt-lg-n4 mt-md-3 mt-sm-0">
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
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
                                    <button class="btn btn-sm btn-flat btn-primary bg-gradient-primary"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-header py-1">
                <div class="card-tools">
                    <button class="btn btn-flat btn-sm btn-light bg-gradient-primary border text-white" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid" id="printout">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="10%">
                            <col width="15%">
                            <col width="20%">
                            <col width="20%">
                            <col width="35%">
                            <col width="5%">

                        </colgroup>
                        <thead>
                            <tr>
                                <th class="px-1 py-1 text-center">Log ID</th>
                                <th class="px-1 py-1 text-center">Staff</th>
                                <th class="px-1 py-1 text-center">Resident Name</th>
                                <th class="px-1 py-1 text-center">Date & Time</th>
                                <th class="px-1 py-1 text-center">confidence_score</th>
                                <?php if($_settings->userdata('type') == 1): ?>
                                <!-- <th class="px-1 py-1 text-center">Action</th> -->
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!isset($conn)) {
                                // If the user is not logged in, redirect them to the login page
                                header("Location: /frs/admin/login.php");
                                exit();
                            }

                            // Fetch data from the database
                            $stock = $conn->query("SELECT * FROM `tbl_recognitionlogs` where date(timestamp) = '{$date}' order by abs(unix_timestamp(timestamp)) asc");
                            while($row = $stock->fetch_assoc()):
                                $user = $conn->query("SELECT username FROM `tblusers` where user_id= '{$row['user_id']}'");
                                $row['processed_by'] = "N/A";
                                if($user->num_rows > 0){
                                    $row['processed_by'] = $user->fetch_array()[0];
                                }
                            ?>
                            <tr>
                                <td class="px-1 py-1 align-middle text-center"><?= $row['log_id'] ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['user_id'] ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['resident_name'] ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['timestamp'] ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['confidence_score'] ?></td>
                                <!-- <?php if($_settings->userdata('type') == 1): ?>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn" data-log-id="<?= $row['log_id'] ?>">Delete</button>
                                </td>
                                <?php endif; ?> -->
                            </tr>
                            <?php endwhile; ?>
                            <?php if($stock->num_rows <= 0): ?>
                                <tr>
                                    <td class="py-1 text-center" colspan="6">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div>
        <style>
            html{
                min-height:unset !important;
            }
        </style>
        <div class="d-flex w-100 align-items-center">
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" style="width: 5em;height: 5em;object-fit:cover;object-position:center center">
            </div>
            <div class="col-8">
                <div style="line-height:1em">
                    <div class="text-center font-weight-bold h5 mb-0"><large><?= $_settings->info('name') ?></large></div>
                    <div class="text-center font-weight-bold h5 mb-0"><large>Daily Logs</large></div>
                    <div class="text-center font-weight-bold h5 mb-0">as of <?= date("F d, Y", strtotime($date)) ?></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</noscript>
<script>
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
            location.href = './?page=reports&'+$(this).serialize()
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
<style>
td{
    text-align:center;
}
</style>
