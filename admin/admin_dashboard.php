<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân sự</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(135deg, #d0f0ec, #f0fdfd);
        font-family: 'Roboto', sans-serif;
        color: #333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    .header {
        background-color: #00bfa6;
        color: white;
        padding: 16px 0;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header h1 {
        font-size: 24px;
        font-weight: 600;
    }

    .logout-btn {
        position: absolute;
        top: 12px;
        right: 20px;
        background: #dc3545;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .logout-btn:hover {
        background: #c82333;
        transform: scale(1.05);
    }

    .container {
        background: white;
        padding: 40px 30px;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        max-width: 880px;
        margin: 60px auto;
    }

    .greeting {
        font-size: 18px;
        margin-bottom: 24px;
        color: #444;
        font-weight: 500;
        text-align: center;
    }

    h2 {
        text-align: center;
        color: #00bfa6;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .list-group {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .list-group-item {
        background: #f8f9fa;
        padding: 16px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        color: #333;
        box-shadow: 0 4px 8px rgba(0, 191, 166, 0.1);
    }

    .list-group-item:hover {
        background: #00bfa6;
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 191, 166, 0.3);
    }

    .footer {
        background-color: #00bfa6;
        color: white;
        text-align: center;
        padding: 8px;
        position: fixed;
        width: 100%;
        bottom: 0;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .container {
            padding: 20px;
        }

        .logout-btn {
            padding: 8px 12px;
            font-size: 14px;
        }
    }
    </style>
</head>

<body>

    <div class="header">
        <h1>Quản Lý Nhân Sự</h1>
        <a href="logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Đăng xuất
        </a>
    </div>

    <div class="container">
        <div class="greeting">
            Xin chào, <span class="text-success"><?php echo htmlspecialchars($_SESSION['admin']); ?></span>!
        </div>
        <h2>Chức năng quản lý</h2>
        <div class="list-group">
            <a href="quanly_nhanvien.php" class="list-group-item">👨‍💼 Quản lý nhân viên</a>
            <a href="quanly_donvi.php" class="list-group-item">🏢 Quản lý đơn vị</a>
            <a href="quanly_bangcap.php" class="list-group-item">🎓 Quản lý bằng cấp</a>
            <a href="quanly_lhdt.php" class="list-group-item">📖 Quản lý loại hình đào tạo</a>
            <a href="quanly_qtct.php" class="list-group-item">📜 Quản lý quá trình công tác</a>
            <a href="quanly_dmktkl.php" class="list-group-item">🏆 Quản lý khen thưởng - kỷ luật</a>
            <a href="quanly_ctktkl.php" class="list-group-item">📑 Quản lý chi tiết khen thưởng - kỷ luật</a>
            <a href="quanly_cctlht.php" class="list-group-item">💰 Quản lý chấm công - tính lương</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Quản lý nhân sự. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>