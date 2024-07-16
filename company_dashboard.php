<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: company_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>企业管理</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>企业管理</h1>
        <nav>
            <ul>
                <li>
                    <a href="#"><?php echo htmlspecialchars($_SESSION['company_name']); ?></a>
                    <ul>
                        <li><a href="/add_job.php">新增职位</a></li>
                        <li><a href="/company_applications.php">查看投递信息</a></li>
                        <li><a href="/logout.php">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>欢迎, <?php echo htmlspecialchars($_SESSION['company_name']); ?></h2>
        <p>使用上方菜单管理您的职位和投递信息。</p>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
