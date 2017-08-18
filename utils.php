<?php
function findArray(array $data, $name, $default=null)
{
    return isset($data[$name]) ? $data[$name] : $default;
}

function hasParam($name)
{
    return isset($_GET[$name]) || isset($_POST[$name]);
}

function getParam($name, $default=null)
{
    $value = findArray($_GET, $name, $default);
    if (isset($_POST[$name])) {
        $value = $_POST[$name];
    }
    if (is_string($value)) {
        $value = trim($value);
    }
    return $value;
}

function url($params = null)
{
    if (is_string($params)) {
        $params = ['action' => $params];
    }

    if (!is_array($params)) {
        return '/';
    }

    return '/?'. http_build_query($params);
}

function redirect($url)
{
    header('Location: '.$url);
    exit();
}

function setEnvironment()
{
    session_start();
}

function component($name)
{
    $filename = APP_ROOT.'/views/components/'.$name.'.php';
    if (!file_exists($filename)) {
        return false;
    }
    include($filename);
}

function render()
{
    if (!hasParam('action')) {
        $view = 'index';
    } else {
        $view = getParam('action');
    }

    $viewFilename = APP_ROOT.'/views/'.$view.'.php';
    if (!file_exists($viewFilename)) {
        $viewFilename = APP_ROOT.'/views/error_404.php';
    }

    $noLayoutViews = Config::get('naked_views');

    if (!in_array($view, $noLayoutViews)) {
        include APP_ROOT.'/views/layout.top.php';
    }

    include $viewFilename;

    if (!in_array($view, $noLayoutViews)) {
        include APP_ROOT.'/views/layout.bottom.php';
    }
}

function formatDateToHuman($strTime)
{
    $time = time() - strtotime($strTime);
    $days = floor($time/86400);
    if ($days > 0) {
        return $days.' 天前';
    }
    $hours = floor($time/3600);
    if ($hours > 0) {
        return $hours.' 小时前';
    }
    $minutes = floor($time/60);
    if ($minutes > 0) {
        return $minutes.' 分钟前';
    }
    return '刚刚';
}

function isEmail($text)
{
    return preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $text);
}

function randString($limit=4)
{
    $words = array_merge(
        range('a', 'z'),
        range('A', 'Z'),
        range(0, 9));
    $result = [];
    foreach (range(1, $limit) as $i) {
        $result[] = $words[array_rand($words)];
    }
    return implode('', $result);
}

function flashMessage($message = null)
{
    if (!$message) {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $_SESSION['flash_message'] = null;
        }
        return $message;
    }
    $_SESSION['flash_message'] = $message;
}

function signUser($id)
{
    $_SESSION['uid'] = (int) $id;
}

function destroyUser()
{
    $_SESSION['uid'] = 0;
}

function isLogined()
{
    if (!isset($_SESSION['uid'])) {
        return false;
    }

    $userId = (int) $_SESSION['uid'];

    if ($userId < 1) {
        return false;
    }

    return true;
}

function currentUser()
{
    if (!isset($_SESSION['uid'])) {
        return null;
    }
    return User::find((int) $_SESSION['uid']);
}
