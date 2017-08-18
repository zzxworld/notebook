<?php
define('APP_ROOT', dirname(__DIR__));

require APP_ROOT.'/classes/config.php';
require APP_ROOT.'/classes/db.php';
require APP_ROOT.'/classes/user.php';
require APP_ROOT.'/classes/post.php';
require APP_ROOT.'/config.php';
require APP_ROOT.'/utils.php';

setEnvironment();

render();
