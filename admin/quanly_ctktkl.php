<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete_sql = $conn->prepare("DELETE FROM chitietkhenthuong_kyluat WHERE id = ?");
    $delete_sql->bind_param("i", $id);

    if ($delete_sql->execute()) {
        echo "<script>alert('Chi tiết đã được xóa thành công.'); window.location.href='quanly_ctktkl.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$sql = "SELECT chitietkhenthuong_kyluat.id, nhanvien.ho_ten, danhmuckhenthuong_kyluat.ten_danh_muc, chitietkhenthuong_kyluat.ngay_ly_do, chitietkhenthuong_kyluat.mo_ta
        FROM chitietkhenthuong_kyluat
        JOIN nhanvien ON chitietkhenthuong_kyluat.id_nhan_vien = nhanvien.id
        JOIN danhmuckhenthuong_kyluat ON chitietkhenthuong_kyluat.id_danh_muc_ktkl = danhmuckhenthuong_kyluat.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Chi Tiết Khen Thưởng Kỷ Luật</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    /* Đảm bảo footer luôn ở dưới cùng */
    body {
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .header {
        background-color: #17a2b8;
        color: white;
        padding: 15px 0;
        text-align: center;
        font-size: 22px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .greeting {
        font-size: 17px;
        margin-top: 15px;
    }

    .container {
        max-width: 1200px;
        margin-top: 30px;
        flex: 1;
    }

    .sidebar {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .list-group-item {
        border: none;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #17a2b8;
        color: white;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background-color: #17a2b8;
        color: white;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .btn {
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 14px;
    }

    .footer {
        background-color: #17a2b8;
        color: white;
        text-align: center;
        padding: 10px 0;
        margin-top: 40px;
        font-size: 14px;
    }
    </style>
</head>

<body>

    <div class="header">
        Hệ Thống Quản Lý Nhân Sự
    </div>

    <div class="container mt-3 d-flex justify-content-between align-items-center">
        <div class="greeting">
            Xin chào, <span class="text-primary fw-semibold"><?php echo htmlspecialchars($_SESSION['admin']); ?></span>
        </div>
        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
    </div>

    <div class="container">
        <div class="row mt-4">

            <div class="col-md-3">
                <div class="sidebar">
                    <div class="list-group">
                        <a href="quanly_nhanvien.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-people-fill me-2"></i>Quản lý nhân viên</a>
                        <a href="quanly_donvi.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-building me-2"></i>Quản lý đơn vị</a>
                        <a href="quanly_bangcap.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-award me-2"></i>Quản lý bằng cấp</a>
                        <a href="quanly_lhdt.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-journal-bookmark-fill me-2"></i>Loại hình đào tạo</a>
                        <a href="quanly_qtct.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-clock-history me-2"></i>Quá trình công tác</a>
                        <a href="quanly_dmktkl.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-star me-2"></i>Khen thưởng - Kỷ luật</a>
                        <a href="quanly_ctktkl.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-list-ul me-2"></i>Chi tiết KT-KL</a>
                        <a href="quanly_cctlht.php" class="list-group-item list-group-item-action"><i
                                class="bi bi-cash-stack me-2"></i>Chấm công - Tính lương</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Quản lý Chi Tiết Khen Thưởng Kỷ Luật
                    </div>
                    <div class="card-body">
                        <a href="them_chitiet.php" class="btn btn-primary mb-3"><i
                                class="bi bi-plus-circle me-1"></i>Thêm Chi Tiết</a>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ Tên</th>
                                        <th>Tên Danh Mục</th>
                                        <th>Ngày</th>
                                        <th>Mô Tả(Lý do)</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>{$row['ho_ten']}</td>
                                                    <td>{$row['ten_danh_muc']}</td>
                                                    <td>{$row['ngay_ly_do']}</td>
                                                    <td>{$row['mo_ta']}</td>
                                                    <td>
                                                        <div class='btn-group' role='group'>
                                                            <a href='sua_chitiet.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>
                                                            <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
                                                        </div>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center text-muted'>Không có dữ liệu</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer mt-4">
        &copy; 2024 Quản lý nhân sự - All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>