<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加公钥</title>
</head>
<body>

<form action="/user/addkey" method="post">
    {{csrf_field()}}
    <textarea name="sshkey" id="" cols="80" rows="20">
    </textarea>
    <input type="submit" value="提交">
</form>

</body>
</html>
