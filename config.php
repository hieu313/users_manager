<?php
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'lists';
 
//! thiết lập host
define('_WEB_HOST_ROOT', 'http://'.$_SERVER['HTTP_HOST'].'/users_manager');
// _WEB_HOST_ROOT : http://localhost:3000/user-manage

define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'/templates');
// _WEB_HOST_TEMPLATE : http://localhost:3000/user-manage/templates

//! thiết lập path 
define('_WEB_PATH_ROOT', 'C:/xampp/htdocs/users_manager');
// _WEB_PATH_ROOT : D:\Workspace\xampp\htdocs\user-manage
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT.'/templates');
// _WEB_PATH_TEMPLATE : D:\Workspace\xampp\htdocs\user-manage/templates
//! Thiết lập kết nối database
const _HOST = 'localhost';
const _USER = 'root';
const _PASSWORD = ''; // xampp nên pass là rỗng
const _DB = 'users_manager'; // tên của csdl
const _DRIVER = 'mysql';


?>