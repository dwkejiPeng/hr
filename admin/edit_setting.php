<?php
require_once '../api/db.php';

class SettingAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getById($id) {
        $query = "SELECT * FROM settings WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$settingAdmin = new SettingAdmin();
$setting = $settingAdmin->getById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑设置</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>编辑设置</h1>
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
        <h2>编辑设置</h2>
        <form id="editSettingForm">
            <input type="hidden" id="id" name="id" value="<?php echo $setting['id']; ?>">
            <label for="key">键:</label><br>
            <input type="text" id="key" name="key" value="<?php echo $setting['key']; ?>" required><br>
            <label for="value">值:</label><br>
            <textarea id="value" name="value" required><?php echo $setting['value']; ?></textarea><br><br>
            <button type="submit">更新</button>
        </form>
    </div>
    <script>
        document.getElementById('editSettingForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/settings.php', {
                method: 'PUT',
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/admin/settings.php';
                } else {
                    alert('更新失败。');
                }
            });
        });
    </script>
</body>
</html>
