<?php
$data = [
    'pageTitle' => 'Quên mật khẩu'
];
layout('header-auth', $data);
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
if (isPost()) {
    $body = getBody();
    if (!empty($body['email'])) {
        $email = $body['email'];
        $queryUser = firstRaw("SELECT email, id FROM users WHERE email='$email'");
        if (!empty($queryUser)) {
            $forgotToken = sha1(uniqid() . time());
            $dataUpdate = [
                'forgotToken' => $forgotToken,
            ];
            $UpdateStatus = update('users', $dataUpdate);
            if ($UpdateStatus) {
                $linkForgot = _WEB_HOST_ROOT.'?module=auth&action=reset&token='.$forgotToken;
                $subject = 'Yêu cầu khôi phục mật khẩu';
                $content = '<strong>Xin chào ' . $email . '</strong>' . "<br />";
                $content .= 'Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu tài khoản của bạn.' . "<br />";
                $content .= 'Bạn có thể trực tiếp thay đổi mật khẩu tại đây:' . "<br />";
                $content .= $linkForgot ."<br />";
                $content .= '<h3>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi</h3>';
                $sendStatus = sendMail($email, $subject, $content);
                if ($sendStatus) {
                    setFlashData('msg', 'Vui lòng kiểm tra email để đặt lại mật khẩu');
                    setFlashData('msg_type', 'success');
                    redirect('?module=auth&action=forgot_password');
                } else {
                    setFlashData('msg', 'Có lỗi khi gửi email vui lòng nhấp vào nút gửi lại email ');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Có lỗi xảy ra vui lòng liên hệ quản trị viên');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Email không chính xác');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng nhập email');
        setFlashData('msg_type', 'danger');
    }
    redirect('?module=auth&action=forgot_password');
}
?>
    <div class="container padding-bottom-3x mb-2 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="forgot">
                    <h2>Forgot your password?</h2>
                    <p>Change your password in three easy steps. This will help you to secure your password!</p>
                    <ol class="list-unstyled">
                        <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
                        <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link
                        </li>
                        <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
                    </ol>

                </div>

                <form class="card mt-4" method="post">
                    <?php getMsg($msg, $msg_type); ?>
                    <div class="card-body" style="padding-bottom: 0;">
                        <div class="form-group">
                            <label for="email-for-pass">Enter your email address</label>
                            <input class="form-control" type="text" id="email-for-pass" name="email">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" type="submit">Get New Password</button>
                        <button class="btn btn-danger" type="submit"><a href="?module=auth&action=login"
                                                                        style="color: white">Back To Login</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        body {
            background-position: center;
            background-color: #eee;
            background-repeat: no-repeat;
            background-size: cover;
            color: #505050;
            font-family: "Rubik", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.5;
            text-transform: none;
        }

        .forgot {
            background-color: #fff;
            padding: 12px;
            border: 1px solid #dfdfdf;
        }

        .padding-bottom-3x {
            padding-bottom: 72px !important;
        }

        .card-footer {
            background-color: #fff;
        }

        .btn {

            font-size: 13px;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #76b7e9;
            outline: 0;
            box-shadow: 0 0 0 0 #28a745;
        }
    </style>
<?php
layout('footer-auth');
?>