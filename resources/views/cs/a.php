<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script></script>
<body>
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="name" id="name"></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" name="pwd" id="pwd"></td>
            </tr>
            <tr>
                <td><input type="button" value="提交" class="btn"></td>
            </tr>
        </table>
</body>
</html>
<script src="js/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function(){
        $('.btn').click(function){
            var name=$('#name').val();
            var pwd=$('#pwd').val();
        }
    })
</script>