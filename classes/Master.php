<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tblcategorylist` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `tblcategorylist` set {$data} ";
		}else{
			$sql = "UPDATE `tblcategorylist` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Category successfully saved.";
			else
				$resp['msg'] = " Category successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tblcategorylist` set `delete_flag` = 1 where category_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_menu(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tblmenulist` where `code` = '{$code}' and delete_flag = 0 ".(!empty($id) ? " and menu_id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "$code "."Menu Code already exists.";		
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `tblmenulist` set {$data} ";
			
		}else{
			$sql = "UPDATE `tblmenulist` set {$data} where menu_id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		
		if($save){
			$iid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['iid'] = $iid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Menu successfully saved.";
	
			else
				$resp['msg'] = " Menu successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function save_stock(){
		extract($_POST);
		//check if stocks already exist
		$check = $this->conn->query("SELECT * FROM `tblstocks` WHERE menu_id = '{$menu_id}';")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Stock already exists.";		
			return json_encode($resp);
			exit;
		}
		//end 
		$save = $this->conn->query("INSERT INTO `tblstocks` (`stock_id`, `menu_id`, `amount`) VALUES (NULL, '{$menu_id}', '$qty');");
		if ($qty > 0 )
				{
					$this->conn->query("UPDATE `tblmenulist` set `status` = 1 where menu_id = '{$menu_id}'");
				}
			else {
					$this->conn->query("UPDATE `tblmenulist` set `status` = 0 where menu_id = '{$menu_id}'");
			}
		if($save){
			$iid = !empty($menu_id) ? $menu_id : $this->conn->insert_id;
			$resp['iid'] = $iid;
			$resp['status'] = 'success';
			$resp['msg'] = " Stock successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function update_stock(){
		
			extract($_POST);
			if ($qty > 0 )
				{
					$this->conn->query("UPDATE `tblmenulist` set `status` = 1 where menu_id = '{$menu_id}'");
				}
			else {
					$this->conn->query("UPDATE `tblmenulist` set `status` = 0 where menu_id = '{$menu_id}'");
			}
			$save = $this->conn->query("UPDATE `tblstocks` set `amount` = '$qty' where menu_id = '{$menu_id}'");
			
			if($save){
				$iid = !empty($menu_id) ? $menu_id : $this->conn->insert_id;
				$resp['iid'] = $iid;
				$resp['status'] = 'success';
				$resp['msg'] = " Stock successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			return json_encode($resp);
		
	}
	
	function delete_menu(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tblmenulist` set `delete_flag` = 1 where menu_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Menu successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function place_order(){
		$prefix = date("Ymd");
		$code = sprintf("%'.05d", 1);
		while(true){
			$check = $this->conn->query("SELECT * FROM `tblorderlist` where code = '{$prefix}{$code}'")->num_rows;
			if($check > 0){
				$code = sprintf("%'.05d",abs($code)+ 1);
			}else{
				$_POST['code'] = $prefix.$code;
				$_POST['queue'] = $code;
				break;
			}
		}
		$_POST['user_id'] = $this->settings->userdata('user_id');
		extract($_POST);
		$order_fields = ['code', 'queue', 'total_amount', 'tendered_amount', 'user_id','date_created','date_updated'];
		$data = "";
		foreach($_POST as $k=> $v){
			if(in_array($k, $order_fields) && !is_array($_POST[$k])){
				$v = addslashes(htmlspecialchars($this->conn->real_escape_string($v)));
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		$sql = "INSERT INTO `tblorderlist` set {$data}";
		// $this->conn->query("UPDATE `tblstocks` set `amount` = (amount - 1) where menu_id = '{$menu_id}'");
		$save = $this->conn->query($sql);
		if($save){
			$oid = $this->conn->insert_id;
			$resp['oid'] = $oid;
			$data = '';
			$stock = '';
			foreach($menu_id as $k=>$v){
				if(!empty($data)) $data .= ", ";
				$data .= "('{$oid}', '{$menu_id[$k]}', '{$price[$k]}', '{$quantity[$k]}')";
			}
			foreach($menu_id as $i=>$c){
				$stock .= "UPDATE tblstocks SET amount = (amount - $quantity[$i]) where menu_id = $menu_id[$i]";
				$this->conn->query($stock);
			}
			
			$sql2 = "INSERT INTO `tblorderitems` (`order_id`, `menu_id`, `price`, `quantity`) VALUES {$data}";
			$save2 = $this->conn->query($sql2);
			if($save2){
				$resp['status'] = 'success';
				$resp['msg'] = ' Order has been placed.';
				
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "Order has failed to save due to some reason.";
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql2;
				$this->conn->query("DELETE FROM `tblorderlist` where order_id = '{$oid}'");
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Order has failed to save due to some reason.";
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		return json_encode($resp);
	}
	function delete_order(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tblorderlist` where order_id = '$id'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Order has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function get_order(){
		extract($_POST);
		$swhere = "";
		if(isset($listed) && count($listed) > 0){
			$swhere = " and order_id not in (".implode(",",$listed).")";
		}
		$orders = $this->conn->query("SELECT order_id, `queue` FROM `tblorderlist` where `status` = 0 {$swhere} order by abs(unix_timestamp(date_created)) asc limit 10");
		$data=[];
		while($row = $orders->fetch_assoc()){
			$items = $this->conn->query("SELECT oi.*, concat(m.code, m.name) as `item` FROM `tblorderitems` oi inner join tblmenulist m on oi.menu_id = m.menu_id where order_id = '{$row['order_id']}'");
			$item_arr = [];
			while($irow = $items->fetch_assoc()){
				$item_arr[] = $irow;
			}
			$row['item_arr'] = $item_arr;
			$data[] = $row;
		}
		$resp['status'] = 'success';
		$resp['data'] = $data;
		return json_encode($resp);
	}
	function serve_order(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `tblorderlist` set `status` = 1 where order_id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function generate(){
		extract($_POST);
		$today = date("Y-m-d H:i:s"); 
		$sales = $this->conn->query("INSERT INTO `tblsalesreport` (`sales_id`, `user_id`, `date`, `sales_amount`) VALUES (NULL, '{$this->settings->userdata('user_id')}', current_timestamp(), $id)");
		if($sales){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_fileReport(){
		extract($_POST);
		$stmt = $this->conn->prepare("INSERT INTO tbl_report_files (log_id, resident_name, employee_name, file_mark, file_category) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $log_id, $resident_name, $employee_name, $file_mark, $file_category);
	
		// Execute the statement
		if ($stmt->execute() === TRUE) {
			$response['status'] = 'success';
		} else {
			$response['status'] = 'error';
			$response['msg'] = "Error: " . $stmt->error;
		}
		return json_encode($resp);
	}
		
}
	 

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'generate':
		echo $Master->generate();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_menu':
		echo $Master->save_menu();
	break;
	case 'save_stock':
		echo $Master->save_stock();
	break;
	case 'update_stock':
		echo $Master->update_stock();
	break;
	case 'delete_menu':
		echo $Master->delete_menu();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'delete_order':
		echo $Master->delete_order();
	break;
	case 'get_order':
		echo $Master->get_order();
	break;
	case 'serve_order':
		echo $Master->serve_order();
	break;
	case 'save_fileReport':
		echo $Master->save_fileReport();
	break;
	default:
		// echo $sysset->index();
		break;
}