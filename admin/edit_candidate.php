<?php
require_once '../api/db.php';

class CandidateAdmin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getById($id) {
        $query = "SELECT * FROM candidates WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$candidateAdmin = new CandidateAdmin();
$candidate = $candidateAdmin->getById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑人才</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>编辑人才</h1>
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
        <h2>编辑人才</h2>
        <form id="editCandidateForm">
            <input type="hidden" id="id" name="id" value="<?php echo $candidate['id']; ?>">
            <label for="name">姓名:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $candidate['name']; ?>" required><br>
            <label for="gender">性别:</label><br>
            <input type="text" id="gender" name="gender" value="<?php echo $candidate['gender']; ?>" required><br>
            <label for="birthday">生日:</label><br>
            <input type="date" id="birthday" name="birthday" value="<?php echo $candidate['birthday']; ?>" required><br>
            <label for="education">学历:</label><br>
            <input type="text" id="education" name="education" value="<?php echo $candidate['education']; ?>" required><br>
            <label for="graduation_school">毕业学校:</label><br>
            <input type="text" id="graduation_school" name="graduation_school" value="<?php echo $candidate['graduation_school']; ?>" required><br>
            <label for="major">专业:</label><br>
            <input type="text" id="major" name="major" value="<?php echo $candidate['major']; ?>" required><br>
            <label for="title">职称:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $candidate['title']; ?>" required><br>
            <label for="phone">手机号:</label><br>
            <input type="text" id="phone" name="phone" value="<?php echo $candidate['phone']; ?>" required><br>
            <label for="email">邮箱:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $candidate['email']; ?>" required><br><br>
            <button type="submit">更新</button>
        </form>
    </div>
    <script>
        document.getElementById('editCandidateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/candidates.php', {
                method: 'PUT',
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/admin/candidates.php';
                } else {
                    alert('更新失败。');
                }
            });
        });
    </script>
</body>
</html>
