<?php

namespace common;
use lib\tools\UserToken;
use lib\tools\WshpTokenTicket;

/**
 * 常用工具类
 * author Lee.
 * Last modify $Date: 2012-8-23
 */
class Util {
	static function includeFile($filename) {
		if (file_exists($filename)) {
			require_once $filename;
		} else {
			throw new \Exception($filename . " file not found", 1);

		}
	}
	/**
	 * js 弹窗并且跳转
	 * @param string $_info
	 * @param string $_url
	 * @return js
	 */
	static public function alertLocation($_info, $_url) {
		header("Content-type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	}

	/**
	 * js 弹窗返回
	 * @param string $_info
	 * @return js
	 */
	static public function alertBack($_info) {
		header("Content-type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
		exit();
	}

	/**
	 * 页面跳转
	 * @param string $url
	 * @return js
	 */
	static public function headerUrl($url) {
		if (!empty($url)) {
			echo "<script type='text/javascript'>location.href='{$url}';</script>";
		}

		exit();
	}

	/**
	 * 弹窗关闭
	 * @param string $_info
	 * @return js
	 */
	static public function alertClose($_info) {
		header("Content-type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>alert('$_info');close();</script>";
		exit();
	}

	/**
	 * 弹窗
	 * @param string $_info
	 * @return js
	 */
	static public function alert($_info) {
		header("Content-type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>alert('$_info');</script>";
		exit();
	}

	/**
	 * 系统基本参数上传图片专用
	 * @param string $_path
	 * @return null
	 */
	static public function sysUploadImg($_path) {
		echo '<script type="text/javascript">document.getElementById("logo").value="' . $_path . '";</script>';
		echo '<script type="text/javascript">document.getElementById("pic").src="' . $_path . '";</script>';
		echo '<script type="text/javascript">$("#loginpop1").hide();</script>';
		echo '<script type="text/javascript">$("#bgloginpop2").hide();</script>';
	}

	/**
	 * html过滤
	 * @param array|object $_date
	 * @return string
	 */
	static public function htmlString($_date) {
		if (is_array($_date)) {
			foreach ($_date as $_key => $_value) {
				$_string[$_key] = Tool::htmlString($_value); //递归
			}
		} elseif (is_object($_date)) {
			foreach ($_date as $_key => $_value) {
				$_string->$_key = Tool::htmlString($_value); //递归
			}
		} else {
			$_string = htmlspecialchars($_date);
		}
		return $_string;
	}

	/**
	 * 数据库输入过滤
	 * @param string $_data
	 * @return string
	 */
	static public function mysqlString($_data) {
		$_data = trim($_data);
		return !GPC ? addcslashes($_data) : $_data;
	}

	/**
	 * 清理session
	 */
//    static public function unSession() {
	//        if (session_start()) {
	//            session_destroy();
	//        }
	//    }

	/**
	 * 验证是否为空
	 * @param string $str
	 * @param string $name
	 * @return bool (true or false)
	 */
	static function validateEmpty($str, $name) {
		if (empty($str)) {
			self::alertBack('警告：' . $name . '不能为空！');
		}
	}

	/**
	 * 验证是否相同
	 * @param string $str1
	 * @param string $str2
	 * @param string $alert
	 * @return JS
	 */
	static function validateAll($str1, $str2, $alert) {
		if ($str1 != $str2) {
			self::alertBack('警告：' . $alert);
		}
	}

	/**
	 * 验证ID
	 * @param Number $id
	 * @return JS
	 */
	static function validateId($id) {
		if (empty($id) || !is_numeric($id)) {
			self::alertBack('警告：参数错误！');
		}
	}

	/**
	 * 格式化字符串
	 * @param string $str
	 * @return string
	 */
	static public function formatStr($str) {
		$arr = array(' ', '	', '&', '@', '#', '%', '\'', '"', '\\', '/', '.', ',', '$', '^', '*', '(', ')', '[', ']', '{', '}', '|', '~', '`', '?', '!', ';', ':', '-', '_', '+', '=');
		foreach ($arr as $v) {
			$str = str_replace($v, '', $str);
		}
		return $str;
	}

	/**
	 * 格式化时间
	 * @param int $time 时间戳
	 * @return string
	 */
	static public function formatDate($time = 'default') {
		$date = $time == 'default' ? date('Y-m-d H:i:s', time()) : date('Y-m-d H:i:s', $time);
		return $date;
	}

	/**
	 * 获得真实IP地址
	 * @return string
	 */
	static public function realIp() {
		static $realip = NULL;
		if ($realip !== NULL) {
			return $realip;
		}

		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($arr AS $ip) {
					$ip = trim($ip);
					if ($ip != 'unknown') {
						$realip = $ip;
						break;
					}
				}
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['REMOTE_ADDR'])) {
					$realip = $_SERVER['REMOTE_ADDR'];
				} else {
					$realip = '0.0.0.0';
				}
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('HTTP_CLIENT_IP')) {
				$realip = getenv('HTTP_CLIENT_IP');
			} else {
				$realip = getenv('REMOTE_ADDR');
			}
		}
		preg_match('/[\d\.]{7,15}/', $realip, $onlineip);
		$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
		return $realip;
	}

	/**
	 * 加载 Smarty 模板
	 * @param string $html
	 * @return null;
	 */
	static public function display() {
		global $tpl;
		$html = null;
		$htmlArr = explode('/', $_SERVER[SCRIPT_NAME]);
		$html = str_ireplace('.php', '.html', $htmlArr[count($htmlArr) - 1]);
		$dir = dirname($_SERVER[SCRIPT_NAME]);
		$firstStr = substr($dir, 0, 1);
		$endStr = substr($dir, strlen($dir) - 1, 1);
		if ($firstStr == '/' || $firstStr == '\\') {
			$dir = substr($dir, 1);
		}

		if ($endStr != '/' || $endStr != '\\') {
			$dir = $dir . '/';
		}

		$tpl->display($dir . $html);
	}

	/**
	 * 创建目录
	 * @param string $dir
	 */
	static public function createDir($dir) {
		if (!is_dir($dir)) {
			mkdir($dir, 0777);
		}
	}

	/**
	 * 创建文件（默认为空）
	 * @param unknown_type $filename
	 */
	static public function createFile($filename) {
		if (!is_file($filename)) {
			touch($filename);
		}
	}

	/**
	 * 正确获取变量
	 * @param string $param
	 * @param string $type
	 * @return string
	 */
	static public function getData($param, $type = 'post') {
		$type = strtolower($type);
		if ($type == 'post') {
			return Tool::mysqlString(trim($_POST[$param]));
		} elseif ($type == 'get') {
			return Tool::mysqlString(trim($_GET[$param]));
		}
	}

	/**
	 * 删除文件
	 * @param string $filename
	 */
	static public function delFile($filename) {
		if (file_exists($filename)) {
			unlink($filename);
		}
	}

	/**
	 * 删除目录
	 * @param string $path
	 */
	static public function delDir($path) {
		if (is_dir($path)) {
			rmdir($path);
		}
	}

	/**
	 * 删除目录及地下的全部文件
	 * @param string $dir
	 * @return bool
	 */
	static public function delDirOfAll($dir) {
		//先删除目录下的文件：
		if (is_dir($dir)) {
			$dh = opendir($dir);
			while (!!$file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						self::delDirOfAll($fullpath);
					}
				}
			}
			closedir($dh);
			//删除当前文件夹：
			if (rmdir($dir)) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * 验证登陆
	 */
//    static public function validateLogin() {
	//        if (empty($_SESSION['admin']['user'])) header('Location:/admin/');
	//    }

	/**
	 * 给已经存在的图片添加水印
	 * @param string $file_path
	 * @return bool
	 */
	static public function addMark($file_path) {
		if (file_exists($file_path) && file_exists(MARK)) {
			//求出上传图片的名称后缀
			$ext_name = strtolower(substr($file_path, strrpos($file_path, '.'), strlen($file_path)));
			//$new_name='jzy_' . time() . rand(1000,9999) . $ext_name ;
			$store_path = ROOT_PATH . UPDIR;
			//求上传图片高宽
			$imginfo = getimagesize($file_path);
			$width = $imginfo[0];
			$height = $imginfo[1];
			//添加图片水印
			switch ($ext_name) {
			case '.gif':
				$dst_im = imagecreatefromgif($file_path);
				break;
			case '.jpg':
				$dst_im = imagecreatefromjpeg($file_path);
				break;
			case '.png':
				$dst_im = imagecreatefrompng($file_path);
				break;
			}
			$src_im = imagecreatefrompng(MARK);
			//求水印图片高宽
			$src_imginfo = getimagesize(MARK);
			$src_width = $src_imginfo[0];
			$src_height = $src_imginfo[1];
			//求出水印图片的实际生成位置
			$src_x = $width - $src_width - 10;
			$src_y = $height - $src_height - 10;
			//新建一个真彩色图像
			$nimage = imagecreatetruecolor($width, $height);
			//拷贝上传图片到真彩图像
			imagecopy($nimage, $dst_im, 0, 0, 0, 0, $width, $height);
			//按坐标位置拷贝水印图片到真彩图像上
			imagecopy($nimage, $src_im, $src_x, $src_y, 0, 0, $src_width, $src_height);
			//分情况输出生成后的水印图片
			switch ($ext_name) {
			case '.gif':
				imagegif($nimage, $file_path);
				break;
			case '.jpg':
				imagejpeg($nimage, $file_path);
				break;
			case '.png':
				imagepng($nimage, $file_path);
				break;
			}
			//释放资源
			imagedestroy($dst_im);
			imagedestroy($src_im);
			unset($imginfo);
			unset($src_imginfo);
			//移动生成后的图片
			@move_uploaded_file($file_path, ROOT_PATH . UPDIR . $file_path);
		}
	}

	/**
	 *  中文截取2，单字节截取模式
	 * @access public
	 * @param string $str  需要截取的字符串
	 * @param int $slen  截取的长度
	 * @param int $startdd  开始标记处
	 * @return string
	 */
	static public function cn_substr($str, $slen, $startdd = 0) {
		$cfg_soft_lang = PAGECHARSET;
		if ($cfg_soft_lang == 'utf-8') {
			return self::cn_substr_utf8($str, $slen, $startdd);
		}
		$restr = '';
		$c = '';
		$str_len = strlen($str);
		if ($str_len < $startdd + 1) {
			return '';
		}
		if ($str_len < $startdd + $slen || $slen == 0) {
			$slen = $str_len - $startdd;
		}
		$enddd = $startdd + $slen - 1;
		for ($i = 0; $i < $str_len; $i++) {
			if ($startdd == 0) {
				$restr .= $c;
			} elseif ($i > $startdd) {
				$restr .= $c;
			}
			if (ord($str[$i]) > 0x80) {
				if ($str_len > $i + 1) {
					$c = $str[$i] . $str[$i + 1];
				}
				$i++;
			} else {
				$c = $str[$i];
			}
			if ($i >= $enddd) {
				if (strlen($restr) + strlen($c) > $slen) {
					break;
				} else {
					$restr .= $c;
					break;
				}
			}
		}
		return $restr;
	}

	/**
	 *  utf-8中文截取，单字节截取模式
	 *
	 * @access public
	 * @param string $str 需要截取的字符串
	 * @param int $slen 截取的长度
	 * @param int $startdd 开始标记处
	 * @return string
	 */
	static public function cn_substr_utf8($str, $length, $start = 0) {
		if (strlen($str) < $start + 1) {
			return '';
		}
		preg_match_all("/./su", $str, $ar);
		$str = '';
		$tstr = '';
		//为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
		for ($i = 0;isset($ar[0][$i]); $i++) {
			if (strlen($tstr) < $start) {
				$tstr .= $ar[0][$i];
			} else {
				if (strlen($str) < $length + strlen($ar[0][$i])) {
					$str .= $ar[0][$i];
				} else {
					break;
				}
			}
		}
		return $str;
	}

	/**
	 * 删除图片，根据图片ID
	 * @param int $image_id
	 */
	static function delPicByImageId($image_id) {
		$db_name = PREFIX . 'images i';
		$m = new Model();
		$data = $m->getOne($db_name, "i.id={$image_id}", "i.path as p, i.big_img as b, i.small_img as s");
		foreach ($data as $v) {
			@self::delFile(ROOT_PATH . $v['p']);
			@self::delFile(ROOT_PATH . $v['b']);
			@self::delFile(ROOT_PATH . $v['s']);
		}
		$m->del(PREFIX . 'images', "id={$image_id}");
		unset($m);
	}

	/**
	 * 图片等比例缩放
	 * @param resource $im    新建图片资源(imagecreatefromjpeg/imagecreatefrompng/imagecreatefromgif)
	 * @param int $maxwidth   生成图像宽
	 * @param int $maxheight  生成图像高
	 * @param string $name    生成图像名称
	 * @param string $filetype文件类型(.jpg/.gif/.png)
	 */
	static public function resizeImage($im, $maxwidth, $maxheight, $name, $filetype) {
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
			if ($maxwidth && $pic_width > $maxwidth) {
				$widthratio = $maxwidth / $pic_width;
				$resizewidth_tag = true;
			}
			if ($maxheight && $pic_height > $maxheight) {
				$heightratio = $maxheight / $pic_height;
				$resizeheight_tag = true;
			}
			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio) {
					$ratio = $widthratio;
				} else {
					$ratio = $heightratio;
				}
			}
			if ($resizewidth_tag && !$resizeheight_tag) {
				$ratio = $widthratio;
			}

