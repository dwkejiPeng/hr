<?php
require_once '../api/db.php';

class CandidateAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM candidates";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$candidateAdmin = new CandidateAdmin();
$candidates = $candidateAdmin->getAll();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>人才管理</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>人才管理</h1>
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
        <h2>人才列表</h2>
        <button onclick="location.href='/admin/add_candidate.php'">添加新人</button>
        <table>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>生日</th>
                    <th>学历</th>
                    <th>毕业学校</th>
                    <th>专业</th>
                    <th>职称</th>
                    <th>手机号</th>
                    <th>邮箱</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidates as $candidate): ?>
                <tr>
                    <td><?php echo htmlspecialchars($candidate['name']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['gender']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['birthday']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['education']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['graduation_school']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['major']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['title']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['phone']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['email']); ?></td>
                    <td>
                        <button onclick="location.href='/admin/edit_candidate.php?id=<?php echo $candidate['id']; ?>'">编辑</button>
                        <button onclick="deleteCandidate(<?php echo $candidate['id']; ?>)">删除</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteCandidate(id) {
            if (confirm('确定要删除这个人才吗？')) {
                fetch(`/api/candidates.php`, {
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
                        alert('删除人才失败。');
                    }
                });
            }
        }
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
