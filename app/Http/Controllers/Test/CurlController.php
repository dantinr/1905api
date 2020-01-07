<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurlController extends Controller
{
    public function curl1()
    {
        echo "server";echo '</br>';
        echo '<pre>';print_r($_GET);echo '</pre>';
    }

    public function curl2()
    {
        echo '<pre>';print_r($_POST);echo '</pre>';
    }

    public function curl3()
    {
        echo '<pre>';print_r($_POST);echo '</pre>';
        echo '<pre>';print_r($_FILES);echo '</pre>';
    }

    public function curl4()
    {

        $data = file_get_contents("php://input");
        echo '<hr>';
        echo '接收到的数据:'.$data;
        $arr = json_decode($data,true);
        echo '<pre>';print_r($arr);echo '</pre>';
    }

}
