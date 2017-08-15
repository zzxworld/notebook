<?php
$account = getParam('account');
$password = getParam('password');

if (empty($account)) {
    flashMessage('请输入您的登录账号');
    redirect(url('login'));
}

if (!isEmail($account)) {
    flashMessage('登录账号必须为电子邮箱格式');
    redirect(url('login'));
}

if (empty($password)) {
    flashMessage('请输入您的登录密码');
    redirect(url('login'));
}

try {
    $id = User::login($account, $password);
    signUser($id);
    redirect(url());
} catch (UserInvalidAccountError $e) {
    flashMessage('您输入的账号或密码不存在');
    redirect(url('login'));
} catch (UserInvalidPasswordError $e) {
    flashMessage('您输入的账号或密码有误');
    redirect(url('login'));
} catch (Exception $e) {
    flashMessage('登录失败，请稍后再试');
    redirect(url('login'));
}
