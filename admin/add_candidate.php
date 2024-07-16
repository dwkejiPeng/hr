<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加新人</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>添加新人</h1>
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
        <h2>添加新人</h2>
        <form id="addCandidateForm">
            <label for="name">姓名:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="gender">性别:</label><br>
            <input type="text" id="gender" name="gender" required><br>
            <label for="birthday">生日:</label><br>
            <input type="date" id="birthday" name="birthday" required><br>
            <label for="education">学历:</label><br>
            <input type="text" id="education" name="education" required><br>
            <label for="graduation_school">毕业学校:</label><br>
            <input type="text" id="graduation_school" name="graduation_school" required><br>
            <label for="major">专业:</label><br>
            <input type="text" id="major" name="major" required><br>
            <label for="title">职称:</label><br>
            <input type="text" id="title" name="title" required><br>
            <label for="phone">手机号:</label><br>
            <input type="text" id="phone" name="phone" required><br>
            <label for="email">邮箱:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <button type="submit">添加</button>
        </form>
    </div>
    <script>
        document.getElementById('addCandidateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/candidates.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    window.location.href = '/admin/candidates.php';
                } else {
                    alert('添加失败。');
                }
            });
        });
    </script>
</body>
</html>
