<?php
require_once '../api/db.php';

class CompanyAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM companies";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$companyAdmin = new CompanyAdmin();
$companies = $companyAdmin->getAll();
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
        <h2>企业列表</h2>
        <button onclick="location.href='/admin/add_company.php'">添加新企业</button>
        <table>
            <thead>
                <tr>
                    <th>企业名称</th>
                    <th>描述</th>
                    <th>公司性质</th>
                    <th>公司规模</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $company): ?>
                <tr>
                    <td><?php echo htmlspecialchars($company['name']); ?></td>
                    <td><?php echo htmlspecialchars($company['description']); ?></td>
                    <td><?php echo htmlspecialchars($company['company_type']); ?></td>
                    <td><?php echo htmlspecialchars($company['company_size']); ?></td>
                    <td>
                        <button onclick="location.href='/admin/edit_company.php?id=<?php echo $company['id']; ?>'">编辑</button>
                        <button onclick="deleteCompany(<?php echo $company['id']; ?>)">删除</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteCompany(id) {
            if (confirm('确定要删除这个企业吗？')) {
                fetch(`/api/companies.php`, {
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
                        alert('删除企业失败。');
                    }
                });
            }
        }
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
