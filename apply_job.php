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

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'job_id' => $_POST['job_id'],
        'user_id' => $user_id,
        'name' => $user['name'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'resume' => $_POST['resume']
    ];

    $query = "INSERT INTO applications (job_id, user_id, name, email, phone, resume) VALUES (:job_id, :user_id, :name, :email, :phone, :resume)";
    $stmt = $conn->prepare($query);

    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }

    if ($stmt->execute()) {
        $success = '申请成功！';
    } else {
        $error = '申请失败，请重试。';
    }
}

$job_id = $_GET['job_id'];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请职位</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>申请职位</h1>
    </header>
    <div class="container">
        <h2>申请表单</h2>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="apply_job.php?job_id=<?php echo $job_id; ?>">
            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
            <label for="resume">简历:</label>
            <textarea id="resume" name="resume" required></textarea>
            <button type="submit">提交申请</button>
        </form>
    </div>
    <script src="/js/scripts.js"></script>
</body>
</html>
