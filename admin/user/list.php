<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .user-avatar{
        width:3rem;
        height:3rem;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline rounded-0 card-orange">
    <div class="card-header">
        <h3 class="card-title col-sm-10">List of Users</h3>
        <form method="post">
            <button type="submit" class="btn btn-sm btn-flat btn-primary bg-gradient-primary col-1 listUserbtn" value="listUserbtn" name="listUserbtn">List users</button>
        </form>
    </div>
    
    <!-- This is for user list view -->
    <div class="card-body" id="UserList">
        <div class="container-fluid">
            <table class="table table-hover table-striped table-bordered" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="25%">
                    <col width="15%">
                    <col width="10%">
                    <!-- <col width="15%"> -->
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Updated</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($_POST['listUserbtn'])){
                    $i = 1;
                        $qry = $conn->query("SELECT *, concat(firstname,' ', coalesce(concat(middlename,' '), '') , lastname) as `name` from `tblusers` where user_id != '{$_settings->userdata('id')}' order by concat(firstname,' ', lastname) asc ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_updated'])) ?></td>
                            <td class="text-center">
                                <img src="<?= validate_image($row['avatar']) ?>" alt="" class="img-thumbnail rounded-circle user-avatar">
                            </td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['username'] ?></td>
                            <td class="text-center">
                                <?php if($row['type'] == 1): ?>
                                    Administrator
                                <?php elseif($row['type'] == 2): ?>
                                    Employee
                                <?php elseif($row['type'] == 3): ?>
                                    Employee
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat p-1 btn-default btn-sm" onclick="delete_user_data(<?php echo $row['user_id'] ?>)">
                                    <span class="fa fa-trash text-danger"></span> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function delete_user_data(id) {
        console.log("Deleting user with ID:", id);
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Users.php?f=delete_users",
            method: "POST",
            data: {id: id},
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert_toast("An error occurred while deleting user.", 'error');
                end_loader();
            },
            success: function(resp) {
                console.log("Response:", resp);
                if (resp.trim() === "1") {
                    location.reload(); // Reload page on successful delete
                } else {
                    console.error("Error occurred:", resp);
                    alert_toast("An error occurred while deleting user.", 'error');
                }
                end_loader(); // Always end loader after handling the response
            }
        });
    }
</script>


