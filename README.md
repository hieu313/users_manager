# còn chưa xem 2 VIDEO tối ưu hóa

# Nhóm 1: xác thực truy cập
- Đăng nhập
- Đăng ký
- Đăng xuất
- Quên Mật Khẩu
- Kích hoạt tài khoản
# Nhóm 2: Quản lý người dùng 
- Xác thực người dùng đăng nhập
- Thêm người dùng
- Sửa người dùng
- xóa người dùng
- hiển thị danh sách người dùng (list.php)
- phân trang (list.php)
- tìm kiếm, lọc (list.php)


### 01. Thiết kế Database

- Bảng users:
+ id int primary key
+ email varchar(100)
+ fullname varchar(50)
+ phone varchar(20)
+ password varchar(50)
+ forgotToken varchar(50)
+ activeToken varchar(50)
+ status tinyint
+ createAt datetime
+ updateAt datetime

- Bảng loginToken
+ id int primary key
+ userId int foreign key đến users(id)
+ token varchar(50)
+ createAt datetime




