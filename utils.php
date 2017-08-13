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

function redirect($url)
{
    header('Location: '.$url);
    exit();
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
