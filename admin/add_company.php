<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加新企业</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>添加新企业</h1>
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
        <h2>添加新企业</h2>
        <form id="addCompanyForm">
            <label for="name">企业名称:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="description">描述:</label><br>
            <textarea id="description" name="description" required></textarea><br>
            <label for="company_type">公司性质:</label><br>
            <input type="text" id="company_type" name="company_type" required><br>
            <label for="company_size">公司规模:</label><br>
            <input type="text" id="company_size" name="company_size" required><br><br>
            <button type="submit">添加</button>
        </form>
    </div>
    <script>
        document.getElementById('addCompanyForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/companies.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    window.location.href = '/admin/companies.php';
                } else {
                    alert('添加失败。');
                }
            });
        });
    </script>
</body>
</html>
