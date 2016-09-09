<?php
namespace model;
use lib\tools\SqlHelper;
use model\baseModel;

class Member extends baseModel {
	protected $tableMaps = ['member' => 'tb_member', 'identity' => 'tb_element_identity'];
	public function __construct($dbm) {
		global $memberconfig;
		$dbm->addConfig($memberconfig, $memberconfig['database']);
		$pdo = $dbm->getConnection($memberconfig['database']);
		$this->sql = new SqlHelper($pdo);
	}

	public function getList($cond = [], $page = 1, $limit = 0, $table = "") {
		$this->sql->select('m.*,d.scomment');
		$this->sql->found_rows();
		$this->buildCond($cond);
		$this->sql->join($this->tableMaps['identity'] . ' d', 'm.sidtype = d.sid', 'left');
		if (empty($limit)) {
			$query = $this->sql->get($table . ' m');
		} else {
			$query = $this->sql->get($table . ' m', $limit, $page);
		}
		$res = $this->sql->query('SELECT FOUND_ROWS() AS rows_num');
		$row = $res->fetch();

		return ['rows' => $query->fetchAll(), 'count' => $row['rows_num']];
	}
}