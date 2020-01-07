<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>解密数据</title>
</head>
<body>

<form action="/user/decrypt/data" method="post">
    {{csrf_field()}}
    请输入 base64encode后的密文：<br>
    <textarea name="enc_data" id="" cols="80" rows="20">
    </textarea>
    <input type="submit" value="提交">
</form>

</body>
</html>
