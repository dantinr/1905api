<?php

namespace App\Http\Controllers\Alipay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayController extends Controller
{


    /**
     * 支付宝异步通知
     */
    public function notify()
    {
        //$data = file_get_contents("php://input");
        $data = json_encode($_POST);
        $log = date('Y-m-d H:i:s') . ' >>> ' .$data;
        file_put_contents('alipay.log',$log,FILE_APPEND);
    }

    /**
     * 支付宝同步通知
     */
    public function aliReturn()
    {
        echo '<pre>';print_r($_GET);echo '</pre>';
    }
}
