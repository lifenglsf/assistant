<?php
namespace model;
use lib\tools\SqlHelper;
use model\baseModel;

class Account extends baseModel {
	public $tableMaps = ['account' => 'tb_account'];
	public function __construct($dbm) {
		$this->sql = new SqlHelper($dbm->getConnection());
	}

}