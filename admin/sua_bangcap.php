<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu');


$id = $_GET['id'];
$sql = "SELECT * FROM bangcap WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_bang_cap = $_POST['ten_bang_cap'];

    
    $update_sql = "UPDATE bangcap SET ten_bang_cap = '$ten_bang_cap' WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        header('Location: quanly_bangcap.php');
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Bằng Cấp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADD8E6; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Bằng Cấp</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_bang_cap" class="form-label">Tên Bằng Cấp</label>
                <input type="text" class="form-control" id="ten_bang_cap" name="ten_bang_cap" value="<?php echo $row['ten_bang_cap']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="quanly_bangcap.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>
