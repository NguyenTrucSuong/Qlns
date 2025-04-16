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

$sql_nhanvien = "SELECT * FROM nhanvien";
$nhanvien_result = $conn->query($sql_nhanvien);

$sql_chamcong = "SELECT chamcong.id, nhanvien.ho_ten, chamcong.thang_lam_viec, chamcong.so_ngay_lam, chamcong.luong 
                 FROM chamcong
                 JOIN nhanvien ON chamcong.id_nhan_vien = nhanvien.id";
$chamcong_result = $conn->query($sql_chamcong);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_nhan_vien']) && isset($_POST['thang_lam_viec']) && isset($_POST['so_ngay_lam'])) {
    $id_nhan_vien = $_POST['id_nhan_vien'];
    $thang_lam_viec = $_POST['thang_lam_viec'];
    $so_ngay_lam = $_POST['so_ngay_lam'];

    if (empty($thang_lam_viec)) {
        echo "<script>alert('Vui lòng chọn tháng làm việc!');</script>";
    } else {
        
        $sql_chucvu = "SELECT chucvu.luong_coban FROM nhanvien 
                       JOIN chucvu ON nhanvien.id_chuc_vu = chucvu.id 
                       WHERE nhanvien.id = $id_nhan_vien";
        $chucvu_result = $conn->query($sql_chucvu);
        $chucvu_row = $chucvu_result->fetch_assoc();
        $luong_coban = $chucvu_row['luong_coban'];

  
        $luong = $so_ngay_lam * $luong_coban;

        
        $formatted_thang_lam_viec = $thang_lam_viec . '-01';

        $check_sql = "SELECT * FROM chamcong WHERE id_nhan_vien = $id_nhan_vien AND thang_lam_viec = '$formatted_thang_lam_viec'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Chấm công cho nhân viên này đã tồn tại trong tháng này.');</script>";
        } else {
        
            $sql_insert = "INSERT INTO chamcong (id_nhan_vien, thang_lam_viec, so_ngay_lam, luong) 
                           VALUES ($id_nhan_vien, '$formatted_thang_lam_viec', $so_ngay_lam, $luong)";

            if ($conn->query($sql_insert) === TRUE) {
                echo "<script>alert('Chấm công đã được thêm thành công!'); window.location.href='quanly_cctlht.php';</script>";
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM chamcong WHERE id = $id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Chấm công đã được xóa thành công.'); window.location.href='quanly_cctlht.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Chấm Công và Tính Lương</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', sans-serif;
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
        margin-top: auto;
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
                        Quản Lý Chấm Công và Tính Lương
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="id_nhan_vien" class="form-label">Chọn Nhân Viên</label>
                                <select name="id_nhan_vien" class="form-select" required>
                                    <?php
                                    while ($row = $nhanvien_result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['ho_ten'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="thang_lam_viec" class="form-label">Tháng Làm Việc</label>
                                <input type="month" name="thang_lam_viec" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="so_ngay_lam" class="form-label">Số Ngày Làm</label>
                                <input type="number" name="so_ngay_lam" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm Chấm Công</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Danh Sách Chấm Công
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Họ Tên</th>
                                    <th>Tháng Làm Việc</th>
                                    <th>Số Ngày Làm</th>
                                    <th>Lương</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $chamcong_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['ho_ten']; ?></td>
                                    <td><?php echo $row['thang_lam_viec']; ?></td>
                                    <td><?php echo $row['so_ngay_lam']; ?></td>
                                    <td><?php echo number_format($row['luong']); ?></td>
                                    <td><a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; 2024 Quản lý nhân sự - All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>