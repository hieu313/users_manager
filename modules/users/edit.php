<?php
$data = [
    'pageTitle' => 'Sửa thông tin người dùng'
];
layout('header', $data);
layout('navbar');

// Lấy dữ Liệu cũ của người dùng
$body = getBody();
if (!empty($body['id'])) {
    $userId = $body['id'];

    // kiểm tra xem userId có tồn tại trong database không?
    // Nếu tồn tại thì lấy thông tin
    // nếu không tồn tại thì chuyển hướng
    $userDetail = firstRaw("SELECT * FROM users WHERE id=$userId");
    if (!empty($userDetail)) {
        //tồn tại
        //gán giá trị $userDetail vào old_data vào flashData
        setFlashData('user_detail', $userDetail);
    } else {
//        redirect('?module=users');
        echo "lỗi";
    }

} else {
    redirect('?module=users');
}

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
            $sql = "SELECT id FROM users WHERE email='$email'AND id<>$userId";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }
    //validate password: phải nhập và có 6 kí tự trở lên
    if (!empty(trim($body['password']))) {
        //validate confirmpassword: phải nhập và giống password
        if (empty(trim($body['confirm_password']))) {
            $errors['confirm_password']['require'] = 'Vui lòng nhập lại mật khẩu';
        } else {
            if (trim($body['confirm_password']) != trim($body['password'])) {
                $errors['confirm_password']['match'] = 'Vui lòng nhập chính xác mật khẩu';
        }
    }
    }
    //? kiểm tra mảng errors
    if (empty($errors)) {
        //không có lỗi xảy ra
        $dataUpdate = [
            'name' => $body['name'],
            'phone' => $body['phone'],
            'email' => $body['email'],
            'status' => $body['status'],
            'updateAt' => date('Y-m-d H:i:s'),
        ];
        if (!empty(trim($body['password']))) {
            $dataUpdate['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
        }

        $condition = "id=$userId";
        $updateStatus = update('users', $dataUpdate, $condition);
        if ($updateStatus) { // khi gửi thành công information vào database
            setFlashData('msg', 'Sửa mới người dùng thành công!');
            setFlashData('msg_type', 'success');
        } else { //? khi gửi không thành công infomation vào database
            setFlashData('msg', 'Hệ thống đang gặp sự cố vui lòng thử lại sau ');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=users&action=edit'); //? load lại trang đăng kí //* loại bỏ confirm khi f5 lại trang

    } else {
        //có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_data', $body); //? lưu lại dữ liệu kể cả đúng hay sai để in lỗi do khi click sign up mà chưa nhập đầy đủ nội dung thì sẽ mất all dữ liệu

    }
    redirect('?module=users&action=edit&id=' . $userId); //? load lại trang đăng kí //* loại bỏ confirm khi f5 lại trang
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old_data = getFlashData('old_data');
$userDetail = getFlashData('user_detail');
if (!empty($userDetail)) {
    $old_data = $userDetail;
}
?>
<div class="container mb-100 ">
    <hr/>
    <h3><?php echo $data['pageTitle'] ?></h3>
    <?php getMsg($msg, $msg_type); ?>
    <form action="" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <lable for="">Họ và tên</lable>
                    <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                           value="<?php echo show_old_data($old_data, 'name') ?>">
                    <?php echo form_error('name', $errors, '<span class="error">', '</span>') ?>
                </div>
                <div class="form-group">
                    <lable for="">Email</lable>
                    <input type="text" class="form-control" name="email" placeholder="Email"
                           value="<?php echo show_old_data($old_data, 'email') ?>">
                    <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                </div>
                <div class="form-group">
                    <lable for="">Số Điện Thoại</lable>
                    <input type="text" class="form-control" name="phone" placeholder="Số Điện Thoại"
                           value="<?php echo show_old_data($old_data, 'phone') ?>">
                    <?php echo form_error('phone', $errors, '<span class="error">', '</span>') ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <lable for="">Mật Khẩu</lable>
                    <input type="password" class="form-control" name="password"
                           placeholder="Mật Khẩu (Không nhập nếu không thay đổi)">
                    <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
                </div>
                <div class="form-group">
                    <lable for="">Nhập Lại Mật Khẩu</lable>
                    <input type="password" class="form-control" name="confirm_password"
                           placeholder="Nhập Lại Mật Khẩu (Không nhập nếu không thay đổi)">
                    <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
                </div>
                <div class="form-group">
                    <lable for="">Trạng Thái</lable>
                    <select name="status" class="form-control">
                        <option value="1" <?php echo(show_old_data($old_data, 'status') == 1 ? 'selected' : null) ?>>
                            Kích
                            Hoạt
                        </option>
                        <option value="0" <?php echo(show_old_data($old_data, 'status') == 0 ? 'selected' : null) ?>>
                            Chưa
                            Kích Hoạt
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Cập nhật thông tin Người Dùng</button>
        <a href="?module=users" class="btn btn-success">Quay Lại</a>
        <input type="hidden" name="id" value="<?php echo $userId?>">
    </form>
</div>
<?php
layout('footer');
?>
