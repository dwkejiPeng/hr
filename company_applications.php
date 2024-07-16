<?php
require_once 'api/db.php';
session_start();

if (!isset($_SESSION['company_id'])) {
    header('Location: company_login.php');
    exit();
}

$company_id = $_SESSION['company_id'];
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT applications.*, users.name as user_name FROM applications JOIN jobs ON applications.job_id = jobs.id JOIN users ON applications.user_id = users.id WHERE jobs.company_id = :company_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':company_id', $company_id);
$stmt->execute();

$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看投递信息</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>查看投递信息</h1>
    </header>
    <div class="container">
        <h2>投递列表</h2>
        <table>
            <thead>
                <tr>
                    <th>职位ID</th>
                    <th>用户</th>
                    <th>姓名</th>
                    <th>邮箱</th>
                    <th>手机号</th>
                    <th>简历</th>
                    <th>申请时间</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo htmlspecialchars($application['job_id']); ?></td>
                    <td><?php echo htmlspecialchars($application['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($application['name']); ?></td>
                    <td><?php echo htmlspecialchars($application['email']); ?></td>
                    <td><?php echo htmlspecialchars($application['phone']); ?></td>
                    <td><?php echo htmlspecialchars($application['resume']); ?></td>
                    <td><?php echo htmlspecialchars($application['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
