<?php

/**
 * @filename Const.class.php
 * @encoding UTF-8
 * @author KangYun@winsan.cn
 * @copyright WinSan.cn
 * @datetime 2015-8-20 10:22:09
 * @version 1.0
 * @Description
 *
 */
namespace common;

class Constant {
	//账户余额状态
	//用户类型：一般用户
	const USER_TYPE_COMMON_USER = 1;
	//用户类型：医生
	const USER_TYPE_DOCTOR = 2;
	const USER_TYPE_PHARMACY = 3; //用户类型:药店
	//账户状态：1正常;2冻结
	const ACCOUNT_AMOUNT_STATE_NORMAL = 0;
	const ACCOUNT_AMOUNT_STATE_LOCKED = 1;
	const COIN_TYPE_HEALTH = 1;

	//提现申请状态：0 未处理 1已提现
	const WITHDRAW_REQUEST_STATE_UNPROCESS = 0;
	const WITHDRAW_REQUEST_STATE_PROCESSING = 1;
	const WITHDRAW_REQUEST_STATE_PROCESSED = 2;
	//充值渠道：1支付宝;2微信;3内部平台
	const FROM_CHANNEL_ALIPAY = 1;
	const FROM_CHANNEL_WEIXIN = 2;
	const FROM_CHANNEL_INNER_PLATFORM = 3;
	//充值状态：0未处理;1渠道成功充值失败;2充值成功;3全部失败;4已退款
	const FILL_CASE_ORDER_STATE_NORMAL = 0;

	const FILL_CASE_ORDER_STATE_CHANNEL_FAILED = 1;
	const FILL_CASE_ORDER_STATE_CHANNEL_ALL_SUCCESS = 2;
	const FILL_CASE_ORDER_STATE_CHANNEL_ALL_FAILED = 3;
	const FILL_CASE_ORDER_STATE_CHANNEL_ALL_REFUND = 4;

	const SUCCESS = 0;

	const BILLING_ERROR = 10030000;
	const ACCOUNT_NOT_EXISTS = 10030001;
	const ACCOUNT_AMOUNT_COIN_TYPE_NOT_EXISTS = 10030002;
	const PT_ID_NOT_EXISTS = 10030011;
	const RECHARGE_LOG_NOT_EXISTS = 10030023;
	const WITHDRAW_AMOUNT_TOO_LARGE = 10030026;
	const FAILED = 10040010;

	static public $maps = array(
		self::SUCCESS => '操作成功',
		self::FAILED => '操作失败',
		self::ACCOUNT_NOT_EXISTS => '账户不存在',
		self::RECHARGE_LOG_NOT_EXISTS => '充值记录不存在',
		self::WITHDRAW_AMOUNT_TOO_LARGE => '提现金额超过申请金额,请修改金额后再提现',
	);
	static public $fillCaseFlowState = array(
		self::FILL_CASE_ORDER_STATE_NORMAL => '未处理',
		self::FILL_CASE_ORDER_STATE_CHANNEL_FAILED => '渠道成功充值失败',
		self::FILL_CASE_ORDER_STATE_CHANNEL_ALL_FAILED => '全部失败',
		self::FILL_CASE_ORDER_STATE_CHANNEL_ALL_REFUND => '已退款',
		self::FILL_CASE_ORDER_STATE_CHANNEL_ALL_SUCCESS => '充值成功',
	);
	static public $fillFromChannel = array(
		self::FROM_CHANNEL_ALIPAY => '支付宝支付',
		self::FROM_CHANNEL_WEIXIN => '微信支付',
		self::FROM_CHANNEL_INNER_PLATFORM => '平台内部支付',
	);

}