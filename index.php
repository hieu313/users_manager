<?php
/*http://localhost/user-manage/?module=auth&action=login */

session_start();
require_once 'config.php';
//? import phpmailer
require_once './includes/phpmailer/PHPMailer.php';
require_once './includes/phpmailer/SMTP.php';
require_once './includes/phpmailer/Exception.php';

require_once './includes/database.php';
require_once './includes/functions.php';
require_once './includes/connect.php';
require_once './includes/session.php';
$module =  _MODULE_DEFAULT;
$action =  _ACTION_DEFAULT;
if (!empty($_GET['module']) && is_string($_GET['module'])) {
    $module = trim($_GET['module']);
}
if (!empty($_GET['action']) && is_string($_GET['action'])) {
    $action = trim($_GET['action']);
}

$path = 'modules/'.$module.'/'.$action.'.php';
if(file_exists($path)) {
    require_once $path;
} else {
    error('404');
}
