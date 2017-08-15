<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
</head>
<body>
    <div>
        <?php component('flash_message') ?>
        <form action="<?php echo url('login_confirm') ?>" method="post">
            <div>
                <input type="text" name="account" placeholder="登录账号">
            </div>
            <div>
                <input type="password" name="password" placeholder="登录密码">
            </div>
            <footer>
                <button type="submit">保存</button>
                <a href="<?php echo url('register') ?>">注册账号</a>
            </footer>
        </form>
    </div>
</body>
</html>
