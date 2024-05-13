<?php
require_once('../config.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users() {
		if(!empty($_POST['password'])) {
			$_POST['password'] = md5($_POST['password']); // Hash the password
		}
	
		// Check if username already exists
		$check_query = $this->conn->prepare("SELECT username FROM tblusers WHERE username = ?");
		$check_query->bind_param("s", $username);
		$username = $_POST['username'];
		$check_query->execute();
		$check_query->store_result();
		if($check_query->num_rows > 0) {
			return 0; // Username already exists, abort saving
		}
	
		$data = '';
		foreach($_POST as $k => $v) {
			if($k !== 'id' && $k !== 'password') {
				if(!empty($data)) $data .= ", ";
				$data .= "$k = ?";
			}
		}
	
		if(empty($id)) {
			$qry = $this->conn->prepare("INSERT INTO tblusers SET $data");
		} else {
			$qry = $this->conn->prepare("UPDATE tblusers SET $data WHERE id = ?");
			$qry->bind_param("i", $id);
		}
	
		$types = '';
		$values = [];
		foreach ($_POST as $k => $v) {
			if($k !== 'user_id' && $k !== 'password') {
				$types .= 's'; // Assuming all values are strings
				$values[] = &$v;
			}
		}
		if(!empty($id)) {
			$types .= 'i'; // Append 'i' for integer type
			$values[] = &$id;
		}
		$qry->bind_param($types, ...$values);
	
		if($qry->execute()) {
			$this->settings->set_flashdata('success', 'User details successfully ' . (empty($id) ? 'saved' : 'updated'));
			if(!empty($_POST['id'])) {
				foreach($_POST as $k => $v) {
					if($k !== 'id') {
						if($this->settings->userdata('user_id') == $_POST['id']) {
							$this->settings->set_userdata($k, $v);
						}
					}
				}
			}
	
			// Upload avatar image
			if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
				$avatar_name = $_FILES['avatar']['name'];
				$avatar_tmp_name = $_FILES['avatar']['tmp_name'];
				$avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
				$avatar_new_name = uniqid() . '.' . $avatar_extension; // Generate unique name to prevent overwriting
	
				$upload_directory = 'avatar/'; // Directory to upload avatars
				$upload_path = $upload_directory . $avatar_new_name;
	
				if(move_uploaded_file($avatar_tmp_name, $upload_path)) {
					// Update avatar column in the database
					$update_avatar_query = $this->conn->prepare("UPDATE tblusers SET avatar = ? WHERE id = ?");
					$update_avatar_query->bind_param("si", $upload_path, $id);
					$update_avatar_query->execute();
				}
			}
	
			return 1;
		} else {
			return 2; // Error in inserting/updating user details
		}
	}

	public function update_user() {
    // Check if user ID is provided
    if(empty($_POST['id'])) {
        return 0; // User ID not provided
    }
    
    $id = $_POST['id'];

    // Check if username already exists (except for the current user)
    $check_query = $this->conn->prepare("SELECT user_id FROM tblusers WHERE username = ? AND user_id != ?");
    $check_query->bind_param("si", $username, $id);
    $username = $_POST['username'];
    $check_query->execute();
    $check_query->store_result();
    if($check_query->num_rows > 0) {
        return -1; // Username already exists for another user
    }

    // Prepare UPDATE query
    $update_data = '';
    $values = [];
    foreach($_POST as $k => $v) {
        if($k !== 'id') {
            if(!empty($update_data)) $update_data .= ", ";
            if($k === 'password') {
                // If password is provided, hash it and include it in the update query
                if(!empty($v)) {
                    $update_data .= "$k = ?";
                    $v = md5($v); // Hash the password
                    $values[] = $v;
                }
            } else {
                $update_data .= "$k = ?";
                $values[] = $v;
            }
        }
    }

    // Bind parameters dynamically
    $types = str_repeat('s', count($values)); // Assuming all values are strings
    $types .= 'i'; // Append 'i' for integer type
    $values[] = $id; // Add user ID to values array

    $update_query = $this->conn->prepare("UPDATE tblusers SET $update_data WHERE user_id = ?");
    $update_query->bind_param($types, ...$values);

    if($update_query->execute()) {
        return 1; // Success
    } else {
        error_log("Error updating user details"); // Log error
        return 2; // Error in updating user details
    }
}

	
	
	
	
	
	
	
 function delete_users() {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $qry = $this->conn->query("DELETE FROM tblusers WHERE user_id = '$id'");
        if ($qry) {
            $this->settings->set_flashdata('success', 'User details successfully deleted.');
            if (is_file(base_app . "uploads/avatars/$id.png")) {
                unlink(base_app . "uploads/avatars/$id.png");
            }
            echo 1; // Successful deletion
        } else {
            echo "Error: " . $this->conn->error;
        }
    } else {
        echo "ID parameter is missing.";
    }
}







	function registration(){
		if(!empty($_POST['password']))
			$_POST['password'] = md5($_POST['password']);
		else
		unset($_POST['password']);
		extract($_POST);
		$main_field = ['firstname', 'middlename', 'lastname', 'gender', 'contact', 'email', 'status', 'password'];
		$data = "";
		$check = $this->conn->query("SELECT * FROM `customer_list` where email = '{$email}' ".($id > 0 ? " and id!='{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Email already exists.';
			return json_encode($resp);
		}
		foreach($_POST as $k => $v){
			$v = $this->conn->real_escape_string($v);
			if(in_array($k, $main_field)){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `customer_list` set {$data} ";
		}else{
			$sql = "UPDATE `customer_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$uid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['uid'] = $uid;
			if(!empty($id))
				$resp['msg'] = 'User Details has been updated successfully';
			else
				$resp['msg'] = 'Your Account has been created successfully';

			if(!empty($_FILES['img']['tmp_name'])){
				if(!is_dir(base_app."uploads/customers"))
					mkdir(base_app."uploads/customers");
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = "uploads/customers/$uid.png";
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] = "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] = "Image is invalid";
				}
				$temp = imagescale($uploadfile,200,200);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname);
				if($upload){
					$this->conn->query("UPDATE `customer_list` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$uid}'");
				}
				imagedestroy($temp);
			}
			if(!empty($uid) && $this->settings->userdata('login_type') != 1){
				$user = $this->conn->query("SELECT * FROM `customer_list` where id = '{$uid}' ");
				if($user->num_rows > 0){
					$res = $user->fetch_array();
					foreach($res as $k => $v){
						if(!is_numeric($k) && $k != 'password'){
							$this->settings->set_userdata($k, $v);
						}
					}
					$this->settings->set_userdata('login_type', '2');
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success' && isset($resp['msg']))
		$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	public function delete_customer(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM customer_list where id = $id");
		$qry = $this->conn->query("DELETE FROM customer_list where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Customer Details has been deleted successfully.');
			$resp['status'] = 'success';
			if($avatar->num_rows > 0){
				$avatar = explode("?", $avatar->fetch_array()[0])[0];
				if(is_file(base_app.$avatar)){
					unlink(base_app.$avatar);
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}

		return json_encode($resp);
	}

	
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	case 'delete_user_data':
		echo $users->delete_user_data();
	break;
	case 'registration':
		echo $users->registration();
	break;
	case 'delete_customer':
		echo $users->delete_customer();
	break;
	case 'update_user':
		echo $users->update_user();
	break;
	default:
		// echo $sysset->index();
		break;
}