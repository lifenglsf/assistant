<?php
namespace model;
class baseModel {
	protected $sql;
	protected $tableMaps;

	public function getTableMaps() {
		return $this->tableMaps;
	}
	/**
	 * 新增数据
	 * @param  string  $table         表名
	 * @param  array   $data          要新增的数据
	 * @param  boolean $get_row_count 是否返回插入的数量
	 * @return fixed                 插入的数量
	 */
	public function insert($data = array(), $get_row_count = false, $table = "") {
		$res = $this->sql->insert($table, $data);
		if ($get_row_count && $res) {
			return $this->sql->conn_id->lastInsertId();
		}
		return $res;
	}

	/**
	 * 获取列表
	 * @param  string  $table 表名
	 * @param  array   $cond  查询条件
	 * @param  integer $page  页数
	 * @param  integer $limit 每页数
	 * @return array         结果
	 */
	public function get($cond = [], $table = "") {
		$this->sql->select('*');
		$this->buildCond($cond);
		$query = $this->sql->get($table);
		return $query->fetch();
	}

	/**
	 * 获取列表
	 * @param  string  $table 表名
	 * @param  array   $cond  查询条件
	 * @param  integer $page  页数
	 * @param  integer $limit 每页数
	 * @return array         结果
	 */
	public function getList($cond = [], $page = 1, $limit = 0, $table = "") {
		$this->sql->select('*');
		$this->sql->found_rows();
		$this->buildCond($cond);
		if (empty($limit)) {
			$query = $this->sql->get($table);
		} else {
			$query = $this->sql->get($table, $limit, $page);
		}
		$res = $this->sql->query('SELECT FOUND_ROWS() AS rows_num');
		$row = $res->fetch();

		return ['rows' => $query->fetchAll(), 'count' => $row['rows_num']];
	}

	/**
	 * 更新数据
	 * @param  string $table  表名
	 * @param  array  $cond   更新条件
	 * @param  array $update 跟新内容
	 * @return [type]         [description]
	 */
	public function update($cond = [], $update, $table = "") {
		$this->buildCond($cond);

		return $this->sql->update($table, $update);
	}

	public function delete($cond = [], $table = "") {
		$this->buildCond($cond);
		return $this->sql->delete($table);
	}

	public function buildCond($cond = []) {
		if (!empty($cond) && (is_array($cond))) {
			foreach ($cond as $k => $v) {
				if (isset($v[2]) && $v[2] !== '') {
					if ($v[1] == '=') {

						$this->sql->where($v[0], $v[2]);
					} elseif ($v[1] == '!=') {
						$this->sql->where($v[0] . $v[1], $v[2]);
					} elseif ($v[1] == '>') {
						$this->sql->where($v[0] . $v[1], $v[2]);
					} elseif ($v[1] == '<') {
						$this->sql->where($v[0] . $v[1], $v[2]);
					} elseif ($v[1] == '>=') {
						$this->sql->where($v[0] . $v[1], $v[2]);
					} elseif ($v[1] == '<=') {
						$this->sql->where($v[0] . $v[1], $v[2]);
					} elseif ($v[1] == 'like') {
						$this->sql->like($v[0], $v[2]);
					} elseif ($v[1] == 'in') {
						$this->sql->where_in($v[0], $v[2]);
					} elseif ($v[1] == "in") {
						if (is_array($v[2])) {
							$this->sql->where_in($v[0], $v[2]);
						} else {
							throw new \Exception('查询条件格式错误' . print_r($cond, true), 1);
						}
					} elseif ($v[1] == "notin") {
						if (is_array($v[2])) {
							$this->sql->where_not_in($v[0], $v[2]);
						} else {
							throw new \Exception('查询条件格式错误' . print_r($cond, true), 1);
						}
					} else {
						throw new \Exception('查询条件格式错误' . print_r($cond, true), 1);
					}
				}
			}
		}
	}
}