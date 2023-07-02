# 新大陆支付 PHP插件

## 插件安装

~~~
composer require oyta/starpos
~~~

## 插件引入

~~~
use Oyta\Starpos\Charge;
~~~

## 公共引入方法

~~~
$charge = new Charge();
~~~

## 基本配置设置方法

~~~
$mchid = ' '; //商户号
$key = ' '; //密钥
$trmno = ' '; //设备号
$charge->setconfig($mchid,$trmno,$key);
~~~

## 商户主扫
~~~
$data = [
    'amount'=>'', //实付金额 以分为单位，如1元表示为100
    'authCode'=>'', //扫码支付授权码，设备读取用户微信或支付宝中的条码或者二维码信息
    'payChannel'=>'', //支付渠道 支付宝 ALIPAY  微信 WXPAY 银联 YLPAY
    'selOrderNo'=>'', //订单号
];
return $charge->merchantscan($data);
~~~

## 客户主扫(聚合码扫码支付)
~~~
$data = [
    'amount'=>'', //实付金额 以分为单位，如1元表示为100
    'payChannel'=>'ALIPAY', //支付渠道 支付宝 ALIPAY 银联 YLPAY
    'selOrderNo'=>'', //订单号
];
return $charge->customerscan($data);
~~~


## 微信公众号绑定查询
~~~
$charge->wechatquery();
~~~

## 微信公众号支付
~~~
$data = [
    'amount'=>'',   //订单金额 以分为单位，如1元表示为100
    'appid'=>'',     //微信公众号APPID
    'openid'=>'',    //公众号openid
    'selOrderNo'=>'', //订单号
];
return $charge->wechatpay($data);
~~~


## 支付宝服务窗支付
~~~
$data = [
    'amount'=>'',   //订单金额 以分为单位，如1元表示为100
    'userid'=>'',    //支付宝userid
    'selOrderNo'=>'', //订单号
];
return $charge->alipay($data);
~~~


## 订单查询
~~~
$data = [
    'qryNo'=>'XXXXXXXXX', //订单号
];
return $charge->orderqurey($data);
~~~

## 订单退款
~~~
$data = [
    'orderNo'=>'XXXXXXXXX', //退款订单号
];
return $charge->refund($data);
~~~

## 完整演示
~~~
use Oyta\Starpos\Charge;


$mchid = ''; //商户号
$key = ''; //密钥
$trmno = ''; //设备号
$charge = new Charge();
$charge->setconfig($mchid,$trmno,$key);
$data = [
    'amount'=>'', //实付金额 以分为单位，如1元表示为100
    'payChannel'=>'ALIPAY', //支付渠道 支付宝 ALIPAY 银联 YLPAY
    'selOrderNo'=>'', //订单号
];
return $charge->customerscan($data);
~~~
