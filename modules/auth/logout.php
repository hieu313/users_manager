<?php
if (isLogin()) {
    $token= getSession('loginToken');
    delete('login_token', "token='$token'");
    deleteSession('loginToken');
    redirect('?module=auth&action=login');
}