<?php
session_start();


$host = 'localhost';
$dbname = 'quanly_nhansu';
$username_db = 'root';
$password_db = '';

$conn = new mysqli($host, $username_db, $password_db, $dbname);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_SESSION['admin'])) {
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['admin'] = $username;
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu!";
        }
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(135deg, #c2e9fb, #e0fcff);
        font-family: 'Segoe UI', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-box {
        background: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
    }

    .login-box h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-weight: 700;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control:focus {
        border-color: #00c9a7;
        box-shadow: 0 0 0 0.2rem rgba(0, 201, 167, 0.25);
    }

    .btn-primary {
        background-color: #00c9a7;
        border: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #00b09b;
    }

    .alert {
        font-weight: bold;
        text-align: center;
    }

    .input-group-text {
        background-color: #eaf4f4;
        border: 1px solid #d9f1f1;
        color: #00a896;
    }

    .logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo i {
        font-size: 40px;
        color: #00c9a7;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="logo">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h2>Đăng nhập Admin</h2>
        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Đăng nhập</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>