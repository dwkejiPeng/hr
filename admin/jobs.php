<?php
require_once '../api/db.php';

class JobAdmin {
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

$jobAdmin = new JobAdmin();
$jobs = $jobAdmin->getAll();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>职位管理</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>职位管理</h1>
    </header>
    <nav>
        <ul>
            <li><a href="/admin/dashboard.php">仪表板</a></li>
            <li><a href="/admin/candidates.php">人才</a></li>
            <li><a href="/admin/jobs.php">职位</a></li>
            <li><a href="/admin/companies.php">企业</a></li>
            <li><a href="/admin/settings.php">设置</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>职位列表</h2>
        <button onclick="location.href='/admin/add_job.php'">添加新职位</button>
        <table>
            <thead>
                <tr>
                    <th>职位名称</th>
                    <th>薪酬</th>
                    <th>工作经验</th>
                    <th>学历</th>
                    <th>工作性质</th>
                    <th>工作地址</th>
                    <th>详细地址</th>
                    <th>手机号</th>
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
                    <td><?php echo htmlspecialchars($job['detailed_address']); ?></td>
                    <td><?php echo htmlspecialchars($job['phone']); ?></td>
                    <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                    <td>
                        <button onclick="location.href='/admin/edit_job.php?id=<?php echo $job['id']; ?>'">编辑</button>
                        <button onclick="deleteJob(<?php echo $job['id']; ?>)">删除</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteJob(id) {
            if (confirm('确定要删除这个职位吗？')) {
                fetch(`/api/jobs.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('删除职位失败。');
                    }
                });
            }
        }
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
