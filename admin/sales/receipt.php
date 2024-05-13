<?php 
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `tblorderlist` where order_id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = htmlspecialchars_decode($v);
        }
    }
    if(isset($user_id)){
        $user = $conn->query("SELECT username FROM `tblusers` where user_id = '{$user_id}'");
        if($user->num_rows > 0){
            $processed_by = $user->fetch_array()[0];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php 
include_once('./../inc/header.php');
?>
<body>

<style>
    html, body{
        width:100% !important;
        min-height:unset !important;
        min-width:unset !important;
    }
</style>

    <div class="style px-2 py-1" line-height="1em">
        <div class="mb-0 text-center font-weight-bolder"><?= $_settings->info('name') ?></div>
        <div class="mb-0 text-center font-weight-bolder">Unofficial Receipt</div>
        <hr>
        <div class="d-flex w-100">
            <div class="col-auto">Transaction Code:</div>
            <div class="col-auto flex-shrink-1 flex-grow-1 pl-2"><?= isset($code) ? $code : '' ?></div>
        </div>
        <div class="d-flex w-100">
            <div class="col-auto">Date & Time:</div>
            <div class="col-auto flex-shrink-1 flex-grow-1 pl-2"><?= isset($date_created) ? date("M, d Y H:i", strtotime($date_created)) : '' ?></div>
        </div>
        <div class="d-flex w-100">
            <div class="col-auto">Processed By:</div>
            <div class="col-auto flex-shrink-1 flex-grow-1 pl-2"><?= isset($processed_by) ? $processed_by : '' ?></div>
        </div>
        <hr>
        <div class="w-100 border-bottom border-dark" style="display:flex">
            <div style="width:15%" class="font-weight-bolder text-center">QTY</div>
            <div style="width:55%" class="font-weight-bolder text-center">Items</div>
            <div style="width:30%" class="font-weight-bolder text-center">Total</div>
        </div>
        <?php if(isset($_GET['id'])): ?>
        <?php 
        $items = $conn->query("SELECT oi.*, concat(m.code,' - ', m.name) as `item` FROM `tblorderitems` oi inner join `tblmenulist` m on oi.menu_id = m.menu_id where oi.order_id = '{$_GET['id']}'");
        //print_r($items);
        while($row = $items->fetch_assoc()):    
        ?>
        <div class="w-100" style="display:flex">
            <div style="width:15%" class="text-center"><?= format_num($row['quantity']) ?></div>
            <div style="width:55%" class="">
                <div style="line-height:1em">
                    <div><?= $row['item'] ?></div>
                    <small class="text-muted">x <?= format_num($row['price'], 2) ?></small>
                </div>
            </div>
            <div style="width:30%" class="text-right"><?= format_num($row['price'] * $row['quantity'], 2) ?></div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
        <div class="border border-dark mb-1"></div>
        <div class="border border-dark"></div>
        <div class="w-100 mb-2" style="display:flex">
            <h5 style="width:70%" class="mb-0 font-weight-bolder">Grand Total</h5>
            <h5 style="width:30%" class="mb-0 font-weight-bolder text-right"><?= isset($total_amount) ? format_num($total_amount, 2) : '0.00' ?></h5>
        </div>
        <div class="w-100 mb-2" style="display:flex">
            <div style="width:70%" class="mb-0 font-weight-bolder">Tendered</div>
            <div style="width:30%" class="mb-0 font-weight-bolder text-right"><?= isset($tendered_amount) ? format_num($tendered_amount, 2) : '0.00' ?></div>
        </div>
        <div class="w-100 mb-2" style="display:flex">
            <div style="width:70%" class="mb-0 font-weight-bolder">Change</div>
            <div style="width:30%" class="mb-0 font-weight-bolder text-right"><?= isset($total_amount) && isset($tendered_amount) ? format_num($tendered_amount - $total_amount, 2) : '0.00' ?></div>
        </div>
        <div class="border border-dark mb-1"></div>
        <div class="py-3">
            <center>
                <div class="font-weight-bolder">Queue #</div>
            </center>
            <h3 class="text-center foont-weight-bolder mb-0"><?= isset($queue) ? $queue : '' ?></h3>
        </div>
        <div class="border border-dark mb-1"></div>
    </div>   
</body>
<script>
    document.querySelector('title').innerHTML = "Unofficial Receipt - Print View"
</script>
</html>