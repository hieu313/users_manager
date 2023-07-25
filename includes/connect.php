<?php
//! Thông tin kết nối
try {
    if (class_exists('PDO')) { 
        $dsn = _DRIVER.':dbname='._DB.';host='._HOST;
        
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Tạo thông báo ra ngoại lệ khi gặp lỗi
        ];
        $connect = new PDO($dsn, _USER, _PASSWORD);
    }
} catch (Exception $exeption) {
    error('database');
    die();
}
?>