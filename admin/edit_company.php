<?php
require_once '../api/db.php';

class CompanyAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getById($id) {
        $query = "SELECT * FROM companies WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$companyAdmin = new CompanyAdmin();
$company = $companyAdmin->getById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑企业</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>编辑企业</h1>
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
        <h2>编辑企业</h2>
        <form id="editCompanyForm">
            <input type="hidden" id="id" name="id" value="<?php echo $company['id']; ?>">
            <label for="name">企业名称:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $company['name']; ?>" required><br>
            <label for="description">描述:</label><br>
            <textarea id="description" name="description" required><?php echo $company['description']; ?></textarea><br>
            <label for="company_type">公司性质:</label><br>
            <input type="text" id="company_type" name="company_type" value="<?php echo $company['company_type']; ?>" required><br>
            <label for="company_size">公司规模:</label><br>
            <input type="text" id="company_size" name="company_size" value="<?php echo $company['company_size']; ?>" required><br><br>
            <button type="submit">更新</button>
        </form>
    </div>
    <script>
        document.getElementById('editCompanyForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/companies.php', {
                method: 'PUT',
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/admin/companies.php';
                } else {
                    alert('更新失败。');
                }
            });
        });
    </script>
</body>
</html>
