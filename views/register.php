<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>注册</title>
</head>
<body>
    <div>
        <?php component('flash_message') ?>
        <form action="<?php  echo url('register_confirm') ?>" method="post">
            <div>
                <input type="text" name="account" placeholder="Email 格式登录账号">
            </div>
            <div>
                <input type="password" name="password" placeholder="登录密码">
            </div>
            <div>
                <input type="password" name="password_confirm" placeholder="确认登录密码">
            </div>
            <footer>
                <button type="submit">确认注册</button>
                <a href="<?php echo url('login') ?>">返回登录</a>
            </footer>
        </form>
    </div>
</body>
</html>
