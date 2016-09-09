<?php
namespace common;

class Page {
	private $total_rows; //数据库总条数
	private $per_page_rows; //每页显示条数
	private $limit;
	private $uri;
	private $total_pages; //总页数
	private $config = array("header" => "记录条数", "prev" => "上一页", "next" => "下一页", "first" => "首 页", "last" => "尾 页");
	private $list_length = 8;
	public function __construct($total_rows, $per_page_rows = 10, $url_args='') {
		$this->total_rows = $total_rows;
		$this->per_page_rows = $per_page_rows;
		$this->uri = $this->get_uri($url_args);
        $this->total_pages = ceil($this->total_rows / $this->per_page_rows);
        $this->page = !empty($_GET['page']) ? ($_GET['page'] > $this->total_pages ? $this->total_pages : $_GET['page'] ) : 1;
		$this->limit = $this->set_limit();
	}
	private function set_limit() {
		return "limit " . ($this->page - 1) * $this->per_page_rows . ",{$this->per_page_rows}";
	}
	private function get_uri($url_args) {
		$url = $_SERVER["REQUEST_URI"] . (strpos($_SERVER["REQUEST_URI"], "?") ? "" : "?") . $url_args;
		$parse = parse_url($url);
		if (isset($parse['query'])) {
			parse_str($parse['query'], $params); //把url字符串解析为数组
			unset($params['page']); //删除数组下标为page的值
			$url = $parse['path'] . '?' . http_build_query($params); //再次构建url
		}
		return $url;
	}
	public function __get($args) {
		if ($args == "limit") {
			return $this->limit;
		} else {
			return null;
		}
	}
	private function start_page() {
		if ($this->total_rows == 0) {
			return 0;
		} else {
			return (($this->page - 1) * $this->per_page_rows) + 1;
		}
	}
	private function end_page() {
		return min($this->page * $this->per_page_rows, $this->total_rows);
	}
	private function go_first() {
		$html = "";
		if ($this->page == 1) {
			$html .= "&nbsp;{$this->config['first']}&nbsp;";
		} else {
			$html .= "&nbsp;<a href='{$this->uri}&page=1'>{$this->config['first']}</a>&nbsp;";
		}
		return $html;
	}
	private function go_prev() {
		$html = "";
		if ($this->page == 1) {
			$html .= "&nbsp;{$this->config['prev']}&nbsp;";
		} else {
			$page = $this->page - 1;
			$html .= "&nbsp;<a href='{$this->uri}&page={$page}'>{$this->config['prev']}</a>&nbsp;";
		}
		return $html;
	}
	private function go_next() {
		$html = "";
		if ($this->page == $this->total_pages) {
			$html .= "&nbsp;{$this->config['next']}&nbsp;";
		} else {
			$page = $this->page + 1;
			$html .= "&nbsp;<a href='{$this->uri}&page={$page}'>{$this->config['next']}</a>&nbsp;";
		}
		return $html;
	}
	private function go_last() {
		$html = "";
		if ($this->page == $this->total_pages) {
			$html .= "&nbsp;{$this->config['last']}&nbsp;";
		} else {
			$html .= "&nbsp;<a href='{$this->uri}&page={$this->total_pages}'>{$this->config['last']}</a>&nbsp;";
		}
		return $html;
	}
	private function go_page() {
		return '&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>' . $this->total_pages . ')?' . $this->total_pages . ':this.value;location=\'' . $this->uri . '&page=\'+page+\'\'}" value="' . $this->page . '" style="width:25px; text-align:center" />&nbsp;<input type="button" onclick="javascript: var prev=this.previousSibling;while(prev && prev.nodeType != 1){prev = prev.previousSibling};;var page=(prev.value >' . $this->total_pages . ')?' . $this->total_pages . ': prev.value;location=\'' . $this->uri . '&page=\'+page+\'\';" value="GO" />&nbsp;';
	}
	private function page_list() {
		$link_page = "";
		$i_num = floor($this->list_length / 2);
		for ($i = $i_num; $i >= 1; $i--) {
			$page = $this->page - $i;
			if ($page < 1) {
				continue;
			} else {
				$link_page .= "&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
			}
		}
		$link_page .= "&nbsp;{$this->page}&nbsp;";
		for ($i = 1; $i < $i_num; $i++) {
			$page = $this->page + $i;
			if ($page <= $this->total_pages) {
				$link_page .= "&nbsp;<a href='{$this->uri}&page={$page}'>{$page}</a>&nbsp;";
			} else {
				break;
			}
		}
		return $link_page;
	}
	public function out_page($display = array(3, 4, 5, 6, 7, 8)) {
		$display_html = '';
		$html[0] = "&nbsp;共有<b>{$this->total_rows}</b>{$this->config['header']}&nbsp;";
		$html[1] = "&nbsp;每页显示<b>" . ($this->end_page() - $this->start_page() + 1) . "</b>条,本页显示从<b>{$this->start_page()}</b>--<b>{$this->end_page()}</b>{$this->config['header']}&nbsp;";
		$html[2] = "&nbsp;<b>{$this->page}</b>/<b>{$this->total_pages}</b>页&nbsp;";
		$html[3] = $this->go_first();
		$html[4] = $this->go_prev();
		$html[5] = $this->page_list();
		$html[6] = $this->go_next();
		$html[7] = $this->go_last();
		$html[8] = $this->go_page();
		foreach ($display as $index) {
			$display_html .= $html[$index];
		}
		if ($this->total_pages > 1) {
			return $display_html;
		} else {return "";}
	}
}
?>
