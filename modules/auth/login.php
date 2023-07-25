<?php
$data = [
    'pageTitle' => 'Đăng nhập'
];
layout('header-auth', $data);
// nhận thông báo đã đăng ký tài khoản thành công bên active | đồng bộ thông báo
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
// kiểm tra trạng thái đăng nhập
//? xử lý việc đăng nhập: sau khi đăng kí tài khoản thành công
if (isPost()) {
    $body = getBody();
    // $body: nhận mảng chứa các giá trị nhập vào ở input
    if (!empty(trim($body['email']) && !empty(trim($body['password'])))) {
        // kiểm tra đăng nhập
        $email = $body['email'];
        $password = $body['password'];

        // truy vấn lấy thông tin user theo email
        $userQuery = firstRaw("SELECT id, password FROM users WHERE email='$email' AND status=1");
        // trả về mảng chứa password ,id trong users dựa theo email
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {// check password
                // tạo token login
                $tokenLogin = sha1(uniqid() . time());
                //insert dữ liệu
                $dataToken = [
                    'userId' => $userId,
                    'token' => $tokenLogin,
                    'createAt' => date('Y-m-d H:i:s'),
                ];

                $insertTokenStatus = insert('login_token', $dataToken);
                if ($insertTokenStatus) {
                    // lưu dữ liệu vào database thành công

                    //lưu loginToken vào session
                    setSession('loginToken', $tokenLogin);
                    //chuyển hướng trang quản lý users
                    redirect('?module=users');
                    //do khi redirect thì phần bên dưới die hết nên có thể bỏ qua tất cả redirect ở dưới và quy vào 1
                } else {
                    setFlashData('msg', 'Xin lỗi Bạn không thể đăng nhập ngay lúc này');
                    setFlashData('msg_type', 'danger');
//                    redirect('?module=auth&action=login');
                }
            } else {
                setFlashData('msg', 'Mật khẩu không chính xác');
                setFlashData('msg_type', 'danger');
//                redirect('?module=auth&action=login');
            }
        } else {
            setFlashData('msg', 'Email không tồn tại hoặc chưa được kích hoạt');
            setFlashData('msg_type', 'danger');
//            redirect('?module=auth&action=login');
        }
    } else {
        //nếu chưa nhập cả email lẫn mật khẩu
        setFlashData('msg', 'Vui lòng nhập email và password');
        setFlashData('msg_type', 'danger');
//        redirect('?module=auth&action=login');
    }
    redirect('?module=auth&action=login');
}
?>
<div class="row">
    <div class="col-6" style="margin: 20px auto; margin-bottom: 40px;">
        <h3 class="text-center text-uppercase">Login</h3>
        <?php getMsg($msg, $msg_type); ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" id="" class="form-control" placeholder="Email Address">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" id="" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <hr/>
            <p class="text-center"><a href="?module=auth&action=forgot_password">Forgot Password</a></p>
            <p class="text-center">Not A Member? <a href="?module=auth&action=register">Register</a></p>
        </form>
    </div>
</div>
<?php
layout('footer-auth');
?>