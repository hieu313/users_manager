<?php
$body = getBody();
if (!empty($body['id'])) {
    $userId = $body['id'];
    $userDetails = getRows("SELECT id FROM users WHERE id=$userId");
    if ($userDetails > 0) {
//        thực hiện xóa
        //1 Phải xóa ở loginToken trước
        $deleteToken = delete('login_token', "userId=$userId");
        if ($deleteToken) {
            //2 xóa ở users
            $deleteUser = delete('users', "id=$userId");
            if ($deleteUser) {
                setFlashData('msg', "Xóa người dùng thành công");
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', "Lỗi hệ thống không xóa được người dùng");
                setFlashData('msg_type', 'danger');
            }
        }
    } else {
        setFlashData('msg', 'Người dùng không tồn tại trên hệ thống');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Liên Kết Không Tồn Tại ');
    setFlashData('msg_type', 'danger');
}
redirect('?module=users');