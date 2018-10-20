<?php
/**
 * @author: helei
 * @createTime: 2016-07-15 17:19
 * @description:
 */

// 一下配置均为本人的沙箱环境，贡献出来，大家测试

// 个人沙箱帐号：
/*
 * 商家账号   naacvg9185@sandbox.com
 * appId     2016073100130857
 */

/*
 * !!!作为一个良心人，别乱改测试账号资料
 * 买家账号    aaqlmq0729@sandbox.com
 * 登录密码    111111
 * 支付密码    111111
 */

return [
    'use_sandbox'               => true,// 是否使用沙盒模式

    'app_id'                    => '2016092100562393',
    'sign_type'                 => 'RSA2',// RSA  RSA2

    // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN PUBLIC KEY----- 这种标记
    // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
    'ali_public_key'            => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxNN/H5/Jw8h0hHN46NqI0yglxLwOplyM5AeNDXMHZS36safrUNyNiN9r0fzeX8Bb990Wx0UCtM+Qqz4F9DqxVMgQX6FRXawH3o2Qc7qP0J4xN9LwWlFLAEJGAq0XUi3sLkld9LTwHJEfAW07dRerVO9twIVt94ZodOvSxhruc9Je61JNiqj/8M3cWVhpwQCPNzHe5cGdh3GexJgto/z+MtwytRPt4W4FgIrzV82XhSQJCxEvjOWrqqp+04Ut3ibcZIT/LFYSZTbME8LZUErNlZf5Wi2/DWslwKaWzymWRnn3EWdlqChgy9VzCWkA4Q2ZQPOIKe/FHoRdAmpeWxbKSQIDAQAB',

    // ！！！注意：如果是文件方式，文件中只保留字符串，不要留下 -----BEGIN RSA PRIVATE KEY----- 这种标记
    // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
    'rsa_private_key'           => 'MIIEowIBAAKCAQEAxE/I16ZWASBd5y6NGGNxSP0csSAlo67x1HusAhneejSEVkLR2gA/mEXUSjiJCQ1yGa1xbvmB7Ry5+NaDUNU4gnpXDz5mUl06U0/eHGMOHZT/eDZ0gKkQt9SgCxYLmFH281qUJH7KoXVVmjigXMVw+Ef7wUe3D+2A9hDFrbWVykQIUKJUCx3uaqy8PJ0Uc5BbafMPmmnKbyph5xL7NAiZcrY7MwrrWDo55qabj8NJMhjm3mNYO5/4/kCvTVGTLQrWjdZaW+HI6On0qBRjLI0UUR6nSWBkMjyDaVbymCg/9e9q4gSe/TZwNsCHVDW1YudmtpTupnczSWAwdU+AA9G7ewIDAQABAoIBAD/FDyAGV3/MLNTRSWI3w3ALUMu0/qUaSlJUzj5setnFv4tp71Naq03iuSBXFyTKqlru/Z8oC+2jXEIaJNQYP2AbL7ay9Xgh8rVnh2Y/QzGW2hoJznSQ9u5QcqDHS4LydT7+GIt2aIpkXCdZ57XbKWRttblGe4///dlw/1X7W6o1NuuNKwXiA0I8jLPRct38EvJH5ZuRkc8ScMdde4q+DaUzmjUfHPH7zgIfnqc3APoUqT5tf2E86Tyrmf2Q77TF4bUTfJmrzRA+srshbZHqEACpWsq8kk6nwNt0SvmwvSLRS6wMhi+raN9nikrMPw8XbJL2Y/3bWnp/bwUBGfI6GKECgYEA+TnoXr4x20qoQBMaWHGZRwq9G5nJChLjmLdWcDKJMcIy8cDLw2Lor5OVM++kAbGYWh7CgEfPz3MCkz/H19u0jer+r3fsyLdslT+Z7G5PTyCpr3QXiJh5x74iooSMLEtd7XqnFo2bWjaPC/zUe2lHNc5fpd4I9LDnZwYgOcskg5ECgYEAyaWz1KDCjPu6eNCVhW7dOgeon/EynzxlL9WIrioJ7aH+5hx04ggkAHV2xB+p0SB/vX8tbhZq5OX2CS8ENwjIgNp60ICyrJIsa7Y0vAn9ueaw+rfRqmRCwcl4LTp3QiXwhHhnBJFN/84LS0kQRqU3bvB4QITPWrMk8UF8/g40MEsCgYAMu1yXmnfJkCLQQymRYxxFeNL4Wf7fON/PqW4NBUfk9trLZuIB9UeV0KBKqu9h9sSltfSRwRloq6NyCkwXRu4OYfbo1+OMzXIKndkrLud2T2Dbyb56B/AQuDHkw4i1qpP90co/aLSLA0aDgkMImvQ8V3Kjcphah78KkFGNIkeXQQKBgCDOKnF/LeeN1IpvNMQegzM7p71NmjS5uKSNkszy3eahIj0BiCp1tJW2hnnlxNTW+rEzjYqJbx6KIvrfgUoKzcPYx35AUdEtfriPTgkBfxvNYiGH4j5cTVgFlN2W02wZjAWhKPFfSldBiCjZXCKCIoCT8pxcfvd8iZgOVW1nlin9AoGBALXLYz/7YELvS1cc/79zqX6iS2vx516m1eCUZfDd9hHTFlP9W9OdL6SIrZ1L8QpjHUQOAhEWdc788fyRQywXX0m5ogJTDRKOkobQmTZpMf5qZ1IQhLBDoPcrc37Y9brnapZPRwqcTJYydK9QBHIRWhfU5PCsQxRu1vCoFvrwuR3C',

    'limit_pay'                 => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',// 	借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

    // 与业务相关参数
    'notify_url'                => 'https://helei112g.github.io/v1/notify/ali',
    'return_url'                => 'https://helei112g.github.io/',

    'return_raw'                => false,// 在处理回调时，是否直接返回原始数据，默认为 true
];
