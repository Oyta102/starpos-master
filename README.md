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
$mchid = '800584000065437'; //商户号
$key = '4EECF07A95069DC753B36C067B04BC96'; //密钥
$trmno = 'XC714636'; //设备号
$charge->setconfig($mchid,$trmno,$key);
~~~

## 商户主扫
~~~
$data = [
    'amount'=>'', //实付金额 以分为单位，如1元表示为100
    'authCode'=>'', //扫码支付授权码，设备读取用户微信或支付宝中的条码或者二维码信息
    'payChannel'=>'ALIPAY', //支付渠道 支付宝 ALIPAY  微信 WXPAY 银联 YLPAY
    'subject'=>'', //订单标题
    'selOrderNo'=>'', //订单号
];
return $charge->merchantscan($data);
~~~

## 客户主扫
~~~
$data = [
    'amount'=>'', //实付金额 以分为单位，如1元表示为100
    'payChannel'=>'ALIPAY', //支付渠道 支付宝 ALIPAY  微信 WXPAY 银联 YLPAY
    'subject'=>'', //订单标题
    'selOrderNo'=>'', //订单号
];
return $charge->customerscan($data);
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
