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
    <title>添加新职位</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>添加新职位</h1>
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
        <h2>添加新职位</h2>
        <form id="addJobForm">
            <label for="title">职位名称:</label><br>
            <input type="text" id="title" name="title" required><br>
            <label for="salary">薪酬:</label><br>
            <input type="text" id="salary" name="salary" required><br>
            <label for="experience">工作经验:</label><br>
            <input type="text" id="experience" name="experience" required><br>
            <label for="education">学历:</label><br>
            <input type="text" id="education" name="education" required><br>
            <label for="job_type">工作性质:</label><br>
            <input type="text" id="job_type" name="job_type" required><br>
            <label for="job_address">工作地址:</label><br>
            <input type="text" id="job_address" name="job_address" required><br>
            <label for="detailed_address">详细地址:</label><br>
            <input type="text" id="detailed_address" name="detailed_address" required><br>
            <label for="phone">手机号:</label><br>
            <input type="text" id="phone" name="phone" required><br>
            <label for="company_id">公司:</label><br>
            <select id="company_id" name="company_id" required>
                <option value="">选择公司</option>
                <?php foreach ($companies as $company): ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <button type="submit">添加</button>
        </form>
    </div>
    <script>
        document.getElementById('addJobForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/jobs.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    window.location.href = '/admin/jobs.php';
                } else {
                    alert('添加失败。');
                }
            });
        });
    </script>
</body>
</html>
