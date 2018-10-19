<?php
namespace Logistics;

/**
 * @createTime: 2016-07-14 17:47
 * @description: 快递相关的基础配置
 */
final class Config
{
    //========================= 快递鸟相关接口 =======================//
    // 支付相关常量
    const KDN_CHANNEL_SF = 'SF';// 快递鸟 顺丰速运
    const KDN_CHANNEL_HTKY = 'HTKY';// 快递鸟 百世快递
    const KDN_CHANNEL_ZTO = 'ZTO';// 快递鸟 中通快递
    const KDN_CHANNEL_STO = 'STO';// 快递鸟 申通快递
    const KDN_CHANNEL_YTO = 'YTO';// 快递鸟 圆通速递
    const KDN_CHANNEL_YD = 'YD';// 快递鸟 韵达速递
    const KDN_CHANNEL_YZPY = 'YZPY';// 快递鸟 邮政快递包裹
    const KDN_CHANNEL_EMS = 'EMS';// 快递鸟 EMS
    const KDN_CHANNEL_HHTT = 'HHTT';// 快递鸟 天天快递
    const KDN_CHANNEL_JD = 'JD';// 快递鸟 京东快递
    const KDN_CHANNEL_UC = 'UC';// 快递鸟 优速快递
    const KDN_CHANNEL_DBL = 'DBL';// 快递鸟 德邦快递
    const KDN_CHANNEL_ZJS = 'ZJS';// 快递鸟 宅急送




    //======================= 交易状态常量定义 ======================//
    const TRADE_STATUS_SUCC = 'success';// 交易成功

    const TRADE_STATUS_FAILD  = 'not_pay';// 交易未完成


    //======================= 账户类型 ======================//
    const KDNIAO_WL = 'kdniao';
}
