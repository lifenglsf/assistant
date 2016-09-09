<?php
if (!defined("ROOT_PATH")) {
	define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
}
include_once realpath(dirname(__FILE__) . '/config/config.php');
class Index {
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	public function index() {
		$this->tpl->display('index.html');
	}
}
$method = isset($_GET['m']) ? $_GET['m'] : 'index';
if (empty($method)) {
	die("Method empty");
}
$index = new Index($tpl);
if (!method_exists($index, $method)) {
	die("Method of not exists");
}
$index->$method();