<?php
//! biểu thị danh sách người dùng

$data = [
    'pageTitle' => 'Quản lý người dùng'
];
layout('header', $data);
layout('navbar');
// xử lý lọc
$filter = '';
if (isGet()) {
    $body = getBody();

    //xử lý lọc phần status
    if (!empty($body['status'])) {
        $status = $body['status'];

        if ($status == 2) {
            $statusSql = 0;
        } else {
            $statusSql = $status;
        }
        if (!empty($filter) && strpos($filter, 'WHERE') >= 0) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }
        $filter .= "$operator status='$statusSql' ";

    }

    // xử lý lọc theo từ khóa
    if (!empty($body['search'])) {
        $keyword = $body['search'];
        if (!empty($filter) && strpos($filter, 'WHERE') >= 0) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }
        $filter .= "$operator name LIKE '%$keyword%'";
    }
}

//xử lý phân trang
$allUserNum = getRows("SELECT id FROM  users $filter"); // lấy số lượng bản ghi

$perPage = 3; //mỗi trang có 3 bản ghi

//  tính số trang
$maxPage = ceil($allUserNum / $perPage);

// xử lý số trang dựa vào phương thức GET
if (!empty(getBody()['page'])) {
    $page = getBody()['page'];
    if ($page < 1 || $page > $maxPage) {
        $page = 1;
    }
} else {
    $page = 1;
}
/*
    tính toán offset trong limit dựa vào  $page
    page = 1 => offset = 0
    page = 2 => offset =3
    page = 3 => offset = 6
*/
$offset = ($page - 1) * $perPage;
//truy vấm lấy tất cả bản ghi
$listAllUsers = getRaw("SELECT * FROM users $filter ORDER BY createAt LIMIT $offset, $perPage");
// xử lý query String tìm kiếm cùng phân trang
$queryString = null;
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=users', '', $queryString);
    $queryString = str_replace('&page=' . $page, '', $queryString);
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="container mb-100 ">
    <hr/>
    <h3><?php echo $data['pageTitle'] ?></h3>
    <p>
        <a href="?module=users&action=add" class="btn btn-success btn-sm">Thêm người dùng <i class="fa fa-plus"></i></a>
    </p>
    <form action="" method="get" class="mb-3">
        <div class="row">
            <div class="col-3">
                <input type="hidden" name="module" value="users">
                <select name="status" id="" class="form-group" data-size="4">
                    <option value="0">Chọn Trạng Thái</option>
                    <option value="1" <?php echo((!empty($status) && $status == 1 ? 'selected' : false)) ?>>Kích Hoạt
                    </option>
                    <option value="2" <?php echo((!empty($status) && $status == 2 ? 'selected' : false)) ?>>Chưa Kích
                        Hoạt
                    </option>
                </select>
            </div>
            <div class="col-6">
                <input type="search" class="form-control" name="search" placeholder="Từ Khóa Tìm Kiếm"
                       value="<?php echo (!empty(getBody()['search'])) ? getBody()['search'] : null ?>"
                >
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
            </div>
        </div>
    </form>
    <?php getMsg($msg, $msg_type); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Điện Thoại</th>
            <th>Trạng Thái</th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($listAllUsers)) :
            $count = 0;
            foreach ($listAllUsers as $user) :
                $count++;
                ?>
                <tr>
                    <td><?php echo $count ?></td>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['phone'] ?></td>
                    <td><?php echo ($user['status'] == 1)
                            ? '<button type="button" class="btn btn-success btn-sm">Kích Hoạt</button>'
                            : '<button type="button" class="btn btn-warning btn-sm">Chưa kích hoạt</button>' ?>
                    </td>
                    <td><a href="<?php echo _WEB_HOST_ROOT.'?module=users&action=edit&id='.$user['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a></td>
                    <td><a href="<?php echo _WEB_HOST_ROOT.'?module=users&action=delete&id='.$user['id'] ?>" onclick="return confirm('Are You Sure?')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i></a></td>
                </tr>
            <?php
            endforeach;
        else :
            ?>
            <tr>
                <td colspan="7">
                    <div class="alert alert-danger text-center">Không có người dùng</div>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <hr/>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($page == 1) ? 'disabled' : false ?>">
                <a class="page-link"
                   href="<?php echo _WEB_HOST_ROOT . "?module=users".$queryString."&page=" . ($page - 1) ?>">
                    Previous</a>
            </li>
            <?php
            $beginPage = $page - 2;
            if ($beginPage < 1) {
                $beginPage = 1;
            }
            $endPage = $page + 2;
            if ($endPage > $maxPage) {
                $endPage = $maxPage;
            }

            for ($i = $beginPage; $i <= $endPage; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : false ?>">
                    <a class="page-link"
                       href="<?php echo _WEB_HOST_ROOT . "?module=users".$queryString."&page=" . $i ?>"><?php echo $i ?>
                    </a>
                </li>
            <?php } ?>
            <li class="page-item <?php echo ($page == $maxPage) ? 'disabled' : false ?>">
                <a class="page-link"
                   href="<?php echo _WEB_HOST_ROOT . "?module=users".$queryString."&page=" . ($page + 1) ?>">
                    Next</a>
            </li>
        </ul>
    </nav>
</div>
<?php
layout('footer');
?>
