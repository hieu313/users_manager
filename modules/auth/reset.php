<?php
//! khi quên mật khẩu và xác nhận xong email thì vào đây để cập nhật lại mật khẩu
$data = [
    'title' => 'Quên Mật Khẩu'
];
layout('header-auth', $data);

$token = getBody()['token'];
echo "<div class=\"container text-center\" style=\"margin-top: 20px\">";
if (!empty($token)) {
    // truy vấn token với database
    $tokenQuery = firstRaw("SELECT id, name, email FROM users WHERE forgotToken = '$token'"); //lấy id

    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $email = $tokenQuery['email'];
        if (isPost()) {
//            redirect('?module=auth&action=reset&token=' . $token);
            $body = getBody();
            $errors = [];
            //validate password: phải nhập và có 6 kí tự trở lên
            if (empty(trim($body['password']))) {
                $errors['password']['require'] = 'Vui Lòng nhập mật khẩu';
            } else {
                if (strlen(trim($body['password'])) < 6) {
                    $errors['password']['min'] = 'Mật khẩu không được nhỏ hơn 6 kí tự ';
                }
            }
            //validate confirmpassword: phải nhập và giống password
            if (empty(trim($body['confirm_password']))) {
                $errors['confirm_password']['require'] = 'Vui lòng nhập lại mật khẩu';
            } else {
                if (trim($body['confirm_password']) != trim($body['password'])) {
                    $errors['confirm_password']['match'] = 'Vui lòng nhập chính xác mật khẩu';
                }
            }
            if (empty($errors)) {
//                xử lý update password
                $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'updateAt' => date('Y-m-d H:i:s'),
                ];
                $updateStatus = update('users', $dataUpdate, "id=$userId");
                if ($updateStatus) {
                    setFlashData('msg', 'Thay đổi mật khẩu thành công');
                    setFlashData('msg_type', 'success');
                    // gửi mail thông báo đổi mật khẩu thành công');
                    $subject = 'Đã thay đổi mật khẩu thành công';
                    $content = '<strong>Xin chào ' . $email . '</strong>' . "<br />";
                    $content .= 'Bạn đã đổi mật khẩu thành công' . "<br />";
                    sendMail($email, $subject, $content);

                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', 'Thay đổi mật khẩu không thành công! Vui lòng liên hệ quản trị viên');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
                setFlashData('msg_type', 'danger');
                setFlashData('errors', $errors);
            }
            redirect('?module=auth&action=reset&token=' . $token);
        }
        $msg = getFlashData('msg');
        $msg_type = getFlashData('msg_type');
        $errors = getFlashData('errors');
        ?>
        <div class="row text-left">
            <div class="col-6" style="margin: 20px auto 40px;">
                <h3 class="text-center text-uppercase">Đặt lại mật khẩu</h3>
                <?php
                getMsg($msg, $msg_type);
                ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" name="password" id="" class="form-control" placeholder="New Password...">
                        <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm New Password </label>
                        <input type="password" name="confirm_password" id="" class="form-control"
                               placeholder="Repeat Your Password...">
                        <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                    <hr/>
                    <p class="text-center"> Remember Your Password? <a href="?module=auth&action=login">Login</a></p>
                    <p class="text-center">Not A Member? <a href="?module=auth&action=register">Register</a></p>
                    <!-- Do khi click submit thì token sẽ trở về null (do token k còn nằm trong getBody() nữa ) nên phải có dòng dưới này -->
                    <input type="hidden" name="token" value="<?php echo $token ?>">
                </form>
            </div>
        </div>
        <?php
    } else { //token sai
        getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');

    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
echo "</div>";

?>
<?php
layout('footer-auth');
?>
