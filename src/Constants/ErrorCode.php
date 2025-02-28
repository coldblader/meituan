<?php

/**
 * Description
 * @authors 寒锋 (huangping@lmmot.com)
 * @date    2025-02-26 15:23:14
 * @version 1.0.0
 */

namespace ColdBlader\MeiTuan\Constants;

class ErrorCode
{
    public const BODY = 1001;

    public const VERIFY_FAIL = 1002;

    public const STOCK = 1003;

    public const VERIFY_SECTION = 1004;

    public const NOT_EXISTS = 1006;

    public const VERIFY_PASS_FAIL = 1007;

    public const VERIFY_EXISTS = 1008;

    public const VERIFICATION_EXPIRE = 1009;

    public const VERIFICATION_REFUND = 1010;

    public const VERIFICATION_APPLY_REFUND = 1011;

    public const VERIFICATION_NOT_VERIFY = 1012;

    public const VERIFICATION_REPEAT = 1013;

    public const STORE_JOIN_OWNER = 1014;

    public const VERIFICATION_NOT_START = 1015;

    public const VERIFICATION_NOT_SYSTEM = 1016;

    public const VERIFY_NOT_NUM = 1017;

    public const VERIFY_NUM = 1018;

    public const NOT_VERIFY_AUTH = 1019;

    public const VERIFY_STORE = 1020;

    public const OPERATION_PEOPLE = 1021;

    public const OPERATION_USER = 1022;

    public const VERIFICATION_TYPE = 1023;

    public const VERIFICATION_ACCOUNT = 1024;

    public const STORE_ACCOUNT = 1025;


    public static $message = [
        self::BODY => '	报文解析失败',
        self::VERIFY_FAIL => '验证失败',
        self::STOCK => '库存不足',
        self::VERIFY_SECTION => '部分验证成功',
        self::NOT_EXISTS => '此券号不存在，请与消费者确认提供的券号是否正确',
        self::VERIFY_PASS_FAIL => '验证密码错误',
        self::VERIFY_EXISTS => '此券码已被验证',
        self::VERIFICATION_EXPIRE => '此团购券已过期',
        self::VERIFICATION_REFUND => '退券中的消费券',
        self::VERIFICATION_APPLY_REFUND => '该券码已申请退款',
        self::VERIFICATION_NOT_VERIFY => '此团购券不可在本店消费，请让消费者打开购买App查看该订单详情页中的可适用商户',
        self::VERIFICATION_REPEAT => '消费券重复',
        self::STORE_JOIN_OWNER => '商家和门店关联错误，烦请联系责任销售进行修改',
        self::VERIFICATION_NOT_START => '团购券有效期未开始',
        self::VERIFICATION_NOT_SYSTEM => '此团购由【第三方】提供，请在【第三方】后台进行验券',
        self::VERIFY_NOT_NUM => '极速验证可验张数不足',
        self::VERIFY_NUM => '请输入正确的验券数量',
        self::NOT_VERIFY_AUTH => '您登录的管理员账号无权验证此团购券,请使用门店账号进行验证',
        self::VERIFY_STORE => '你未选择任何门店进行验证，请选择一个正确的门店',
        self::OPERATION_PEOPLE => '操作人信息不正确，请尝试使用管理员账号重新登录',
        self::OPERATION_USER => '操作人信息不正确，请尝试使用管理员账号重新登录',
        self::VERIFICATION_TYPE => '营销类活动团购券，不能当做正常团购券验证，请与消费者核对团购券信息',
        self::VERIFICATION_ACCOUNT => '当前券码所属用户账号已被冻结，请尝试拨打点评客服电话咨询',
        self::STORE_ACCOUNT => '获取门店账号失败'
        
    ];
}
