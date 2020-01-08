<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>在线验签</title>
</head>
<body>


<form action="/test/post/signonlie" method="post">
    {{csrf_field()}}
    字段1： <input type="text" name="k[]"> 字段值： <input type="text" name="v[]"> <br>
    字段2： <input type="text" name="k[]"> 字段值： <input type="text" name="v[]"><br>
    字段3： <input type="text" name="k[]"> 字段值： <input type="text" name="v[]"><br>
    字段4： <input type="text" name="k[]"> 字段值： <input type="text" name="v[]"><br>
    字段5： <input type="text" name="k[]"> 字段值： <input type="text" name="v[]"><br>
    签名（base64encode）：<br> <textarea name="sign" cols="30" rows="20"></textarea>

    <input type="submit" value="提交">
</form>

</body>
</html>
