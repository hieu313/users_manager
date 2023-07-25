<?php
//check đăng nhập

    if (!isLogin()) {
        // nếu không tồn tại token thì chuyển về auth=login | ngăn chặn trực tiếp truy cập vào link
        redirect('?module=auth&action=login');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> <?php echo !empty($data['pageTitle']) ? $data['pageTitle'] : 'Hiếu Shop' ?> </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo _WEB_HOST_TEMPLATE ?>/css/style.css?ver=<?php echo rand() ?>"/>
    <!-- ? thêm ver để lúc nào reload lại trang cũng được làm mới-->
</head>
<body>
<!-- là do chạy từ file index chứ không trực tiếp chạy từ file này mà index đã require hằng ở file config rồi nên ở đây sẽ không phải require nữa -->