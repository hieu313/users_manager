<?php
layout('header-auth');
echo "<div class=\"container text-center\" style=\"margin-top: 20px\">";
//kích hoạt mật khẩu
$token = getBody()['token'];
if (!empty($token)) {
    // truy vấn token với database
    $tokenQuery = firstRaw("SELECT id, name, email FROM users WHERE activeToken = '$token'"); //lấy id
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];
        $updateStatus = update('users',$dataUpdate, "id=$userId" );
        if ($updateStatus) {
            setFlashData('msg','kích hoạt tài khoản thành công bạn có thể đăng nhập ngay bây giờ');
            setFlashData('msg_type', 'success');

            $loginLink = _WEB_HOST_ROOT . '?module=auth&action=login';
            //gửi mail nếu kích hoạt thành công
            $subject = 'Kích hoạt tài khoản thành công';
            $content = '<strong> Chào mừng ' . $tokenQuery['name'] . ' gia nhập vào đại gia đình</strong>' ."<br />";
            $content .= 'Để đăng nhập vui lòng click vào link sau: '.$loginLink ."<br />";
            $content .= '<h3>Trân trọng</h3>';
            sendMail($tokenQuery['email'], $subject, $content);

        } else { // update không thành công
            setFlashData('msg','<strong>Kích hoạt tài khoản không thành công!</strong> Vui lòng liên hệ quản trị viên. ');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=login'); //? chuyển hướng sang trang login
    } else { //token sai
        getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');

    }
} else { // không tồn tại token
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
echo "</div>";
layout('footer-auth');
