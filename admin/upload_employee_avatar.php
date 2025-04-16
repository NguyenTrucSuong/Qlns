<?php
$conn = new mysqli('localhost', 'root', '', 'quanly_nhansu'); 

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $file = $_FILES['avatar'];

        if ($file['size'] > 2 * 1024 * 1024) {
            echo "Kích thước file quá lớn! Vui lòng chọn file nhỏ hơn 2MB.";
            exit;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo "Chỉ cho phép upload file ảnh (JPG, PNG, JPEG).";
            exit;
        }

 
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

   
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $employeeId = $_POST['employee_id'];

          
            $query = "UPDATE nhanvien SET avatar = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $uploadPath, $employeeId); 
            $stmt->execute();

            echo "Ảnh đại diện cho nhân viên đã được upload thành công!";
        } else {
            echo "Có lỗi xảy ra trong quá trình upload ảnh.";
        }
    } else {
        echo "Vui lòng chọn một file để upload.";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Avatar Nhân viên</title>
</head>
<body>
    <h2>Upload Avatar cho Nhân viên</h2>
    <form action="upload_employee_avatar.php" method="POST" enctype="multipart/form-data">
        <label for="employee_id">ID Nhân viên:</label>
        <input type="number" name="employee_id" id="employee_id" required>
        <br><br>
        <label for="avatar">Chọn ảnh đại diện:</label>
        <input type="file" name="avatar" id="avatar" required>
        <br><br>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>
</html>