			if ($resizeheight_tag && !$resizewidth_tag) {
				$ratio = $heightratio;
			}

			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
			if (function_exists("imagecopyresampled")) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}
			$name = $name . $filetype;
			imagejpeg($newim, $name);
			imagedestroy($newim);
		} else {
			$name = $name . $filetype;
			imagejpeg($im, $name);
		}
	}

	/**
	 * 下载文件
	 * @param string $file_path 绝对路径
	 */
	static public function downFile($file_path) {
		//判断文件是否存在
		$file_path = iconv('utf-8', 'gb2312', $file_path); //对可能出现的中文名称进行转码
		if (!file_exists($file_path)) {
			exit('文件不存在！');
		}
		$file_name = basename($file_path); //获取文件名称
		$file_size = filesize($file_path); //获取文件大小
		$fp = fopen($file_path, 'r'); //以只读的方式打开文件
		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: {$file_size}");
		header("Content-Disposition: attachment;filename={$file_name}");
		$buffer = 1024;
		$file_count = 0;
		//判断文件是否结束
		while (!feof($fp) && ($file_size - $file_count > 0)) {
			$file_data = fread($fp, $buffer);
			$file_count += $buffer;
			echo $file_data;
		}
		fclose($fp); //关闭文件
	}

	static public function uploadImage($name = 'upfile') {
		// 图片处理
		$file_type = $_FILES[$name]['type'];
		$file_name = $_FILES[$name]['name'];
		$file_size = $_FILES[$name]['size'];
		$fp = fopen($_FILES[$name]['tmp_name'], "rb");

		$ext = "";

		switch ($file_type) {
		case "image/gif":
			$ext = ".gif";
			break;
		case "image/jpeg":
			$ext = ".jpg";
			break;
		case "image/pjpeg":
			$ext = ".jpg";
			break;
		case "image/png":
			$ext = ".png";
			break;
		}
		$url = "";
		$appname = "";
		$appkey = "";
		$uploadconfig = $GLOBALS['UPLOADCONFIG'];
		// config 中配置此变量
		if (!empty($uploadconfig)) {
			$url = $uploadconfig['url'];
			$appname = $uploadconfig['appname'];
			$appkey = $uploadconfig['appkey'];
		} else {
			$url = 'http://upload.game.qidian.com/upload.php';
			$appname = 'gamesy';
			$appkey = '2aa03f61b4aa0ea5f1882f2c0774899c';
		}

		$file_data = file_get_contents($_FILES[$name]['tmp_name']);
		$t = time();
		$source = $appname . $ext . $t . base64_encode($file_data) . $appkey;
		$sign = strtolower(md5($source));

		$header = array(
			'APPNAME: ' . $appname,
			'FILEEXT: ' . $ext,
			'TS: ' . $t,
			'SIGN: ' . $sign,
		);

		$postUrl = $url;
		$ch = curl_init(); //初始化curl
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //构造IP
		curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); //timeout on connect
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout on response
		curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);

		$data = curl_exec($ch); //运行curl
		curl_close($ch);

		$data = json_decode($data, 1);

		return $data;
	}

	/**
	 * 获取当前base64编码后URL
	 * @param bool $is_coding 是否需要编码
	 * @return string url地址
	 */
	static function getURL($is_encoding = true) {
		$url = 'http://' . $_SERVER['SERVER_NAME'];
		$url .= ($_SERVER["SERVER_PORT"] == '80' || $_SERVER["SERVER_PORT"] == '443') ? '' : ':' . $_SERVER["SERVER_PORT"];
		$url .= $_SERVER["REQUEST_URI"];
		return $is_encoding ? base64_encode($url) : $url;
	}

	/**
	 * base64解码url
	 * @param string $url 需解码url
	 * @return string url地址
	 */
	static function DeURL($url) {
		if (empty($url)) {
			return NULL;
		}
		return base64_decode($url);
	}

	static function uploadFile($file, $save_path = '/image/files/', $save_name = '', $ext_type = 'image', $max_size = 2097152) {
		$save_path = ROOT_PATH . $save_path . $ext_type;
		$save_url = '/image/files/' . $ext_type . '/';
		//定义允许上传的文件扩展名
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		$save_path = realpath($save_path) . '/';
		//logs_messages('upload_file', $save_path);
		//PHP上传失败
		if (!empty($_FILES[$file]['error'])) {
			switch ($_FILES[$file]['error']) {
			case '1':
				$error = '超过php.ini允许的大小。';
				break;
			case '2':
				$error = '超过表单允许的大小。';
				break;
			case '3':
				$error = '图片只有部分被上传。';
				break;
			case '4':
				return -1;
				break;
			case '6':
				$error = '找不到临时目录。';
				break;
			case '7':
				$error = '写文件到硬盘出错。';
				break;
			case '8':
				$error = '扩展未开启';
				break;
			case '999':
			default:
				$error = '未知错误。';
			}
			logs_messages('upload_file.log', $error);
			self::alert($error);
		}

		//有上传文件时
		if (empty($_FILES) === false) {
			//原文件名
			$file_name = $_FILES[$file]['name'];
			//服务器上临时文件名
			$tmp_name = $_FILES[$file]['tmp_name'];
			//文件大小
			$file_size = $_FILES[$file]['size'];
			//检查文件名
			if (!$file_name) {
				return -1;
			}
			//检查目录
			if (@is_dir($save_path) === false) {
				self::alert("上传目录不存在。");
			}
			//检查目录写权限
			if (@is_writable($save_path) === false) {
				self::alert("Directory don\'t writter。($save_path)");
			}
			//检查是否已上传
			if (@is_uploaded_file($tmp_name) === false) {
				self::alert("upload failed。");
			}
			//检查文件大小
			if ($file_size > $max_size) {
				self::alert("Allowed max size: 2M。");
			}
			//检查目录名
			$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
			if (empty($ext_arr[$dir_name])) {
				self::alert("Directory Incorrect");
			}
			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
				self::alert(" No allowed extension(extension: {$file_ext}),只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
			}
			//创建文件夹
			if ($dir_name !== '') {
				// $save_path .= $dir_name . "/";
				// $save_url .= $dir_name . "/";
				if (!file_exists($save_path)) {
					mkdir($save_path);
				}
			}
			$ymd = date("Ym");
			$save_path .= $ymd . "/";
			$save_url .= $ymd . "/";
			if (!file_exists($save_path)) {
				mkdir($save_path);
			}
			//新文件名
			if (empty($save_name)) {
				$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
			} else {
				$new_file_name = $save_name . '.' . $file_ext;
			}

			//移动文件
			$file_path = $save_path . $new_file_name;
			if (move_uploaded_file($tmp_name, $file_path) === false) {
				self::alert("上传文件失败。");
			}
			@chmod($file_path, 0644);
			$file_url = $save_url . $new_file_name;

			return $file_url;
		}
	}

	public static function logs() {
		$a = func_get_args();
		if (count($a) == 1) {
			$msg = $a[0];
		} else {
			$format = array_shift($a);
			if (is_array($a[0])) {
				$a = $a[0];
			}
			$msg = vsprintf($format, $a);
		}

		$path = ROOT_PATH . 'log/';
		$filename = $path . date('Y-m-d') . '.log';
		return file_put_contents($filename, date('[Y-m-d H:i:s]') . $msg . "\n", FILE_APPEND | LOCK_EX);
	}

	static public function getIP() {
		if (getenv('HTTP_CLIENT_IP')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('REMOTE_ADDR')) {
			$onlineip = getenv('REMOTE_ADDR');
		} else {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		return $onlineip;
	}

	static public function getCache() {
		global $cookie;
		$cookie_str = $cookie->get(UserToken::$cookiename);
		$ticket = new WshpTokenTicket();
		$obj = $ticket->decrypt($cookie_str, TRUE);
		if (empty($obj->UserData)) {
			return NULL;
		}
		$user = json_decode($obj->UserData, TRUE);
		return $user;
	}

	/**
	 * 判断是否为图片文件
	 * @param $image
	 * @return bool
	 */
	static public function isImage($image) {
		$info = getimagesize($image);
		$ext = $info[2];
		$accept = array('gif', 'jpg', 'jpeg', 'png');
		$ext = image_type_to_extension($ext, false);
		if (in_array($ext, $accept)) {
			return true;
		}
		return false;
	}

	/**
	 * 转义 $_POST $_GET $COOKIE 值
	 * @param mixed $value
	 * @return mixed
	 */
	function filterValue($value) {
		$value = is_array($value) ? array_map('filterValue', $value) : addslashes($value);
		return $value;
	}

	/**
	 * 验证是否为正整数
	 * @param $int
	 * @return bool
	 */
	static public function validatorPositiveInteger($int) {
		$regx = '/^[1-9]\d*$/';
		if (preg_match($regx, $int)) {
			return TRUE;
		}
		return FALSE;
	}
}
