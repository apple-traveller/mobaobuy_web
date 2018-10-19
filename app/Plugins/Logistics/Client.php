<?php

namespace Logistics;

/**
 * @createTime: 2016-07-14 17:47
 * @description: 快递相关的基础配置
 */
final class Client
{
    private static $supportChannel = [
        Config::KDNIAO_WL,// 支付宝 APP 支付
    ];

    protected static $instance;

    protected static function getInstance($channel, $config)
    {
        /* 设置内部字符编码为 UTF-8 */
        mb_internal_encoding("UTF-8");

        if (is_null(self::$instance)) {
            static::$instance = new ChargeContext();
        }

        try {
            static::$instance->initCharge($channel, $config);
        } catch (\Exception $e) {
            throw $e;
        }

        return static::$instance;
    }

    public static function run($channel, $config, $metadata)
    {
        if (! in_array($channel, self::$supportChannel)) {
            throw new \Exception('sdk当前不支持该快递查询渠道，当前仅支持：' . implode(',', self::$supportChannel));
        }

        try {
            $instance = self::getInstance($channel, $config);

            $ret = $instance->charge($metadata);
        } catch (\Exception $e) {
            throw $e;
        }

        return $ret;
    }
}
