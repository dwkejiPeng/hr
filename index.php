<?php
require_once 'api/db.php';
session_start();

class JobPublic {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT jobs.*, companies.name as company_name FROM jobs JOIN companies ON jobs.company_id = companies.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$jobPublic = new JobPublic();
$jobs = $jobPublic->getAll();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>招聘信息</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>公开招聘信息</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                        <ul>
                            <li><a href="/user_profile.php">更新求职信息</a></li>
                            <li><a href="/my_applications.php">查看我的投递</a></li>
                            <li><a href="/logout.php">退出登录</a></li>
                        </ul>
                    </li>
                <?php elseif (isset($_SESSION['company_id'])): ?>
                    <li>
                        <a href="#"><?php echo htmlspecialchars($_SESSION['company_name']); ?></a>
                        <ul>
                            <li><a href="/add_job.php">新增职位</a></li>
                            <li><a href="/company_applications.php">查看投递信息</a></li>
                            <li><a href="/logout.php">退出登录</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="#">登录</a>
                        <ul>
                            <li><a href="/user_login.php">用户登录</a></li>
                            <li><a href="/company_login.php">企业登录</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>职位列表</h2>
        <table>
            <thead>
                <tr>
                    <th>职位名称</th>
                    <th>薪酬</th>
                    <th>工作经验</th>
                    <th>学历</th>
                    <th>工作性质</th>
                    <th>工作地址</th>
                    <th>公司</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['salary']); ?></td>
                    <td><?php echo htmlspecialchars($job['experience']); ?></td>
                    <td><?php echo htmlspecialchars($job['education']); ?></td>
                    <td><?php echo htmlspecialchars($job['job_type']); ?></td>
                    <td><?php echo htmlspecialchars($job['job_address']); ?></td>
                    <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                    <td>
                        <button onclick="location.href='/apply_job.php?job_id=<?php echo $job['id']; ?>'">申请职位</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
