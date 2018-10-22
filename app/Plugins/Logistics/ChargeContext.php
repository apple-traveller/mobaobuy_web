<?php

namespace Logistics;

use Logistics\Charge\KDNiao\KDNiaoCharge;

/**
 * @author: helei
 * @createTime: 2016-07-14 17:42
 * @description: 支付上下文
 * @link      https://www.gitbook.com/book/helei112g1/payment-sdk/details
 * @link      https://helei112g.github.io/
 *
 * Class ChargeContext
 *
 * 支付的上下文类
 *
 * @package Payment
 */
class ChargeContext
{
    /**
     * 支付的渠道
     * @var BaseStrategy
     */
    protected $channel;


    /**
     * 设置对应的支付渠道
     * @param string $channel 支付渠道
     *  - @see Config
     * @param array $config 配置文件
     * @throws PayException
     * @author helei
     */
    public function initCharge($channel, array $config)
    {
        // 初始化时，可能抛出异常，再次统一再抛出给客户端进行处理
        try {
            switch ($channel) {
                case Config::KDNIAO_WL:
                    $this->channel = new KDNiaoCharge($config);
                    break;

                default:
                    throw new \Exception('当前仅支持：支付宝  微信 招商一网通');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function charge(array $data)
    {
        /*if (! $this->channel instanceof BaseStrategy) {
            throw new PayException('请检查初始化是否正确');
        }*/

        try {
            return $this->channel->handle($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
