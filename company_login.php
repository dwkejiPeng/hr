<?php
require_once 'api/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT * FROM companies WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($company && password_verify($password, $company['password'])) {
        $_SESSION['company_id'] = $company['id'];
        $_SESSION['company_name'] = $company['name'];
        header('Location: company_dashboard.php');
        exit();
    } else {
        $error = '用户名或密码错误。';
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>企业登录</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>企业登录</h1>
    </header>
    <div class="container">
        <form method="POST" action="company_login.php">
            <label for="username">用户名:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">密码:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">登录</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <a class="register-link" href="company_register.php">还没有账户？注册</a>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
