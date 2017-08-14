<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
</head>
<body>
    <div>
        <form action="/login_confirm" method="post">
            <div>
                <input type="text" name="account">
            </div>
            <div>
                <input type="password" name="password">
            </div>
            <footer>
                <button type="submit">保存</button>
                <a href="/?action=register">注册账号</a>
            </footer>
        </form>
    </div>
</body>
</html>
