<?php
/**
 * @Copyright Oyta
 * @Author Oyta
 * @Email oyta@daucn.com
 * @Version 1.0
 */

namespace Oyta\Starpos;
use Oyta\Starpos\Http\Respone;
use Oyta\Starpos\Http\Sign;

class Charge
{
    public $MchId = ''; //商户号
    public $TrmNo = ''; //设备号
    public $OrgNo = '45987'; //机构号
    public $Key = ''; //密钥
    public $Url = 'http://gateway.starpos.com.cn/adpweb/ehpspos3';
    // http://139.196.77.69:8280/adpweb/ehpspos3
    // http://gateway.starpos.com.cn/adpweb/ehpspos3
    
    public function setconfig($mchid,$trmno,$key)
    {
        $this->MchId = $mchid;
        $this->TrmNo = $trmno;
        $this->Key = $key;
    }
    
    public function common()
    {
        $data = [
            'orgNo'=> $this->OrgNo,
            'characterSet'=>'00',
            'mercId'=>$this->MchId,
            'opSys'=>'3',
            'signType'=>'MD5',
            'tradeNo'=>date('YmdHis').rand(100000,999999),
            'trmNo'=> $this->TrmNo,
            'version'=>'V1.0.0',
            'txnTime'=>date('YmdHis'),
        ];
        return $data;
    }
    
    /**
     * 商户主扫
    **/
    public function merchantscan($param)
    {
        $data = $this->common(); //公共参数
        $data['amount'] = $param['amount']; //实付金额 以分为单位，如1元表示为100
        $data['total_amount'] = $param['amount']; //订单总金额 以分为单位，如1元表示为100
        $data['authCode'] = $param['authCode']; //扫码支付授权码，设备读取用户微信或支付宝中的条码或者二维码信息
        $data['payChannel'] = $param['payChannel']; //支付渠道 支付宝 ALIPAY  微信 WXPAY 银联 YLPAY
        $data['subject'] = $param['subject']; //订单标题
        $data['selOrderNo'] = $param['selOrderNo']; //订单号
        ksort($data); //对键升序排序
        $data['signValue'] = Sign::set($data,$this->Key); //签名
        $json = json_encode($data); //转换为json数据
        $res = Respone::http_post($this->Url.'/sdkBarcodePay.json',$json,null);
        return $this->strToUtf8($res);
    }
    
    /**
     * 客户主扫
     **/
    public function customerscan($param)
    {
        $data = $this->common(); //公共参数
        $data['amount'] = $param['amount']; //实付金额 以分为单位，如1元表示为100
        $data['total_amount'] = $param['amount']; //订单总金额 以分为单位，如1元表示为100
        $data['payChannel'] = $param['payChannel']; //支付渠道 支付宝 ALIPAY  微信 WXPAY 银联 YLPAY
        $data['subject'] = $param['subject']; //订单标题
        $data['selOrderNo'] = $param['selOrderNo']; //订单号
        ksort($data); //对键升序排序
        $data['signValue'] = Sign::set($data,$this->Key); //签名
        $json = json_encode($data); //转换为json数据
        $res = Respone::http_post($this->Url.'/sdkBarcodePosPay.json',$json,null);
        return $this->strToUtf8($res);
    }
    
    /**
     * 订单查询
     **/
    public function orderqurey($param)
    {
        $data = $this->common(); //公共参数
        $data['qryNo'] = $param['qryNo']; //订单号
        ksort($data); //对键升序排序
        $data['signValue'] = Sign::set($data,$this->Key); //签名
        $json = json_encode($data); //转换为json数据
        $res = Respone::http_post($this->Url.'/sdkQryBarcodePay.json',$json,null);
        return $this->strToUtf8($res);
    }
    
    /**
     * 退款
     **/
    public function refund($param)
    {
        $data = $this->common(); //公共参数
        $data['orderNo'] = $param['orderNo']; //退款订单号
        ksort($data); //对键升序排序
        $data['signValue'] = Sign::set($data,$this->Key); //签名
        $json = json_encode($data); //转换为json数据
        $res = Respone::http_post($this->Url.'/sdkRefundBarcodePay.json',$json,null);
        return $this->strToUtf8($res);
    }
    
    /**
     * gbk转utf-8
     **/
    public function strToUtf8($str){
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode == 'UTF-8'){
            $res = $str;
        }else{
            $res = mb_convert_encoding($str, 'UTF-8', $encode);
        }
        return json_decode(urldecode($res),true);
    }
}
