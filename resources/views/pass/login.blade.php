
<form class="form-signin" action="/pass/login" method="post">
    {{csrf_field()}}
    <h2 class="form-signin-heading">请登录</h2>
    <input type="hidden" value="{{$redirect}}" name="redirect">
    <label for="inputEmail">邮箱</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="@" required autofocus>
    <br>
    <label for="inputPassword" >密码</label>
    <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="***" required>
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
</form>
