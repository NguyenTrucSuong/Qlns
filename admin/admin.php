<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dangnhap.php");  
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Chào mừng bạn đến với trang quản trị, <?php echo $_SESSION['hoten']; ?>!</h2>
        
      
        <div class="mt-4">
            <p>Email: <?php echo $_SESSION['email']; ?></p>
            <p>Họ tên: <?php echo $_SESSION['hoten']; ?></p>
            <p>Địa chỉ: <?php echo $_SESSION['diachi']; ?></p>
            <p>Vai trò: <?php echo $_SESSION['role']; ?></p>
        </div>

        <hr>

   
        <h3>Quản lý người dùng</h3>
        <button class="btn btn-success">Thêm Người Dùng</button>
        <button class="btn btn-danger">Xóa Người Dùng</button>
        <button class="btn btn-warning">Cập Nhật Thông Tin</button>

        <hr>


        <div class="mt-4">
            <a href="dangxuat.php" class="btn btn-secondary">Đăng Xuất</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
