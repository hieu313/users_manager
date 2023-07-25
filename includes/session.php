<?php 
//! hàm gán session
function setSession($key, $value) {
    if (!empty(session_id())) {
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
}

//! hàm đọc session
function getSession($key='') {
    if (empty($key)) {
        return ($_SESSION);
    } else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    return false;
}

//! hàm xóa session
function deleteSession ($key='') {
    if (empty($key)) {
        session_destroy();
        return true;
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    }
    return false;
}

//! hàm gán flash data (session được gọi ra thì tự động xóa)
function setFlashData ($key, $value) {
    $key = 'flash_' . $key;
    return setSession($key, $value);
}

//! hàm đọc flash data
function getFlashData ($key) {
    $key = 'flash_' . $key;
    $data = getSession($key); // save data
    deleteSession($key);
    return $data;
}
?>