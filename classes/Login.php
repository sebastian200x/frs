<?php
require_once '../config.php';
class Login extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
	}
	public function login()
	{
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from tblusers where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			foreach ($result->fetch_array() as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_userdata($k, $v);
				}

			}
			$this->settings->set_userdata('login_type', 1);
			//$_SESSION['today'] = date("Y-m-d H:i:s");    
			//$this->conn->query("INSERT INTO `tbluserlogs` (`logs_id`, `user_id`, `time_in`, `time_out`) VALUES (NULL, '{$this->settings->userdata('user_id')}', '{$_SESSION['today']}', NULL);");
			//$this->conn->prepare("INSERT INTO tbluserlogs SET time_in = current_timestamp() where '{$_settings->userdata('user_id')}' ");
			return json_encode(array('status' => 'success'));
		} else {
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * from tblusers where username = '$username' and password = md5('$password') "));
		}

	}
	public function logout()
	{
		// $this->conn->query("UPDATE tbluserlogs set time_out = current_timestamp() where time_in = '{$_SESSION['today']}'");
		if ($this->settings->sess_des()) {
			redirect('admin/login.php');
		}
	}
	function login_customer()
	{
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from customer_list where email = ? and `password` = ? ");
		$password = md5($password);
		$stmt->bind_param('ss', $email, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$res = $result->fetch_array();
			foreach ($res as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('login_type', 2);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function logout_customer()
	{
		if ($this->settings->sess_des()) {
			redirect('?');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'login_customer':
		echo $auth->login_customer();
		break;
	case 'logout_customer':
		echo $auth->logout_customer();
		break;
	default:
		echo $auth->index();
		break;
}

