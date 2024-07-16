<?php
require_once 'api/db.php';
session_start();

if (!isset($_SESSION['company_id'])) {
    header('Location: company_login.php');
    exit();
}

$company_id = $_SESSION['company_id'];
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'company_type' => $_POST['company_type'],
        'company_size' => $_POST['company_size']
    ];

    $query = "UPDATE companies SET name=:name, description=:description, company_type=:company_type, company_size=:company_size WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $company_id);

    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }

    if ($stmt->execute()) {
        $success = '信息更新成功。';
    } else {
        $error = '信息更新失败，请重试。';
    }
}

$query = "SELECT * FROM companies WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $company_id);
$stmt->execute();

$company = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>完善企业信息</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>完善企业信息</h1>
    </header>
    <div class="container">
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="company_profile.php">
            <label for="name">企业名称:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $company['name']; ?>" required><br>
            <label for="description">描述:</label><br>
            <textarea id="description" name="description" required><?php echo $company['description']; ?></textarea><br>
            <label for="company_type">公司性质:</label><br>
            <input type="text" id="company_type" name="company_type" value="<?php echo $company['company_type']; ?>" required><br>
            <label for="company_size">公司规模:</label><br>
            <input type="text" id="company_size" name="company_size" value="<?php echo $company['company_size']; ?>" required><br><br>
            <button type="submit">更新信息</button>
        </form>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
