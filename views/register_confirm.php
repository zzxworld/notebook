<?php
$account = getParam('account');
$password = getParam('password');
$passwordConfirm = getParam('password_confirm');

if (empty($account)) {
    flashMessage('您没有输入要注册的账号');
    redirect(url('register'));
}

if (!isEmail($account)) {
    flashMessage('账号格式必须为电子邮箱格式');
    redirect(url('register'));
}

if (empty($password)) {
    flashMessage('您没有设定登录密码');
    redirect(url('register'));
}

if (empty($passwordConfirm)) {
    flashMessage('您没有确认登录密码');
    redirect(url('register'));
}

if ($password != $passwordConfirm) {
    flashMessage('您两次输入的密码不一致');
    redirect(url('register'));
}

try {
    User::create([
        'email' => $account,
        'password' => $password,
    ]);
    redirect(url('login'));
} catch (UserRepeatAccountError $e) {
    flashMessage('此账号邮箱已被注册');
    redirect(url('register'));
} catch (Exception $e) {
    flashMessage('发生未知错误，请稍后再试');
    redirect(url('register'));
}
