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

    public function addSSHKey2()
    {

        $key = trim($_POST['sshkey']);

        $uid = Auth::id();
        $data = [
            'uid'       => $uid,
            'pubkey'    => trim($key)
        ];


        $kid = UserPubKeyModel::insertGetId($data);

        echo "添加成功 公钥内容：<hr>" . $key;


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
