<div class="container ">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
                <li class="nav-item dropdown profile">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        Hi, Nguyễn Minh Hiếu
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Trang Cá Nhân</a>
                        <a class="dropdown-item" href="#">Cài Đặt</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo '?module=auth&action=logout' ?>">Đăng Xuất</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>