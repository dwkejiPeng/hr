<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加新设置</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>添加新设置</h1>
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
        <h2>添加新设置</h2>
        <form id="addSettingForm">
            <label for="key">键:</label><br>
            <input type="text" id="key" name="key" required><br>
            <label for="value">值:</label><br>
            <textarea id="value" name="value" required></textarea><br><br>
            <button type="submit">添加</button>
        </form>
    </div>
    <script>
        document.getElementById('addSettingForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/settings.php', {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    window.location.href = '/admin/settings.php';
                } else {
                    alert('添加失败。');
                }
            });
        });
    </script>
</body>
</html>
