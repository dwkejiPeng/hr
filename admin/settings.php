<?php
require_once '../api/db.php';

class SettingAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM settings";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$settingAdmin = new SettingAdmin();
$settings = $settingAdmin->getAll();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>设置管理</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>设置管理</h1>
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
        <h2>系统设置</h2>
        <button onclick="location.href='/admin/add_setting.php'">添加新设置</button>
        <table>
            <thead>
                <tr>
                    <th>键</th>
                    <th>值</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($settings as $setting): ?>
                <tr>
                    <td><?php echo htmlspecialchars($setting['key']); ?></td>
                    <td><?php echo htmlspecialchars($setting['value']); ?></td>
                    <td>
                        <button onclick="location.href='/admin/edit_setting.php?id=<?php echo $setting['id']; ?>'">编辑</button>
                        <button onclick="deleteSetting(<?php echo $setting['id']; ?>)">删除</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteSetting(id) {
            if (confirm('确定要删除这个设置吗？')) {
                fetch(`/api/settings.php`, {
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
                        alert('删除设置失败。');
                    }
                });
            }
        }
    </script>
    <script src="/js/scripts.js"></script>
</body>
</html>
