<?php
if (!defined("ROOT_PATH")) {
	define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
}
include_once realpath(dirname(__FILE__) . '/config/config.php');
use common\Util;

class Member {
	public function __construct($dbm, $tpl) {
		$this->tpl = $tpl;
		$this->member = new model\Member($dbm);
	}

	/**
	 * 用户列表
	 * @return [type] [description]
	 */
	public function index() {
		$filter = [['sname', 'like', isset($_GET['sName']) ? $_GET['sName'] : ''], ['iprovince', '=', isset($_GET['province']) ? $_GET['province'] : ''], ['icity', '=', isset($_GET['city']) ? $_GET['city'] : '']];
		$limit = 15;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$list = $this->member->getList($filter, $page, $limit, $this->member->getTableMaps()['member']);
		/*$province = $this->region->getList(0);
			$city = [];
			if (!empty($_GET['province'])) {
				$city = $this->region->getList($_GET['province']);
			}
			$this->tpl->addParam('province', $province);
		*/
		$p = new \common\Page($list['count'], $limit, '');
		$this->tpl->addParam('rows', $list['rows']);
		$this->tpl->addParam('page', $p->out_page());
		$this->tpl->addParam('url', Util::getURL());
		$this->tpl->display('member/list.html');
	}

	/**
	 * 充值列表
	 * @return [type] [description]
	 */
	public function recharge() {

	}

	/**
	 * 提现列表
	 * @return [type] [description]
	 */
	public function withdraw() {

	}

	/**
	 * 消费列表
	 * @return [type] [description]
	 */
	public function consume() {

	}

	/**
	 * 预约列表
	 * @return [type] [description]
	 */
	public function reserve() {

	}

	/**
	 * 重置密码
	 * @return [type] [description]
	 */
	public function resetPass() {

	}
}
$method = isset($_GET['m']) ? $_GET['m'] : 'index';
if (empty($method)) {
	die("Method empty");
}
$member = new Member($dbm, $tpl);
if (!method_exists($member, $method)) {
	die("Method of not exists");
}
$member->$method();