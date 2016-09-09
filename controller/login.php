<?php
if (!defined("ROOT_PATH")) {
	define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
}
include_once realpath(dirname(dirname(__FILE__)) . '/config/config.php');
use lib\tools\HttpRequest;

class Login {
	public function __construct($dbm, $tpl) {
		$this->tpl = $tpl;
		$this->user = new model\Account($dbm);
	}
	public function login() {
		if (HttpRequest::isGet()) {
			$this->tpl->display('login.html');
		} else {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$user = $this->user->get(['username' => ['sname', '=', $username]], $this->user->getTableMaps()['account']);
			if ($user) {
				$opassword = $user['password'];
				if ($password != $opassword) {

					$message = ['error' => 1, 'msg' => '密码错误'];
				} else {
					$message = ['error' => 0, 'msg' => ''];
				}
			} else {
				$message = ['error' => 1, 'msg' => '用户名错误'];
			}
			echo json_encode($message);
		}
	}
}
$method = isset($_GET['m']) ? $_GET['m'] : 'login';
if (empty($method)) {
	die("Method empty");
}
$login = new Login($dbm, $tpl);
if (!method_exists($login, $method)) {
	die("Method of not exists");
}
$login->$method();