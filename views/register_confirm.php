<?php
$account = getParam('account');
$password = getParam('password');
$passwordConfirm = getParam('password_confirm');

if (empty($account)) {
    redirect('/?action=register');
}

if (!isEmail($account)) {
    redirect('/?action=register');
}

if (empty($password)) {
    redirect('/?action=register');
}

if (empty($passwordConfirm)) {
    redirect('/?action=register');
}

if ($password != $passwordConfirm) {
    redirect('/?action=register');
}

try {
    User::create([
        'email' => $account,
        'password' => $password,
    ]);
} catch (UserRepeatAccountError $e) {
    redirect('/?action=register');
} catch (Exception $e) {
    redirect('/?action=register');
}

redirect('/?action=login');
