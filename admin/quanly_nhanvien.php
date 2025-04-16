<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


$donvi_result = $conn->query("SELECT * FROM donvi");
$bangcap_result = $conn->query("SELECT * FROM bangcap");


$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$chucvu = isset($_GET['chucvu']) ? $_GET['chucvu'] : '';
$donvi = isset($_GET['donvi']) ? $_GET['donvi'] : '';
$bangcap = isset($_GET['bangcap']) ? $_GET['bangcap'] : '';


$sql = "SELECT nhanvien.id, nhanvien.ho_ten, nhanvien.chuc_vu, nhanvien.ngay_sinh, donvi.ten_don_vi, bangcap.ten_bang_cap
        FROM nhanvien
        JOIN donvi ON nhanvien.id_don_vi = donvi.id
        JOIN bangcap ON nhanvien.id_bang_cap = bangcap.id";

$conditions = [];

if (!empty($keyword)) {
    $conditions[] = "nhanvien.ho_ten LIKE '%" . $conn->real_escape_string($keyword) . "%'";
}
if (!empty($chucvu)) {
    $conditions[] = "nhanvien.chuc_vu = '" . $conn->real_escape_string($chucvu) . "'";
}
if (!empty($donvi)) {
    $conditions[] = "donvi.ten_don_vi = '" . $conn->real_escape_string($donvi) . "'";
}
if (!empty($bangcap)) {
    $conditions[] = "bangcap.ten_bang_cap = '" . $conn->real_escape_string($bangcap) . "'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    body {
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        flex: 1;
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
                        Danh sách nhân viên
                    </div>
                    <div class="card-body">
                        <form method="GET" class="d-flex flex-wrap gap-2 mb-3">
                            <input type="text" name="keyword" class="form-control me-2" placeholder="Tên nhân viên..."
                                value="<?php echo htmlspecialchars($keyword); ?>">

                            <select name="chucvu" class="form-select">
                                <option value="">-- Chức vụ --</option>
                                <option value="Giám đốc"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Giám đốc') echo 'selected'; ?>>
                                    Giám đốc</option>
                                <option value="Trưởng phòng"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Trưởng phòng') echo 'selected'; ?>>
                                    Trưởng phòng</option>
                                <option value="Nhân viên"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Nhân viên') echo 'selected'; ?>>
                                    Nhân viên</option>
                                <option value="Quản Lý"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Quản Lý') echo 'selected'; ?>>
                                    Quản Lý</option>
                                <option value="Phó Giám Đốc"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Phó Giám Đốc') echo 'selected'; ?>>
                                    Phó Giám Đốc</option>
                                <option value="Tổ Trưởng"
                                    <?php if (isset($_GET['chucvu']) && $_GET['chucvu'] == 'Tổ Trưởng') echo 'selected'; ?>>
                                    Tổ Trưởng</option>
                            </select>


                            <select name="donvi" class="form-select me-2">
                                <option value="">-- Đơn vị --</option>
                                <?php
                                $donvi_result2 = $conn->query("SELECT * FROM donvi");
                                while ($dv = $donvi_result2->fetch_assoc()) {
                                    $selected = ($donvi == $dv['ten_don_vi']) ? 'selected' : '';
                                    echo "<option value='{$dv['ten_don_vi']}' $selected>{$dv['ten_don_vi']}</option>";
                                }
                                ?>
                            </select>

                            <select name="bangcap" class="form-select me-2">
                                <option value="">-- Bằng cấp --</option>
                                <?php
                                $bangcap_result2 = $conn->query("SELECT * FROM bangcap");
                                while ($bc = $bangcap_result2->fetch_assoc()) {
                                    $selected = ($bangcap == $bc['ten_bang_cap']) ? 'selected' : '';
                                    echo "<option value='{$bc['ten_bang_cap']}' $selected>{$bc['ten_bang_cap']}</option>";
                                }
                                ?>
                            </select>

                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Lọc</button>
                        </form>

                        <a href="them_nhanvien.php" class="btn btn-primary mb-3"><i
                                class="bi bi-plus-circle me-1"></i>Thêm Nhân Viên</a>
                        <a href="export_nhanvien_excel.php?<?php echo http_build_query($_GET); ?>"
                            class="btn btn-success mb-3 ms-2">
                            <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ Tên</th>
                                        <th>Chức Vụ</th>
                                        <th>Ngày Sinh</th>
                                        <th>Đơn Vị</th>
                                        <th>Bằng Cấp</th>
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
                                                <td>{$row['chuc_vu']}</td>
                                                <td>{$row['ngay_sinh']}</td>
                                                <td>{$row['ten_don_vi']}</td>
                                                <td>{$row['ten_bang_cap']}</td>
                                                <td>
                                                    <div class='btn-group' role='group'>
                                                        <a href='sua_nhanvien.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>
                                                        <a href='xoa_nhanvien.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
                                                        <a href='chitiet_nhanvien.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='bi bi-info-circle'></i></a>
                                                    </div>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center text-muted'>Không có dữ liệu</td></tr>";
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

<?php $conn->close(); ?>