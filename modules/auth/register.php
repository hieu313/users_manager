<?php
$data = [
    'pageTitle' => 'Register'
];
layout('header-auth', $data);
if (isPost()) {
    $body = getBody(); //lấy all data trong form
    $errors = []; //mảng lưu trữ lỗi

    //validate họ tên: bắt buộc nhập và >= 5 kí tự
    if (empty(trim($body['name']))) {
        $errors['name']['require'] = 'Vui lòng nhập họ và tên đầy đủ';
    } else {
        if (mb_strlen(trim($body['name'])) < 5) {
            $errors['name']['min'] = 'Vui lòng nhập chính xác tên của bạn';
        }
    }
    //validate phone number: phải nhập, có 10 số và có chữ số 0 đầu tiên
    if (empty(trim($body['phone']))) {
        $errors['phone']['require'] = 'Vui Lòng nhập số điện thoại';
    } else {
        if (!isPhone(trim($body['phone']))) {
            $errors['phone']['isPhone'] = 'số điện thoại không hợp lệ';
        }
    }
    //validate email address: phải nhập,
    if (empty(trim($body['email']))) {
        $errors['email']['require'] = 'Vui lòng nhập địa chỉ Email';
    } else {
        if (!isEmail(trim($body['email']))) {
            $errors['email']['isEmail'] = 'Email không hợp lệ';
        } else {
            //?kiểm tra xem email có trong database hay không
            $email = trim($body['email']);
            $sql = "SELECT id FROM users WHERE email='$email'";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }
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
    //? kiểm tra mảng errors
    if (empty($errors)) {
        //không có lỗi xảy ra
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'name' => $body['name'],
            'phone' => $body['phone'],
            'email' => $body['email'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'createAt' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('users', $dataInsert);
        if ($insertStatus) { // khi gửi thành công information vào database

            //? tạo link kích hoạt tài khoản
            $linkActive = _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $activeToken;
            //? thiết lập gửi mail
            $subject = $body['name'] . ' vui lòng kích hoạt tài khoản';
            $content = 'Chào bạn: ' . $body['name'] . '<br />';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản: <br />';
            $content .= '<span style="color: #005cbf">' . $linkActive . '</span> ' . "<br />";
            $content .= '<h3>Trân trọng</h3>';
            $sendStatus = sendMail($body['email'], $subject, $content);

            if ($sendStatus) {
                //? gửi email thành công
                setFlashData('msg', 'Đăng ký tài khoản thành công.<strong> Vui lòng kiểm tra email để kích hoạt</strong>');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố vui lòng thử lại sau (lỗi gửi mail)');
                setFlashData('msg_type', 'danger');
            }

        } else { //? khi gửi không thành công infomation vào database
            setFlashData('msg', 'Hệ thống đang gặp sự cố vui lòng thử lại sau 2');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=register'); //? load lại trang đăng kí //* loại bỏ confirm khi f5 lại trang

    } else {
        //có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_data', $body); //? lưu lại dữ liệu kể cả đúng hay sai để in lỗi do khi click sign up mà chưa nhập đầy đủ nội dung thì sẽ mất all dữ liệu
        redirect('?module=auth&action=register'); //? load lại trang đăng kí //* loại bỏ confirm khi f5 lại trang

    }
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old_data = getFlashData('old_data');
?>
    <div class="row">
    <div class="col-6" style="margin: 20px auto 40px;">
        <h3 class="text-center text-uppercase">Sign Up</h3>
        <?php
        getMsg($msg, $msg_type);

        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Họ Tên</label>
                <input type="text" name="name" id="" class="form-control" placeholder="Enter Your Name"
                       value="<?php echo show_old_data($old_data, 'name') ?>">
                <!--                    ?toán tủ 3 ngôi và hàm reset(lấy ra phần tử đầu tiên của mảng)-->
                <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
            </div>
            <div class="form-group">
                <label>Điện thoại</label>
                <input type="text" name="phone" id="" class="form-control" placeholder="Phone Number"
                       value="<?php echo show_old_data($old_data, 'phone') ?>">
                <?php echo form_error('phone', $errors, '<span class="error">', '</span>') ?>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" id="" class="form-control" placeholder="Email Address"
                       value="<?php echo show_old_data($old_data, 'email') ?>">
                <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>

            </div>
            <div class="form-group">
                <label>Mật Khẩu</label>
                <input type="password" name="password" id="" class="form-control" placeholder="Password">
                <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
            </div>
            <div class="form-group">
                <label>Nhập Lại Mật Khẩu</label>
                <input type="password" name="confirm_password" id="" class="form-control"
                       placeholder="Repeat Your Password">
                <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            <hr>
            <p class="text-center">Have An Account? <a href="?module=auth&action=login">Login</a></p>
        </form>
    </div>
</div>
<?php
layout('footer-auth');
/*

*/
