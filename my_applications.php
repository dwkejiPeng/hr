<?php
require_once 'api/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT applications.*, jobs.title as job_title, companies.name as company_name FROM applications JOIN jobs ON applications.job_id = jobs.id JOIN companies ON jobs.company_id = companies.id WHERE applications.user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的投递</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>我的投递</h1>
    </header>
    <div class="container">
        <h2>投递列表</h2>
        <table>
            <thead>
                <tr>
                    <th>职位名称</th>
                    <th>公司</th>
                    <th>申请时间</th>
                    <th>简历</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($application['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($application['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($application['resume']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
