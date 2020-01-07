<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{


    public function alipay()
    {

        $ali_gateway = 'https://openapi.alipaydev.com/gateway.do';  //支付网关

        // 公共请求参数
        $appid = '2016092500593666';
        $method = 'alipay.trade.page.pay';
        $charset = 'utf-8';
        $signtype = 'RSA2';
        $sign = '';
        $timestamp = date('Y-m-d H:i:s');
        $version = '1.0';
        $return_url = 'http://1905api.comcto.com/test/alipay/return';       // 支付宝同步通知
        $notify_url = 'http://1905api.comcto.com/test/alipay/notify';        // 支付宝异步通知地址
        $biz_content = '';

        // 请求参数
        $out_trade_no = time() . rand(1111,9999);       //商户订单号
        $product_code = 'FAST_INSTANT_TRADE_PAY';
        $total_amount = 0.01;
        $subject = '测试订单' . $out_trade_no;

        $request_param = [
            'out_trade_no'  => $out_trade_no,
            'product_code'  => $product_code,
            'total_amount'  => $total_amount,
            'subject'       => $subject
        ];


        $param = [
            'app_id'        => $appid,
            'method'        => $method,
            'charset'       => $charset,
            'sign_type'     => $signtype,
            'timestamp'     => $timestamp,
            'version'       => $version,
            'notify_url'    => $notify_url,
            'return_url'    => $return_url,
            'biz_content'   => json_encode($request_param)
        ];

        //echo '<pre>';print_r($param);echo '</pre>';

        // 字典序排序
        ksort($param);
        //echo '<pre>';print_r($param);echo '</pre>';

        // 2 拼接 key1=value1&key2=value2...
        $str = "";
        foreach($param as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }

        //echo 'str: '.$str;echo '</br>';

        $str = rtrim($str,'&');
        //echo 'str: '.$str;echo '</br>';echo '<hr>';
        // 3 计算签名   https://docs.open.alipay.com/291/106118
        $key = storage_path('keys/app_priv');
        $priKey = file_get_contents($key);
        $res = openssl_get_privatekey($priKey);
        //var_dump($res);echo '</br>';
        openssl_sign($str, $sign, $res, OPENSSL_ALGO_SHA256);       //计算签名
        $sign = base64_encode($sign);
        $param['sign'] = $sign;

        // 4 urlencode
        $param_str = '?';
        foreach($param as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $param_str = rtrim($param_str,'&');
        $url = $ali_gateway . $param_str;
        //发送GET请求
        //echo $url;die;
        header("Location:".$url);

    }

    public function goods(Request $request)
    {
        $goods_id = $request->input('id');      //商品ID
        echo 'goods_id: '.$goods_id;

        $key = 'ss:goods_click';            // 商品点击排名 有序集合

        //Redis::Zadd($key,$score,$goods_id);
        // 当用户访问商品页面 ，点击数 +1

        Redis::zIncrBy($key,1,$goods_id);
        echo "OK";
    }


    /**
     * 商品点击排名
     */
    public function goods2()
    {
        $key = 'ss:goods_click';

        $list = Redis::zRevRange($key,0,-1,true);
        echo '<pre>';print_r($list);echo '</pre>';
    }


    public function grab()
    {
        $redis_key = 'l:mobile:1234';   // 记录顺序
        $redis_s_key = 's:mobile:1234'; // 记录人数


        $uid = $_GET['uid'];

        $total = Redis::lLen($redis_key);
        echo '列表长度：'. $total;echo '</br>';


        $list = Redis::lRange($redis_key,0,-1);
        echo '<pre>';print_r($list);echo '</pre>';echo '<hr>';

        if($total >=5 ){
            echo "活动结束了";die;
        }

        //判断 元素是否在集合中
        $status = Redis::sIsMember($redis_s_key,$uid);
        var_dump($status);

        if($status){
            // 用户不能参加抢购
            echo "不要重复参加";
        }else{
            //可以参加抢购
            Redis::rPush($redis_key,$uid);      // 记录顺序
            Redis::sAdd($redis_s_key,$uid);
        }





        $list = Redis::lRange($redis_key,0,-1);
        echo '<pre>';print_r($list);echo '</pre>';

    }

    public function ascii()
    {
        $char = 'Hello World';
        $length = strlen($char);
        echo $length;echo '</br>';

        $pass = "";
        for($i=0;$i<$length;$i++)
        {

            echo $char[$i] . '>>> ' . ord($char[$i]);echo '</br>';
            $ord = ord($char[$i]) + 3;
            $chr = chr($ord);
            echo $char[$i] . '>>> ' . $ord . '>>>' . $chr;echo '<hr>';
            $pass .= $chr;

        }
        echo '</br>';
        echo $pass;

    }

    //解密
    public function dec()
    {
        $enc = 'Khoor#Zruog';
        echo "密文： ".$enc;echo '<hr>';
        $length = strlen($enc);


        $str = "";
        for($i=0;$i<$length;$i++)
        {
            $ord = ord($enc[$i]) - 3;
            $chr = chr($ord);
            echo $ord . '>>> ' . $chr ;echo '</br>';
            $str .= $chr;
        }

        echo "解密： ".$str;
    }

    public function md1()
    {
        echo base64_decode("VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==");die;
        echo md5($_GET['p']);die;
        echo md5('123456abc');die;
        $str1 = "Hello World";
        echo $str1;echo "</br>";
        echo md5($str1);
        echo "<hr>";

        $str2 = "Hello World Hello World sdlkfjslkdjflskdjfslkfdj";
        echo $str2;echo "</br>";
        echo md5($str2);
    }


    public function rsa1()
    {
        echo "xxxxx";echo '<hr>';
        echo '<pre>';print_r($_GET);echo '</pre>';
    }


}
