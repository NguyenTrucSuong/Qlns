<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $sql = "SELECT * FROM donvi WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Đơn vị không tồn tại.";
        exit;
    }

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ten_don_vi = $_POST['ten_don_vi'];

        $sql_update = "UPDATE donvi SET ten_don_vi = '$ten_don_vi' WHERE id = $id";
        if ($conn->query($sql_update) === TRUE) {
            header('Location: quanly_donvi.php');
            exit;
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
} else {
    echo "ID không hợp lệ.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Đơn Vị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Đơn Vị</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_don_vi" class="form-label">Tên Đơn Vị</label>
                <input type="text" class="form-control" id="ten_don_vi" name="ten_don_vi" value="<?php echo $row['ten_don_vi']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="quanly_donvi.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
