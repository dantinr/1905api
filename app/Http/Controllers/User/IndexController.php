<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\UserModel;
use Illuminate\Support\Facades\Auth;
use App\Model\UserPubKeyModel;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addSSHKey1()
    {
        $data = [];
        return view('user.addkey');
    }

    /**
     * 用户添加公钥
     */
    public function addSSHKey2()
    {
        $key = trim($_POST['sshkey']);
        $uid = Auth::id();
        $user_name = Auth::user()->name;
        $data = [
            'uid'       => $uid,
            'name'      => $user_name,
            'pubkey'    => trim($key)
        ];

        //如果有记录则删除
        UserPubKeyModel::where(['uid'=>$uid])->delete();
        //添加新纪录
        $kid = UserPubKeyModel::insertGetId($data);
        if($kid){
            //页面跳转
            header('Refresh: 3; url=' . env('APP_URL') . '/home');
            echo "添加成功 公钥内容： >>> </br>" . $key;
            echo '</br>';
            echo "页面跳转中...";
        }



    }

    /**
     *
     */
    public function decrypt1()
    {
        return view('user.decrypt1');
    }

    public function decrypt2()
    {
        $enc_data = trim($_POST['enc_data']);
        echo "加密数据： ".$enc_data;echo '</br>';

        //解密
        $uid = Auth::id();
        //echo "用户ID: ".$uid;
        $u = UserPubKeyModel::where(['uid'=>$uid])->first();
        //echo '<pre>';print_r($u->toArray());echo '</pre>';
        $pub_key = $u->pubkey;

        openssl_public_decrypt(base64_decode($enc_data),$dec_data,$pub_key);

        echo '<hr>';
        echo "解密数据：". $dec_data;

    }

}
