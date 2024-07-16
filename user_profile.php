<?php
require_once 'api/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
        'education' => $_POST['education'],
        'graduation_school' => $_POST['graduation_school'],
        'major' => $_POST['major'],
        'title' => $_POST['title'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email']
    ];

    $query = "UPDATE users SET name=:name, gender=:gender, birthday=:birthday, education=:education, graduation_school=:graduation_school, major=:major, title=:title, phone=:phone, email=:email WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $user_id);

    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }

    if ($stmt->execute()) {
        $success = '信息更新成功。';
    } else {
        $error = '信息更新失败，请重试。';
    }
}

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $user_id);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>完善用户信息</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>完善用户信息</h1>
    </header>
    <div class="container">
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="user_profile.php">
            <label for="name">姓名:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <label for="gender">性别:</label>
            <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" required>
            <label for="birthday">生日:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>
            <label for="education">学历:</label>
            <input type="text" id="education" name="education" value="<?php echo htmlspecialchars($user['education']); ?>" required>
            <label for="graduation_school">毕业学校:</label>
            <input type="text" id="graduation_school" name="graduation_school" value="<?php echo htmlspecialchars($user['graduation_school']); ?>" required>
            <label for="major">专业:</label>
            <input type="text" id="major" name="major" value="<?php echo htmlspecialchars($user['major']); ?>" required>
            <label for="title">职称:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($user['title']); ?>" required>
            <label for="phone">手机号:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <label for="email">邮箱:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit">更新信息</button>
        </form>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
